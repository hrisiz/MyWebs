<?php
  
  if(isset($_POST['AddNews'])){
    // $order   = array("\r\n", "\n", "\r");
    // $replace = '<br />';
    $content = str_replace($order, $replace, $_POST['Save_news']);
    $grizismudb->exec("Insert Into News values('".$_POST['Save_title']."','$content','$account',".time().")");
    echo "<p class=\"success\">successful</p>";
    sleep(1);
    header("Location: /?page=Modules_Admin-Panel_Web_News");
  }
?>
<form method="POST">
  <label for="title">Title</label>
  <input id="title" type="text" name="Save_title"><br>
  <label for="news">Content</label>
  <textarea id="news" type="text" name="Save_news"></textarea><br>
  <input onclick="startLoading()" type="submit" name="AddNews" value="Add">
</form>