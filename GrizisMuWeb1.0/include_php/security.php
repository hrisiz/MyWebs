<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
	
	if($_SESSION['last_session_request'] > time()-2){
	header("location: flood.html");
	exit;
	}
	$_SESSION['last_session_request'] = time();
	
?>