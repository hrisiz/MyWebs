
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

$server['Name'] = "GrizisMu";
$server['Version'] = "97d+99i";
$server['Download_Files_Folder'] = "download";
$server['Server_Files_Folder'] = "D:/MuServer";
$server['Citys'] = array("Lorencia","Davias","Noria","LostTower","Exile","Stadium","Atlans","Tarkan","Icarus");
$server['MaxLevel'] = 350;
$server['ResetLevel'] = 340;
$server['MaxResets'] = 40;
$server['MaxGrandResets'] = 10;
$server['ZenForReset'] = 50000000;
$server['ZenForGrandReset'] = 2000000000;
$server['ClearStatsZen'] = 500000000;
$server['ClearPK'] = 5000000;
$server['AddStatZen'] = 1000000000;
$server['BonusPointsPerLevel'] = 5;
$server['Points']['start'] = 25; //DW
$server['Points']['0'] = 500; //DW
$server['Points']['1'] = 500; //SM
$server['Points']['17'] = 700;//DK
$server['Points']['18'] = 700;//BK
$server['Points']['33'] = 550;//ELF
$server['Points']['34'] = 550;//ME
$server['Points']['48'] = 600;//MG

$server['ChangeNameStones'] = 1;
$server['ChangeRaceStones'] = 1;
$server['ClearStatsStones'] = 1;
$server['GetZenPerStoneArray'] = Array("25"=>1,"50"=>2,"100"=>3,"200"=>4,"400"=>5);
$server['GetZenPerStone'] = 4000000;

$server['AddLuckRenas'] = 50;






if ($handle = opendir($server['Download_Files_Folder'])) {
	$i = 0;
	while (false !== ($entry = readdir($handle))) {
		if($entry != "." && $entry != "..")
		{
			$link[$i]['Link'] = $server['Download_Files_Folder']."/".$entry;
			$i++;
		}
    }
	closedir($handle);
}
for ($i = 0; $i < count($link); $i++)
{
	$link[$i]['File_Name'] = explode("/",$link[$i]['Link']);
	$link[$i]['File_Name'] = end($link[$i]['File_Name']);
	$link[$i]['Size'] = floor(filesize($link[$i]['Link']) / 1024);
	if ($link[$i]['Size'] >= 1024)
	{
		$link[$i]['Size'] = floor(filesize($link[$i]['Link']) / 1000 / 1024);
		if ($link[$i]['Size'] >= 1024)
		{
			$link[$i]['Size'] = floor(filesize($link[$i]['Link']) / 1000 / 1024 / 1024)."TB";
		}
		else
		{
			$link[$i]['Size'] .= "MB";
		}
	}
	else
	{
		$link[$i]['Size'] .= "KB";
	}
}
if ($fp=@fsockopen('127.0.0.1','55901',$ERROR_NO,$ERROR_STR,(float)0.5)) 
{ 
	fclose($fp); 
	$server['Stats'] = "<span class='success'>Online</span>";
}
else 
{ 
	$server['Stats'] = "<span class='error'>Offline</span>";
} 
$commonserver_cfg = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/commonserver.cfg"));
$server['Experience'] = explode("=",$commonserver_cfg[5]);
$server['Experience'] = trim(end($server['Experience'])."x");
$server['Drop'] = explode("=",$commonserver_cfg[21]);
$server['Drop'] = trim(end($server['Drop'])."%");
$server['Accounts'] = count($grizismudb->query("Select * From MEMB_INFO")->fetchAll());
$server['Characters'] = count($grizismudb->query("Select * From Character Where CtlCode<>8 OR CtlCode IS NULL")->fetchAll());
$server['Guilds'] = count($grizismudb->query("Select * From Guild")->fetchAll());
$server['Online_Players'] = count($grizismudb->query("Select * From	MEMB_STAT Where ConnectStat=1")->fetchAll());
?>