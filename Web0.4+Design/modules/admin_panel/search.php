<?php
  if(!in_array($_SERVER['REMOTE_ADDR'],$server['AdminsIps'])){
    echo "<p>You should be Admin for this page.</p>";
    return '';
  }
?>
<form action="/?page=Modules_Admin-Panel_Search_Found" method="POST">
  <label for="char">Character:</label>
  <input id="char" type="text" name="character"><br>
  <input type="submit" name="search_admin_char" value="Search">
</form>