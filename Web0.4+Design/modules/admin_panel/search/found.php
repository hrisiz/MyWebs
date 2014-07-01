<?php
  if(!in_array($_SERVER['REMOTE_ADDR'],$server['AdminsIps'])){
    echo "<p>You should be Admin for this page.</p>";
    return '';
  }
?>
