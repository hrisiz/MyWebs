<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>

<a href="?page=Modules_User-Panel_Web-Market&market=Sell"><button>Sell Item</button></a>
<a href="?page=Modules_User-Panel_Web-Market&market=Buy"><button>Buy Item</button></a>
<?php
$page = $_GET['market'];
if(!empty($page) && isset($page)){
	$page = strtolower($page);
	$page = "modules/user_panel/web_market/".$page.".php";
	if (file_exists($page)) {
		include $page;
	}else{
		echo"
			<h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
		";
	}
}else{
	include "modules/user_panel/web_market/buy.php";
}
?>