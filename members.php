<?php

require_once 'header.php';

if (!$loggedin) die();

echo "<div class='main'>";

//Display profile depending on whether the user is viewing thier own or another member

if (isset($_GET['view'])) {
  $view = sanitizeString($_GET['view']);

  if ($view == $user) $name = "Your";
  else                $name = "$view's";

  echo "<h3>$name Profile</h3>";
  showProfile($view);
  echo "<a class='button' href='messages.php?view=$view'>" .
       "View $name messages</a><br><br>";
  die("</div></body></html>");
}

// When the 'follow' or 'recip' link is clicked, add that data to the db.

if (isset($_GET['add'])) {
  $add = sanitizeString($_GET['add']);

  $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
  if (!$result->num_rows)
    queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
}
elseif (isset($_GET['remove'])) {  // Likewise with the 'drop' link, remove the data from the db
  $remove = sanitizeString($_GET['remove']);
  queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

// Fetch all members from db and display them

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

echo "<h3>Other Members</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j) {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  if ($row['user'] == $user) continue;

  echo "<li class='member'><a href='members.php?view=" .
    $row['user'] . "'>" . $row['user'] . "</a>";
  $follow = "follow";

// Within for loop, figure out relationship between each member and user and display it.

  $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
  $t1 = $result1->num_rows;
  $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
  $t2 = $result1->num_rows;

// Display relationship between user and member
  if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
  elseif ($t1)         echo " &larr; you are following";
  elseif ($t2)       { echo " &rarr; is following you";
    $follow = "recip"; }

// Give the option to follow other members or drop current friends
  if (!$t1) echo " [<a href='members.php?add="    .
    $row['user'] . "'>$follow</a>]";
  else      echo " [<a href='members.php?remove=" .
    $row['user'] . "'>drop</a>]";
}
?>

    </ul></div>
  </body>
</html>
