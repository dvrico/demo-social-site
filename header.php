<?php

// Set up session and html --------------------------------------------------*/

session_start();

echo "<!DOCTYPE html>\n<html><head>";

require_once 'functions.php';

$userstr = ' (Guest)';

// Display HTML depending on login info -------------------------------------*/

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $loggedin = TRUE;
  $userstr = " ($user)";
} else {
  $loggedin = FALSE;
}

// Default HTML regardless of login or not
echo "<title>$appname$userstr</title><link rel='stylesheet' " .
"href='styles.css' type='text/css'>"                          .
"</head><body><center><canvas id='logo' width='624' "         .
"height='96'>$appname</canvas></center>"                      .
"<div class='appname'>$appname$userstr</div>"                 .
"<script src='javascript.js'></script>";

//If logged in, give full access to site, else show limited options
if ($loggedin)
  echo "<br ><ul class='menu'>" .
       "<li><a href='members.php?view=$user'>Home</a></li>" .
       "<li><a href='members.php'>Members</a></li>"         .
       "<li><a href='friends.php'>Friends</a></li>"         .
       "<li><a href='messages.php'>Messages</a></li>"       .
       "<li><a href='profile.php'>Edit Profile</a></li>"    .
       "<li><a href='logout.php'>Log out</a></li>";
else
  echo ("<br><ul class='menu'>" .
        "<li><a href='index.php'>Home</a></li>"               .
        "<li><a href='signup.php'>Sign up</a></li>"           .
        "<li><a href='login.php'>Log in</a></li>"             .
        "<span class='info'>&#8658; You must be logged in to" .
        "view this page.</span><br><br>");

?>
