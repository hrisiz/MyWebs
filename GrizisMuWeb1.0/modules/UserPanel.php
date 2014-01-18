
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
$folder = "right_menu/UserPanel/";
$page_name = $_GET['subpage'];
$page_name = strtolower($page_name);
$page_name = str_replace(" ","_",$page_name);
$full_dir_file_name = $folder.$page_name.".php";
if(empty($account)){
	echo"<p class=\"error\">You don't have access to this page.Login and try again.</p>";
}
elseif (!empty($page_name) && isset($page_name))
{
	include_once "modules/ControlPanel.php";
	if (file_exists($full_dir_file_name)) {
		include_once $full_dir_file_name;
	} 
	elseif(file_exists("modules/UserPanel/".$page_name.".php"))
	{
		include_once "modules/UserPanel/".$page_name.".php";
	}
	elseif($_GET['subpage'] == "LogOut")
	{
		unset($_SESSION['LoggedUser']);
		echo"<p class='success'>Loading...</p>";
		echo"<script>setTimeout(function(){redirect('?page=News')},2000);</script>";
	}
	else {
		echo"
			<h1>Error 404</h1>
			<h2>Object not found!</h2>
		";
	}
}
else
{
	include_once "modules/ControlPanel.php";
}
?>