<?php

  require_once 'header.php';

  echo "<div class='main'><h3>Please enter your details to log in</h3>";
  $error = $user = $pass = "";

  if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br>";
    else { //Change queryMySQL to queryMysql to see if it still works. How is this working!?!?
      $result = queryMySQL("SELECT user, pass FROM members WHERE user='$user' AND pass='$pass'");
      //printf($result->num_rows);
      if ($result->num_rows == 0) {
        $error = "<span class=error>Username/Password invalid</span><br><br>";
      }
      else {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die("You are now logged in. Please <a href='members.php?view=$user'>" .
            "click here</a> to continue.<br><br>");
      }
    }
  }

  echo <<<_END
    <form method='post' action='login.php'>$error
    <input class='fieldname' placeholder='Username' type='text' maxlength='16' name='user' value='$user'><br>
    <input class='fieldname' placeholder='Password' type='password' maxlength='16' name='pass' value='$pass'><br>
_END;

?>

    <br>
    <span class="fieldname">&nbsp;</span>
    <input class="submit" type='submit' value='Login'>
    </form><br></div>
  </body>
</html>
