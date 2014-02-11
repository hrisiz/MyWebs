<?php
$page_name = $_GET['page'];
$full_dir_file_name = "modules/".$page_name.".php";
if (!empty($page_name) && isset($page_name))
{
	if (file_exists($full_dir_file_name)) {
		include $full_dir_file_name;
	} else {
		echo"
			<h1>Error 404</h1>
			<h2>Object not found!</h2>
		";
	}
}
else
{
	include_once "modules/News.php";
}
?>