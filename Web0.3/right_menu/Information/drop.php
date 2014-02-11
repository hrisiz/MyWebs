
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
echo "<ol id=\"inline\">";
for ($i = 1; $i <= 5;$i++)
{
	echo"<li class=\"inline\"><a href=\"?page=Information&subpage=Drop&Box=$i\">Box +$i</a></li>";
}
echo "</ol>";
echo "<ol>";
if (!isset($_GET['Box']))
{
	$_GET['Box'] = 1;
}
$box_full = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/eventitembag".($_GET['Box']+7).".txt"));
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
</ol>