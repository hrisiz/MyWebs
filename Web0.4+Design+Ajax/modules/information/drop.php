<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}

echo "<ul class=\"information\">";
if (!isset($_REQUEST['Box']))
{
	$_REQUEST['Box'] = 1;
}
$box_full = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/eventitembag".($_REQUEST['Box']+7).".txt"));
foreach($box_full as $box)
{
	$type = explode("//",$box);
	$type = explode("\t",$type[0]);
	if (count($type) > 2)
	{
		$id = $type[1];
		$type = $type[0];
		$code = $grizismudb->query("Select name From Items Where id=$id AND type=$type")->fetchAll();
		print"<li class='without_type'>".$code[0][0]."</li>";
	}
}
?>
</ul>