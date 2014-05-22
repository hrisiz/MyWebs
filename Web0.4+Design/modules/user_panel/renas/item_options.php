<style>
input[type="number"] {
   width:2.5em;
}
input[type="checkbox"] {
   width:2em;
}
</style>
<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
$itemtype = $_REQUEST['TheChosenItemType'];
$itemlevel = $_REQUEST['ItemLevel'];
if($itemtype == 30){
	echo"<p class=\"error\">This item can't be upgrade</p>";
}else{
switch ($itemtype) {
	case 0 :
		$option = Array('Increase Mana per kill +8',
							'Increase hit points per kill +8',
							'Increase attacking(wizardly)speed+7',
							'Increase wizardly damage +2%',
							'Increase Damage +level/20',
							'Excellent Damage Rate +10%');
		break;
	case 1:
		$option = Array('Increase Zen After Hunt +40%',
						'Defense success rate +10%',
						'Reflect damage +5%',
						'Damage Decrease +4%',
						'Increase MaxMana +4%',
						'Increase MaxHP +4%');
		break;
}
?>
<label for="level">Item Level</label>
<input type="number" name="level" id="level" width="2px" value="<?=$itemlevel?>" min="<?=$itemlevel?>" max="11"/>[ <?=$options_cost['Per Level Add']?> Renas per added level ]<br>
<label for="option">Item Add Option</label>
<select name="option" id="option">
	<option value="-1">--Select--</option>
	<option value="0"><?=$option[0]?>[<?=$options_cost[$option[0]]?> Renas ]</option>
	<option value="1"><?=$option[1]?>[<?=$options_cost[$option[1]]?> Renas ]</option>
	<option value="2"><?=$option[2]?>[<?=$options_cost[$option[2]]?> Renas ]</option>
	<option value="3"><?=$option[3]?>[<?=$options_cost[$option[3]]?> Renas ]</option>
	<option value="4"><?=$option[4]?>[<?=$options_cost[$option[4]]?> Renas ]</option>
	<option value="5"><?=$option[5]?>[<?=$options_cost[$option[5]]?> Renas ]</option>
</select><br>
<label for="luck">Luck</label>
<input type="checkbox" name="luck" id="luck" />[ <?=$options_cost['Luck']?> Renas ]<br>
<label for="skill">Skill</label>
<input type="checkbox" name="skill" id="skill" checked/>[ <?=$options_cost['Skill']?> Renas ]<br>
<input onclick="startLoading()" type="submit" name="ready" value="Ready"/>
<?php } ?>