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
  return $result+rand(0,200); //count to kill
}
function writeQuestsFile(){
  global $grizismudb;
  global $server;
  $file_content = file_get_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",FILE_TEXT,NULL,0,2429);
  $start = substr ($file_content,0,2429);
  $quests = $grizismudb->query("Select * From Quests")->fetchAll();
  $bigString = $start."\r\n";
	$monster = explode("\n",file_get_contents($server['Server_Files_Folder']."/Data/Monster.txt"));
  foreach($quests as $row){
    $bigString .= "\t".$row['QuestID'];
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
    $bigString .= "     	                \"Random item for your character.\"";
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
  file_put_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",$bigString);
}
// function add_item_types_to_DB(){
  // global $server;
  // global $grizismudb;
  // $counter = 1;
  // $file_content = file_get_contents($server['Server_Files_Folder']."/Data/lang/kor/item(Kor).txt");
  // $type = 0;
  // foreach(explode("\r\n",$file_content) as $row){
    // $cols = explode("\t",$row);
    // if(preg_match('/^(\d|\d\d)$/',$row)){
      // $type = intval($row);
    // }
    // if(preg_match('/^\d/',$row) && count($cols) > 6){
      // $arr = array_slice($cols, -4, 4);
      // echo substr($cols[6],1,-1).":".$arr[0].$arr[1].$arr[2].$arr[3]."<br>" ;
      
      // $grizismudb->query("Update Items Set c1=$arr[0],c17=$arr[1],c33=$arr[2],c48=$arr[3] Where id=$cols[0] AND type=$type");
      // $counter++;
    // }
  // }
// }
function synch_file_with_db(){
	$file_content = file_get_contents($server['Server_Files_Folder']."/DTData/QuestSystem.ini",FILE_TEXT,NULL,2429,-1);
	echo $file_content;
}
function generateQuests(){
	synch_file_with_db();
  // global $grizismudb;
  // global $server;
  // $grizismudb->exec("Delete From Quests");
  // $grizismudb->exec("DBCC CHECKIDENT(Quests,reseed,0)");
  // writeQuestsFile();
  // $bad_monsters = array(52,53,59,78,79,80,81,82,83);
	// $max_monster_id = 83;
	// for($monster=0;$monster < $max_monster_id;$monster++){
		// if(!in_array($monster,$bad_monsters)){
			// $count = getMonstersCount($monster);
			// if($count > 0){
				// $type = "1";
				// for($i = 0;$i <= ceil(($server['MaxResets']*10)/$max_monster_id)+$no_monsters;$i++){
					// $grizismudb->exec("Insert Into Quests values(".$monster.",".getMonstersCount($monster).",".$type.")");
				// }
				// $no_monsters = 0;
			// }
		// }else{
			// $no_monsters += 1;
		// }
	// }
  // writeQuestsFile();
}