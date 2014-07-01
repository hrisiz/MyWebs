<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}


$page = $_GET['page'];
if(!empty($page) && isset($page)){
  $name = explode("_",$page);
  $name = str_replace("-"," ",array_slice($name,-1)[0]);	
  $page = str_replace("_","/",$page);
  $page = str_replace("-","_",$page);
  $page = strtolower($page);
  $page = $page.".php";
  if($name != "Get Items"){
    if(isset($_SESSION['User'])){
      include "modules/user_options.php";
    }
    if(preg_match('/admin_panel/',$page) && ($_SESSION['User']!="Admin" || !in_array($_SERVER['REMOTE_ADDR'],$server['AdminsIps']))){
      echo "<p class=\"error\">Only admins can access this page!</p>";
      return '';
    }
    if(($_SESSION['User']=="Admin" || in_array($_SERVER['REMOTE_ADDR'],$server['AdminsIps'])) && isset($_SESSION['User'])){
      include "modules/admin_options.php";
    }
    echo"<h2>$name</h2>";
  }
  if (file_exists($page)) {
    include $page;
  }else{
    echo"
      <h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
    ";
  }
}else{
  if(isset($_SESSION['User'])){
    include "modules/user_options.php";
  }
  echo"<h2>News</h2>";
	include "modules/news.php";
}
?>
	