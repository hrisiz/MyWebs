<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>

<button onclick='loadAjaxPage("Modules_User-Panel_Web-Market&subpage=Sell","content");'>Sell Item</button>
<button onclick='loadAjaxPage("Modules_User-Panel_Web-Market&subpage=Buy","content");'>Buy Item</button>
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