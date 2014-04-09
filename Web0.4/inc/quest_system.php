<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
function Synch_Quests(){
	global $grizismudb;
	global $server;
	$file_content = file_get_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",FILE_TEXT,NULL,0,2429);
	$start = substr ($file_content,0,2429);
	$quests = $grizismudb->query("Select * From Quests")->fetchAll();
	$bigString = $start."\r\n";
	foreach($quests as $row){
		$bigString .= "\t".$row['QuestID'];
		$bigString .= "\t".$row['MinPlayerLevel'];
		$bigString .= "\t".$row['MinPlayerReset'];
		$bigString .= "\t".$row['MinPlayerGrandReset'];
		$bigString .= "\t".$row['MonsterID'];
		$bigString .= "\t".$row['Map'];
		$bigString .= "\t".$row['MonstersCount'];
		$bigString .= "\t\"-\"";
		$bigString .= "    		                \"-\"";
		$bigString .= "     	                \"-\"";
		$bigString .= "                           \t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\t0";
		$bigString .= "\r\n";
	}
	$bigString .= "// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
	file_put_contents ($server['Server_Files_Folder']."/DTData/QuestSystem.ini",$bigString);
	return $file_content;
}
?>