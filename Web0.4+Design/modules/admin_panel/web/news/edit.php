<?php
  
  $news_info = $grizismudb->query("Select * From News Where Id=".$_GET['newsid']."")->fetchAll();
  if(count($news_info) > 0){
    $news_info = $news_info[0];
  }else{
    echo"<p class=\"error\">Wrong News ID.</p>";
    return "";
  }
  if(isset($_POST['EditNews'])){
    $grizismudb->exec("Update News Set Title='".$_POST['Save_title']."',News='".$_POST['Save_news']."',PostedBy='$account',LastUpdate=".time()." Where ID=".$_GET['newsid']."");
    echo "<p class=\"success\">successful</p>";
    sleep(1);
    header("Location: /?page=Modules_Admin-Panel_Web_News");
  }
?>
<form method="POST">
  <label for="title">Title</label>
  <input id="title" type="text" name="Save_title" value="<?=$news_info['Title']?>"><br>
  <label>Content</label>
  <textarea name="Save_news"><?=$news_info['News']?></textarea><br>
  <input onclick="startLoading()" type="submit" name="EditNews" value="Edit">
</form>