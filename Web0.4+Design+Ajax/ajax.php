<?php
	session_start();
	include "inc/sql_connect.php";
	include "inc/server_settings.php";
	include "inc/security.php";
	include "inc/modules_functions.php";
	include "inc/get_item_info.php";
	if(isset($_SESSION['User'])){
		$account = $_SESSION['User'];
	}
	$page = $_REQUEST['page'];
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
      echo"<h2>$name</h2>";
    }
		if (file_exists($page)) {
      include $page;
		}else{
			echo"
				<h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
			";
		}
	}
?>