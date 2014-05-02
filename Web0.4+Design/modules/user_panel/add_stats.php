
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['AddPoints'])){
	$character = $_POST['character'];
	$points = Array(intval($_POST['str']),intval($_POST['agi']),intval($_POST['vit']),intval($_POST['eng']));
	$char_info = $grizismudb->query("Select Name,LevelUpPoint From Character Where Name='$character' AND AccountId='".$_SESSION['LoggedUser']."'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	if($points[0] < 0 || $points[1] < 0 || $points[2] < 0 || $points[3] < 0){
		echo"<p class=\"error\">:P Use only numbers!</p>";
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif($char_info[0][0] != $character){
		echo"<p class=\"error\">Incorrect Character Name!</p>";
	}elseif($char_info[0][1] <= array_sum($points)){
		echo"<p class=\"error\">You don't have enough points</p>";
	}else{		
		$grizismudb->exec("Update Character Set LevelUpPoint = LevelUpPoint - ".array_sum($points).",Strength = Strength + $points[0],Dexterity = Dexterity + $points[1],Vitality = Vitality  + $points[2],Energy = Energy + $points[3] Where Name='$character'");
		echo"<p class=\"success\">Successfully Added</p>";
	}
}

?>
<form Method="POST">
	<label>Character:</label>
	<select onchange='this.form.submit()' name="character">
		<?php echo get_chars("LevelUpPoint","Points");?>
	</select><br>
	<?php 
	if(isset($_POST['character'])){
		$characters = $grizismudb->query("Select Strength,Dexterity,Vitality,Energy From Character Where Name='".$_POST['character']."'")->fetchAll();
	}else{
		$characters = $grizismudb->query("Select Strength,Dexterity,Vitality,Energy From Character Where Name='$first_char'")->fetchAll();
	}	
		?>
	<label>Strength:<?=$characters[0][0]?></label>
	<input type="number" name="str" size="5" max="32767"/><br>
	<label>Agility:<?=$characters[0][1]?></label>
	<input type="number" name="agi" size="5" max="32767"/><br>
	<label>Vitality:<?=$characters[0][2]?></label>
	<input type="number" name="vit" size="5" max="32767"/><br>
	<label>Energy:<?=$characters[0][3]?></label>
	<input type="number" name="eng" max="32767"/><br>
	<input type="submit" name="AddPoints" value="Add"/>
</form>