<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

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