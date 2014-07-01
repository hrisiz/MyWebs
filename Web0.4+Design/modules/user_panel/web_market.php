<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>

<a href="/?page=Modules_User-Panel_Web-Market&subpage=Sell"><button>Sell Item</button></a>
<a href="/?page=Modules_User-Panel_Web-Market&subpage=Buy"><button>Buy Item</button></a>
<?php
$page = $_REQUEST['subpage'];
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