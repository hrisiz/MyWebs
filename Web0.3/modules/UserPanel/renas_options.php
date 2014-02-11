
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
echo"<br><br><br>";
read_files_from_folder("modules/UserPanel/renas","renas_options");
include_once open_modul("modules/UserPanel/renas/","","renas_options");
?>