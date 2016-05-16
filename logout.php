<?php

  require_once 'header.php';

// To logout, simply destroy session
  if (isset($_SESSION['user'])) {
    destroySession();
    echo "<div class='main'>You have been logged out. Please " .
         "<a href='index.php'>click here</a> to go to the home page.";
  }

 ?>
