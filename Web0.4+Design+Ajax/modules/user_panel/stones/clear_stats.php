<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if(isset($_POST['ClearStats'])){
	$char = $_POST['character'];
	$check_char = $grizismudb->query("Select * From Character Where Name='$char'")->fetchAll();
	$check_is_online = $grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat=1")->fetchAll();
	$check_your_stones = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
	if(count($check_char) <= 0){
		echo"<p class=\"error\">This isn't your character!</p>";
	}elseif(count($check_is_online) > 0){
		echo"<p class=\"error\">Your account is on-line.</p>";
	}elseif($check_your_stones[0][0] < $server['ClearStatsStones']){
		echo "<p class=\"error\">You don't have enough stones.</p>";
	}else{
		$grizismudb->exec("Update Stones Set Stones=Stones-".$server['ClearStatsStones']." Where AccountId='$account'");
		$grizismudb->exec("Update Character Set LevelUpPoint=LevelUpPoint+Strength+Dexterity+Vitality+Energy-100,Strength=".$server['Points']['start'].",Dexterity=".$server['Points']['start'].",Vitality=".$server['Points']['start'].",Energy=".$server['Points']['start']." Where Name='$char' AND AccountId='$account'");
		echo"<p class=\"success\">Successfully</p>";
		$user['Stones'] = $check_your_stones[0][0] - $server['ClearStatsStones'];
		echo"<script>document.getElementById('Stones').innerHTML=\"Stones:".$user['Stones']."\"</script>";
	}
}
?>
<form method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
	<input type="submit" name="ClearStats" value="Clear"/>
</form>