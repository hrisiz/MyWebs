 <?php
  if(!in_array($_SERVER['REMOTE_ADDR'],$server['AdminsIps'])){
    echo "<p>You should be Admin for this page.</p>";
    return '';
  }
	if($_POST['quest_submit']){
		generateQuests();
	}
?>
<form method="POST">
  <input onclick="startLoading()" type="submit" name="quest_submit" value="Update">
</form>