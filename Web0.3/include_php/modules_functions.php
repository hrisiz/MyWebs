<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
function read_files_from_folder($folder,$next_page = "subpage"){
	if (is_dir($folder)) 
	{
		if ($handle = opendir($folder)) 
		{
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && !is_dir($folder."/".$file))
				{
					$sub_page = explode(".",$file);
					$sub_page = $sub_page[0];
					$sub_page = str_replace("_"," ",$sub_page);
					$sub_page =ucwords($sub_page);
					$generated_page = "?";
					foreach($_GET as $k => $v){
						if($next_page != $k){
							$generated_page .= $k."=".$v."&";
						}else{
							break;
						}
					}
					print "<a href=\"$generated_page$next_page=$sub_page\"><button>$sub_page</button></a>";
				}
			}
		}
	}
}
function open_modul($folder,$default_file,$page_place = "subpage"){
	$page_name = $_GET[$page_place];
	$page_name = strtolower($page_name);
	$page_name = str_replace(" ","_",$page_name);
	$full_dir_file_name = $folder.$page_name.".php";
	if (!empty($page_name) && isset($page_name))
	{
		if (file_exists($full_dir_file_name)) {
			return filter($full_dir_file_name);
		} else {
			echo"
				<h1>Error 404</h1>
				<h2>Object not found!</h2>
			";
		}
	}
	else
	{
		return $folder.$default_file;
	}
}

?>