<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if (isset($_POST['Reset'])){
	$char = $_POST['character'];
	$char_info = $grizismudb->query("Select cLevel,Resets,Money,Class,QuestNumber,QuestMonsters,QuestInCurse From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
	$bank = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char'")->fetchAll();
	$inventory = str_split($inventory[0][0],20);
	$inventory = array_slice($inventory,0,12);	
	$inventory = array_diff($inventory,Array("FFFFFFFFFFFFFFFFFFFF"));
  $quest = $grizismudb->query("Select * From Quests Where QuestID=".$char_info[0]['QuestNumber']."")->fetchAll();
	if(count($char_info) <= 0){
		echo"<p class=\"error\">This isn't your character !</p>";
	}elseif($char_info[0]['QuestInCurse'] && $quest[0]['MonstersCount'] > $char_info[0]['QuestMonsters']){
  	echo"<p class=\"error\">You must end your quest.</p>";
  }elseif(count($inventory) > 0){
		echo"<p class=\"error\">Please remove the items from the character.</p>";
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif($char_info[0][0] < $server['ResetLevel']){
		echo"<p class=\"error\">Low Character level!</p>";
	}elseif($char_info[0][1] > $server['MaxResets']){
		echo"<p class=\"error\">This character is MAX!</p>";
	}elseif($char_info[0][2] < $server['ZenForReset'] && $bank[0][0] < $server['ZenForReset']){
		echo"<p class=\"error\">You don't have enough Zen !</p>";
	}else{
		if ($char_info[0][2] > $server['ZenForReset']){
			$money = "Update Character Set Money = Money - ".$server['ZenForReset']." Where Name='$char' AND AccountId='$account'";
		}else{
			$money = "Update Bank Set Bank = Bank - ".$server['ZenForReset']." Where AccountId='$account'";
		}
    $grizismudb->beginTransaction();
    get_quest_item($char_info);
    
		$new_points = $server['Points'][$char_info[0][3]]*$char_info[0][1]+($server['BonusPointsPerLevel']*($server['MaxLevel']-$server['ResetLevel']-($server['MaxLevel']-$char_info[0][0])));
		$grizismudb->exec("Update Character Set cLevel=1,Resets=Resets+1,Experience=0,PkLevel=3,PkCount=0,PkTime=0,MapNumber=0,MapPosY=125,MapPosX=128,LevelUpPoint=$new_points,Strength=".$server['Points']['start'].",Dexterity=".$server['Points']['start'].",Vitality=".$server['Points']['start'].",Energy=".$server['Points']['start'].",QuestNumber=(SELECT TOP 1 QuestID FROM Quests ORDER BY NEWID()),QuestMonsters=0,QuestInCurse=1 Where Name='$char' AND AccountId='$account'");
		$grizismudb->exec($money);
    $grizismudb->commit();
		echo"<p class=\"success\">$char was successfully restarted</p>";		
	}
}
?>
<form Method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars("Resets","Resets");?>
	</select><br>
	<input onclick="startLoading()" type="submit" value="Reset" name="Reset"/>
</form>