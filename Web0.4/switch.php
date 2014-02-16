<?php
	$page = $_GET['page'];
	if(!empty($page) && isset($page)){
		$name = explode("_",$page);
		$name = str_replace("-"," ",array_slice($name,-1)[0]);
		echo"<h1>$name</h1>";
	}else{
		echo"<h1>Home</h1>";
	}
	echo"<div style=\"height:80px; width:80%; background-color:white; margin-left:auto; margin-right:auto;\"></div>";
	if(!empty($page) && isset($page)){
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
	}else{
		include "modules/home.php";
	}
?>