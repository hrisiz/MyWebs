<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if(isset($_POST['ClearPK'])){
  $character = $_POST['character'];
  if(count($grizismudb->query("Select * From Character Where Name='$character' AND Money > ".$server['ClearPKZen']." AND AccountId='$account'")->fetchAll()) <= 0){
    echo"<p class=\"error\">You don't have enough zen.</p>";
  }else{
    $grizismudb->exec("Update Character Set Money=Money-".$server['ClearPKZen'].",PkCount=0,PkLevel=0,PkTime=0 Where Name='$character'");
    echo"<p class=\"success\">You successfully clear your character.</p>";
  }
}
?>
<form Method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
	<input onclick="startLoading()" type="submit" value="clear" name="ClearPK"/>
</form>