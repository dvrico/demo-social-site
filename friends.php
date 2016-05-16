<?php

require_once 'header.php';

if (!$loggedin) die();

if(isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else                     $view = $user;

if ($view == $user) {
  $name1 = $name2 = "Your";
  $name3 = "You are";
}
else {
  $name1 = "<a href='member.php?view'>$view</a>'s";
  $name2 = "$view's";
  $name3 = "$view is";
}

echo "<div class='main'>";

// Retrieve relationship info for user and store them in two different arrays

$followers = array();
$following = array();

$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
$num = $result->num_rows;

for ($j = 0 ; $j < $num ; ++$j) {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $followers[$j] = $row['friend'];
}

$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
$num = $result->num_rows;

for ($j = 0; $j < $num ; ++$j) {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  $following[$j] = $row['user'];
}

// Intersect arrays to find mutual friends and further split them to find
// followers and following

$mutual = array_intersect($followers, $following);
$followers = array_diff($followers, $mutual);
$following = array_diff($following, $mutual);
$friends = FALSE;

// Display information if array contains elements

if (sizeof($mutual)) {
  echo "<span class='subhead'>$name2 mutual friends</span><ul>";
  foreach($mutual as $friend)
    echo "<li class='friend'><a href='members.php?view=$friend'>$friend</a>";
  echo "</ul>";
  $friends = TRUE;
}

if (sizeof($followers)) {
  echo "<span class='subhead'>$name2 followers</span><ul>";
  foreach($followers as $friend)
    echo "<li class='friend'><a href='members.php?view=$friend'>$friend</a>";
  echo "</ul>";
  $friends = TRUE;
}

if (sizeof($following)) {
  echo "<span class='subhead'>$name3 following</span><ul>";
  foreach($following as $friend)
    echo "<li class='friend'><a href='members.php?view=$friend'>$friend</a>";
  echo "</ul>";
  $friends = TRUE;
}

if (!$friends) echo "<br> You don't have any friends yet.<br><br>";

// Option to view messages
echo "<a class='button' href='messages.php?view=$view'>" .
     "View $name2 messages</a>";

?>

    </div><br>
  </body>
</html>
