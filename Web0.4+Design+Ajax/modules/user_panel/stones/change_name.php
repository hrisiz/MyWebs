<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if(isset($_POST['ChangeName'])){
	$char = $_POST['character'];
	$new_name = $_POST['name'];
	$check_new_name = $grizismudb->query("Select * From Character Where Name='$new_name'")->fetchAll();
	$check_char = $grizismudb->query("Select * From Character Where Name='$char'")->fetchAll();
	$check_is_online = $grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat=1")->fetchAll();
	$check_your_stones = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
	if(strlen($new_name) < 4){
		echo"Minimum character's name length is 4.";
	}elseif(strlen($new_name) > 10){
		echo"Maximum character's name length is 10.";
	}elseif(count($check_new_name) > 0){
		echo"<p class=\"error\">This character name already exists.</p>";
	}elseif(count($check_char) <= 0){
		echo"<p class=\"error\">This isn't your character!</p>";
	}elseif(count($check_is_online) > 0){
		echo"<p class=\"error\">Your account is on-line.</p>";
	}elseif($server['ChangeNameStones'] > $check_your_stones[0][0]){
		echo"<p class=\"error\">You don't have enough Stones.</p>";
	}else{
		$check_char_place = $grizismudb->query("Select GameID1,GameID2,GameID3,GameID4,GameID5 From AccountCharacter Where Id='$account'")->fetchAll();
		$char_place=array_keys($check_char_place[0],$char);
		$char_place = $char_place[0];
		if(count(array_keys($check_char_place[0],$char)) > 1){
			$GameIDC = ",GameIDC='$new_name'";
		}else{
			$GameIDC = "";
		}
		$grizismudb->exec("Update Character Set Name='$new_name' Where AccountId='$account' AND Name='$char'");
		$grizismudb->exec("Update AccountCharacter Set $char_place='$new_name'$GameIDC Where Id='$account'");
		$grizismudb->exec("Update Stones Set Stones = Stones-".$server['ChangeNameStones']." Where AccountId='$account'");
		echo"<p class=\"success\">Successfully</p>";
		$user['Stones'] = $check_your_stones[0][0] - $server['ChangeNameStones'];
		echo"<script>document.getElementById('Stones').innerHTML=\"Stones:".$user['Stones']."\"</script>";
	}
}
?>
<form method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
	<label>New Name:</label>
	<input type="text" name="name" size="15" maxlength="10"/><br>
	<input type="submit" name="ChangeName" value="ChangeName"/>
</form>