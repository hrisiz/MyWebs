<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
// if($_SESSION['User'] != 'Admin'){
  // echo "<p>Don't work for few minsutes.</p>";
  // return "";  
// }
if (isset($_POST['Reset'])){
	$char = $_POST['character'];
	if(!empty($char)){
		$char_info = $grizismudb->query("Select cLevel,Resets,Money,Class,QuestNumber,QuestMonsters,QuestInCurse,BonusPoints From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
		$reset_zen = $server['ZenForReset'] * ($char_info[0]['Resets']+1);
		$bank = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
		$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
		$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char'")->fetchAll();
		$inventory = str_split($inventory[0][0],20);
		$inventory = array_slice($inventory,0,12);	
		$inventory = array_diff($inventory,Array("FFFFFFFFFFFFFFFFFFFF"));
		$quest = $grizismudb->query("Select * From Quests Where QuestID=".$char_info[0]['QuestNumber']."")->fetchAll();
		if(count($char_info) <= 0){
			echo"<p class=\"error\">This isn't your character !</p>";
		}elseif(count($inventory) > 0){
			echo"<p class=\"error\">Please remove the items from the character.</p>";
		}elseif($is_online > 0){
			echo"<p class=\"error\">This account is Online</p>";
		}elseif($char_info[0][0] < $server['ResetLevel']){
			echo"<p class=\"error\">Low Character level!</p>";
		}elseif($char_info[0][1] >= $server['CurrentMaxRes']){
			echo"<p class=\"error\">This character is MAX current resets.Please wait to up them.</p>";
		}elseif($char_info[0][2] <$reset_zen && $bank[0][0] <$reset_zen){
			echo"<p class=\"error\">You don't have enough Zen !</p>";
		}else{
			$grizismudb->beginTransaction();
			if((count($grizismudb->query("Select * From Character Where Resets >= ".$server['CurrentMaxRes']."")->fetchAll()) == $server['MaxResUpOn']) && ($server['CurrentMaxRes'] < $server['MaxResets'])){
				$grizismudb->exec("Update WebOptions Set Value=Value+".$server['MaxResUpWith']." Where WebOption='CurrentMaxRes'");
				// $grizismudb->exec("Update WebOptions Set Value=Value+1 Where WebOption='MaxResUpOn'");
			}
			$error = 0;
			if ($char_info[0][2] >$reset_zen){
				$money = "Update Character Set Money = Money - ".$reset_zen." Where Name='$char' AND AccountId='$account'";
			}else{
				$money = "Update Bank Set Bank = Bank - ".$reset_zen." Where AccountId='$account'";
			}
			if($char_info[0]['QuestInCurse'] && $quest[0]['MonstersCount'] <= $char_info[0]['QuestMonsters']){
				$race = $char_info[0]['Class'];
				$races_numbers = array(0,16,32);
				if(in_array($race,$races_numbers))
					$race++;
				$items = $grizismudb->query("Select * From Items Where type=(Select top 1 type From Items Where c$race<>0 order by NEWID()) AND c$race<>0")->fetchAll();
				$random_item_number = rand(0,floor(($char_info[0]['Resets']/$server['MaxResets'])*count($items)));
				$options_number = rand(0,$char_info[0]['Resets']);
				$ex = array(0,0,0,0,0);
				for($i=0;$i < ((($options_number%5) != 0) ? 1:2);$i++)
					$ex[rand(0,4)] = 1;
				if(!add_item($items[$random_item_number]['type'],$items[$random_item_number]['id'],255,0,0,$items[$random_item_number]['skill'],rand(0,$items[$random_item_number]['luck']),$ex[0],$ex[1],$ex[2],$ex[3],$ex[4])){
					echo "<p class=\"error\">You don't have place in your warehouse</p>";
					$error = 1;
					$grizismudb->rollBack();
				}
				echo "";
			}else{
				echo "<p>You didn't complete your quest.</p>";
			}
			if($error != 1){	
				$bonus_points = ($server['BonusPointsPerLevel']*($char_info[0][0]-$server['ResetLevel']))+$char_info[0]['BonusPoints'];
				$new_points = $server['Points'][$char_info[0][3]]*($char_info[0][1]+1)+$bonus_points;
				$grizismudb->exec("Update Character Set clevel=1,Resets=Resets+1,Experience=0,PkLevel=3,PkCount=0,PkTime=0,MapNumber=0,MapPosY=125,MapPosX=128,LevelUpPoint=$new_points,Strength=".$server['Points']['start'].",Dexterity=".$server['Points']['start'].",Vitality=".$server['Points']['start'].",Energy=".$server['Points']['start'].",QuestNumber=(SELECT TOP 1 QuestID FROM Quests Where QuestID BETWEEN ".$char_info[0]['Resets']." AND ".($char_info[0]['Resets']+10)." ORDER BY NEWID()),QuestMonsters=0,QuestInCurse=1,BonusPoints=$bonus_points Where Name='$char' AND AccountId='$account'");
				$grizismudb->exec($money);
				$grizismudb->commit();
				echo"<p class=\"success\">$char was successfully restarted</p>";		
			}
		}
	}else{
		echo"<p>This is not a character !</p>";
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