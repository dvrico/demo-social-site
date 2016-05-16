<?php

require_once 'functions.php';

// Used in the ajax request to check username availability
if (isset($_POST['user'])) {
  $user = sanitizeString($_POST['user']);
  $result = queryMysql("SELECT * FROM members WHERE user='$user'");

  if ($result->num_rows)
    echo "<span class='taken'>&nbsp;&#x2715; " .
      "This username is taken</span>";
  else
    echo "<span class='available'>&nbsp;&#x2713; " .
      "This username is available</span>";

}

?>
