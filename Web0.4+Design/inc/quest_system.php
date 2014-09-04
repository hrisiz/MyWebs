<?php
function getMonstersCount($monsterID){
  global $server;
  $monsters_spots = explode("\r\n",file_GET_contents($server['Server_Files_Folder']."/Data/MonsterSetBase.txt"));
  $my_monsters = preg_grep('/^'.$monsterID.'\t/',$monsters_spots);
  if(count($my_monsters) <= 0){
    return 0;
  }
  $monsters_result = 0;
  $spots_result = 0;
  foreach($my_monsters as $monster){
    $monster_info = explode("\t",$monster);
    if(count($monster_info) <= 6){
      $monsters_result += 5;
    }elseif($monster_info[2] > 10){
      $monsters_result += end($monster_info)*5;
    }else{
      $spots_result = end($monster_info)*30;
    }
  }
  $result = $spots_result;
  if($spots_result == 0){
    $result = $monsters_result;
    if($result > 200){
      $result = floor($result/2);
    }
  }
  return $result; //count to kill
}
function writeQuestsFile(){
  global $grizismudb;
  global $server;
  $file_content = file_get_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",FILE_TEXT,NULL,0,2429);
  $start = substr ($file_content,0,2429);
  $quests = $grizismudb->query("Select * From Quests")->fetchAll();
  $grizismudb->exec("Delete From Quests");
  $grizismudb->exec("DBCC CHECKIDENT (Quests, reseed, 0)");
  $bigString = $start."\r\n";
	$monster = explode("\n",file_get_contents($server['Server_Files_Folder']."/Data/Monster.txt"));
	$ordered_quests = Array();
  foreach($quests as $row){
		$monster_level = explode("\"",$monster[$row['MonsterID']]);
		$monster_level = explode("\t",$monster_level[2]);
		$monster_level = $monster_level[1];
		if(!isset($ordered_quests[$monster_level])){
			$ordered_quests[$monster_level] = array();
		}
		array_push($ordered_quests[$monster_level],Array('MonsterID' => $row['MonsterID'],'MonstersCount' =>$row['MonstersCount']));
	}
	ksort($ordered_quests);
	$i = 1;
  foreach($ordered_quests as $questa){
		foreach($questa as $row){
			print_r($row);
			$bigString .= "\t".$i++;
			$bigString .= "\t0";
			$bigString .= "\t0";
			$bigString .= "\t0";
			$bigString .= "\t".$row['MonsterID'];
			$bigString .= "\t-1";
			$bigString .= "\t".$row['MonstersCount'];
			$monster_name = explode("\"",$monster[$row['MonsterID']]);
			$monster_name = str_replace('	',' ',$monster_name[1]);
			$bigString .= "\t\"Kill ".$row['MonstersCount']." $monster_name\"";
			$bigString .= "    		                \"-\"";
			$bigString .= "     	                \"Random item for your character class.\"";
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
			$grizismudb->exec("Insert Into Quests values(".$row['MonsterID'].",".$row['MonstersCount'].",1)");
		}
  }
  $bigString .= "// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
	file_put_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",$bigString);
}
function generateQuests(){
  global $grizismudb;
  $grizismudb->exec("Delete From Quests");
  $grizismudb->exec("DBCC CHECKIDENT (Quests, reseed, 0)");
  writeQuestsFile();
  $bad_monsters = array(52,53,78,79,80,81,82,83);
	$max_monster_id = 83;
  for($monster=0;$monster < $max_monster_id;$monster++){
    if(!in_array($monster,$bad_monsters)){
      $count = getMonstersCount($monster);
			$type = 1;
      if($count > 0){
        $grizismudb->exec("Insert Into Quests values(".$monster.",".$count.",$type)");
      }
    }
  }
  writeQuestsFile();
}