<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}

if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}

if(isset($_POST['AddOptions'])){
	
}
?>
<form action="" id="AddLuck" method="POST">
	<div id="part_1">
		<label>Character:</label>
		<select  name="character">
			<option value="mywarehouse">Warehouse</option>
			<?=get_chars();?>
		</select><br>
	</div>
	<div id="part_2">
		
	</div>
	<div id="part_3">
		
		<input type="submit" name="add_options" value="Add Options"/>
	</div>
</form>