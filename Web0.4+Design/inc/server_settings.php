<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
$server_db_info = $grizismudb->query("Select * From WebOptions")->fetchAll();
foreach($server_db_info as $info){
	$server[$info['WebOption']] = $info['Value'];
}
$server['AdminsIps'] = array('127.0.0.1','78.83.158.151');
$server['Name'] = "GrizisMu";
$server['Version'] = "97d+99i";
$server['Download_Files_Folder'] = "download";
$server['Server_Files_Folder'] = "E:/MuServer";
$server['Citys'] = array("Lorencia","Davias","Noria","LostTower","Exile","Stadium","Atlans","Tarkan","Icarus");
$server['Points']['start'] = 25; //start
$server['Points'][0] = 450; //DW
$server['Points'][1] = 450; //SM
$server['Points'][17] = 400;//DK
$server['Points'][18] = 400;//BK
$server['Points'][33] = 450;//ELF
$server['Points'][34] = 450;//ME
$server['Points'][48] = 460;//MG

$server['GetZenPerStoneArray'] = Array("25"=>1,"50"=>2,"100"=>3,"200"=>4,"400"=>5);

$server['AddLuckRenas'] = 50;

switch ($item_info['item_DB_info']['ex_type']) {
			case 0 :
				$options_arr = Array('Increase Mana per kill +8',
									'Increase hit points per kill +8',
									'Increase attacking(wizardly)speed+7',
									'Increase wizardly damage +2%',
									'Increase Damage +level/20',
									'Excellent Damage Rate +10%');
				break;
			case 1:
				$options_arr = Array('Increase Zen After Hunt +40%',
								'Defense success rate +10%',
								'Reflect damage +5%',
								'Damage Decrease +4%',
								'Increase MaxMana +4%',
								'Increase MaxHP +4%');
				break;
		}
		
$options_cost = Array(	'Increase Mana per kill +8' => 100,
						'Increase hit points per kill +8' => 110,
						'Increase attacking(wizardly)speed+7' => 120,
						'Increase wizardly damage +2%' => 130,
						'Increase Damage +level/20' => 120,
						'Excellent Damage Rate +10%' => 150,
						'Increase Zen After Hunt +40%' => 110,
						'Defense success rate +10%' => 140,
						'Reflect damage +5%' => 130,
						'Damage Decrease +4%' => 120,
						'Increase MaxMana +4%' => 100,
						'Increase MaxHP +4%' => 110,
						'Luck' => 50,
						'Per Level Add' => 15,
						'Skill' => 0); // renas
$jewels_cost = Array(	'Jewel of Chaos' => 1,
						'Jewel of Soul' => 4,
						'Jewel of Bless' => 3,
						'Jewel of Life' => 10,
						'Jewel of Creation' => 8);// renas




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
	$link[$i]['Link_Name'] = "Direct";
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
array_push($link,array('File_Name' => "GrizisMu.rar",'Size' => "77MB",'Link_Name' => "2shared.com",'Link' => "http://www.2shared.com/file/XxMvVVn7/GrizisMu.html"));
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