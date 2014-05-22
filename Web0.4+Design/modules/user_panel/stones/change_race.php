<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if($_POST['ChangeRace']){
	$char = $_POST['character'];
	$new_race = intval($_POST['race']);
	$check_char = $grizismudb->query("Select * From Character Where Name='$char'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	$check_races_value_arr = Array(1,17,33,47);
	$check_your_stones = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
	if(count($check_char) <= 0){
		echo"<p class=\"error\">This isn't your character!</p>";
	}elseif(count($check_is_online) > 0){
		echo"<p class=\"error\">Your account is on-line.</p>";
	}elseif(!in_array($new_race,$check_races_value_arr)){
		echo"<p class=\"error\">Please choose a correct race.</p>";
	}elseif($server['ChangeRaceStones'] > $check_your_stones[0][0]){
		echo"<p class=\"error\">You don't have enough Stones.</p>";
	}else{
		$grizismudb->exec("Update Character Set Class='$new_race' Where AccountId='$account' AND Name='$char'");
		$grizismudb->exec("Update Stones Set Stones = Stones-".$server['ChangeRaceStones']." Where AccountId='$account'");
		echo"<p class=\"success\">Successfully</p>";
		$user['Stones'] = $check_your_stones[0][0] - $server['ChangeRaceStones'];
		echo"<script>document.getElementById('Stones').innerHTML=\"Stones:".$user['Stones']."\"</script>";
	}
}
?>
<form method="POST">
<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
<label>Choose Race</label>
<select name="race">
	<option value="1">Soul Master</option>
	<option value="17">Blade Knight</option>
	<option value="33">Muse Elf</option>
	<option value="47">Magic Gladiator</option>
</select><br>
<input onclick="startLoading()" type="submit" value="ChangeRace" name="ChangeRace"/>
</form>