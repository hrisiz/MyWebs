<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<ul id="RightMenu">
	<?php
		if(!isset($_GET['page']))
		{
			$_GET['page'] = "News";
		}
		$folder = "right_menu/".$_GET['page'];
		if (is_dir($folder)) 
		{
			if ($handle = opendir($folder)) 
			{
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..")
					{
						$sub_page = explode(".",$file);
						$sub_page = $sub_page[0];
						$sub_page = str_replace("_"," ",$sub_page);
						$sub_page =ucwords($sub_page);
						print "<li class=\"without_type\"><a href=\"?page=".$_GET['page']."&subpage=$sub_page\">$sub_page</a></li>";
					}
				}
			}
		}
	?>
</ul>