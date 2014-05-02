
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if (!isset($_GET['city']))
{
	$_GET['city'] = "Lorencia";
}
$monster = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/Monster.txt"));
for ($i = 0; $i <= count($monster); $i++)
{
	$monstera = explode("\"",$monster[$i]);
	$id = explode("\t",$monster[$i]);
	$monsters[$id[0]] = $monstera[1];
}
?>
<table class="information">
<tr><th>Monster</th><th>Cordinates</th><th>Count</th><th>Type</th></tr>
<?php
	$monsters_spots = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/MonsterSetBase.txt"));
	for($i = 0; $i <= count($monsters_spots); $i++)
	{
		//$location = "";
		$spot = explode("\t",$monsters_spots[$i]);
		if (!empty($spot[2]) || isset($spot[2]))
		{
			if ($spot[1] == 0) {$location = "Lorencia";}
			elseif ($spot[1] == 1) {$location = "Dungeon";}
			elseif ($spot[1] == 2) {$location = "Davias";}
			elseif ($spot[1] == 3) {$location = "Noria";}
			elseif ($spot[1] == 4) {$location = "LostTower";}
			elseif ($spot[1] == 5) {$location = "Exile";}
			elseif ($spot[1] == 6) {$location = "Stadium";}
			elseif ($spot[1] == 7) {$location = "Atlans";}
			elseif ($spot[1] == 8) {$location = "Tarkan";}
			elseif ($spot[1] == 10) {$location = "Icarus";}
			if ($location == $_GET['city'] && $spot[2] < 10 && count($spot) > 6 )
			{
				if ($spot[3] == $spot[5] && $spot[4] == $spot[6])
				{
					$type = "Point";
					$cords = "$spot[3] , $spot[4]";
				}
				else
				{
					$type = "Range";
					$cords = floor($spot[5]-($spot[5]-$spot[3])/2) ." , ". floor($spot[6]-($spot[6]-$spot[4])/2);
				}
				if ($spot[2] == 0){$type_1 = "Static";}
				else{$type_1 = "Dynamic";}
				print "<tr><td>".$monsters[$spot[0]]."</td><td>$cords</td><td>$spot[8]</td><td>$type $type_1</td></tr>";
			}
		}
	}
?>
</table>