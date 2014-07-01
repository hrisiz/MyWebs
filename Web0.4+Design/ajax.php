<?php
	if(isset($_SESSION['last_session_request']) && $_SESSION['last_session_request'] > time()-5){
    header("location: flood.html");
    exit;
	}
	$_SESSION['last_session_request'] = time();
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
		if (file_exists($page)) {
      include $page;
		}else{
			echo"
				<h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
			";
		}
	}
?>