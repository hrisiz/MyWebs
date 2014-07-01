<?php
  
  $news_info = $grizismudb->query("Select * From News Where Id=".$_GET['newsid']."")->fetchAll();
  if(count($news_info) > 0){
    $news_info = $news_info[0];
  }else{
    echo"<p class=\"error\">Wrong News ID.</p>";
    return "";
  }
  $grizismudb->exec("Delete From News Where ID=".$_GET['newsid']."");
  sleep(1);
  header("Location: /?page=Modules_Admin-Panel_Web_News");
?>