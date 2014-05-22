<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if (isset($_POST['Reset'])){
	$char = $_POST['character'];
	$arr = $grizismudb->query("Select cLevel,Resets,Money,Class From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
	$bank = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char'")->fetchAll();
	$inventory = str_split($inventory[0][0],20);
	$inventory = array_slice($inventory,0,12);	
	$inventory = array_diff($inventory,Array("FFFFFFFFFFFFFFFFFFFF"));
	if(count($arr) <= 0){
		echo"<p class=\"error\">This isn't your character !</p>";
	}elseif(count($inventory) > 0){
		echo"<p class=\"error\">Please remove the items from the character.</p>";
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif($arr[0][0] < $server['ResetLevel']){
		echo"<p class=\"error\">Low Character level!</p>";
	}elseif($arr[0][1] > $server['MaxResets']){
		echo"<p class=\"error\">This character is MAX!</p>";
	}elseif($arr[0][2] < $server['ZenForReset'] && $bank[0][0] < $server['ZenForReset']){
		echo"<p class=\"error\">You don't have enough Zen !</p>";
	}else{
		if ($arr[0][2] > $server['ZenForReset']){
			$money = "Update Character Set Money = Money - ".$server['ZenForReset']." Where Name='$char' AND AccountId='$account'";
		}else{
			$money = "Update Bank Set Bank = Bank - ".$server['ZenForReset']." Where AccountId='$account'";
		}
		$new_points = $server['Points'][''.$arr[0][3].'']*$arr[0][1]+($server['BonusPointsPerLevel']*($server['MaxLevel']-$server['ResetLevel']-($server['MaxLevel']-$arr[0][0])));
		$grizismudb->exec("Update Character Set cLevel=1,Resets=Resets+1,Experience=0,PkLevel=3,PkCount=0,PkTime=0,MapNumber=0,MapPosY=125,MapPosX=128,LevelUpPoint=$new_points,Strength=".$server['Points']['start'].",Dexterity=".$server['Points']['start'].",Vitality=".$server['Points']['start'].",Energy=".$server['Points']['start']." Where Name='$char' AND AccountId='$account'");
		$grizismudb->exec($money);
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