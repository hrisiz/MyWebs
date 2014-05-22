<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if(isset($_POST['ClearStat'])){
  $character = $_POST['character'];
  if(count($grizismudb->query("Select * From Character Where Name='$character' AND Money > ".$server['ClearStatsZen']." AND AccountId='$account'")->fetchAll()) <= 0){
    echo"<p class=\"error\">You don't have enough zen.</p>";
  }else{
    $grizismudb->exec("Update Character Set Money=Money-".$server['ClearStatsZen'].",LevelUpPoint=(LevelUpPoint+Strength+Dexterity+Vitality+Energy)-100,Strength=25,Dexterity=25,Vitality=25,Energy=25 Where Name='$character'");
    echo"<p class=\"success\">You successfully cleared your points.</p>";
  }
}
?>
<form Method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
	<input onclick="startLoading()" type="submit" value="Clear Stats" name="ClearStat"/>
</form>
