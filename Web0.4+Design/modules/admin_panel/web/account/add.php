<?php
  
  if(isset($_POST['AddNews'])){
    $order   = array("\r\n", "\n", "\r");
    $replace = '<br />';
    $content = str_replace($order, $replace, $_POST['news']);
    $grizismudb->exec("Insert Into News values('".$_POST['title']."','$content','$account',".time().")");
    echo "<p class=\"success\">successful</p>";
    sleep(1);
    header("Location: /?page=Modules_Admin-Panel_Web_News");
  }
?>
<form method="POST">
  <label for="title">Title</label>
  <input id="title" type="text" name="title"><br>
  <label for="news">Content</label>
  <textarea id="news" type="text" name="news"></textarea><br>
  <input onclick="startLoading()" type="submit" name="AddNews" value="Add">
</form>