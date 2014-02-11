<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>

<!--<p class="content_text">This option allows you to add Luck(The option) to your items.This option will cost you  <?=$server['AddLuckRenas']?> Renas.</p>
<p class="content_text">Choose character or check warehouse to see your items and choose one of them with mouse left click on item.</p>
<p class="content_text">When you are ready just click on "AddLuck" button</p>  -->
<?php
if(isset($_POST['AddOptions'])){
	$char = $_SESSION['character'];
	$item_place = $_SESSION['item_place'] ;
	$item_option = $_POST['exl_option'];
	$skill_option = $_POST['Skill'];
	$luck_option = $_POST['Luck'];
	if(substr($item_place,0,9) == "warehouse"){
		$inventory = $grizismudb->query("Select ".$_POST['warehouse_checked']." From warehouse Where AccountId='$account'")->fetchAll();
	}elseif(substr($item_place,0,9) == "inventory"){
		$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char' AND AccountId='$account'")->fetchAll();
	}else{
		return false;
	}
	$item_place = substr($item_place,9);
	$inventory = $inventory[0][0];
	$item = substr($inventory,$item_place*20,20);
	$item_info = get_item_info($item);
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	$ckeck_renas = $grizismudb->query("Select Renas From Renas Where AccountId='$account'")->fetchAll();;
	if($luck_option == "Luck"){
		$item = substr_replace($item,sprintf("%02X",strtoupper(hexdec(substr($item,2,2))+4)),2,2);
		$cost = 4;
	}
	if($skill_option == "Skill"){
		$item = substr_replace($item,sprintf("%02X",strtoupper(hexdec(substr($item,2,2))+128)),2,2);
		$cost = 0;
	}
	$all_options = array_slice($item_info['all_possible_options'],-7,6);
	if(in_array($item_option,$all_options)){
		$item_option_dec_number = pow(2,array_search($item_option,$all_options));
		$cost = $item_option_dec_number ;
		$item = substr_replace($item,sprintf("%02X",strtoupper(hexdec(substr($item,14,2))+$item_option_dec_number)),14,2);
	}
	if(!$item_info){
		echo"<p class=\"error\">Please choose a item.</p>";
	}elseif($cost > $ckeck_renas[0][0]){
		echo"<p class=\"error\">You don't have enough renas</p>";	
	}elseif(count($item_info['excellent_options']) >= 2 && $item_option != ""){
		echo"<p class=\"error\">You can't add more excellent options to this item.</p>";
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif(in_array($item_option,$item_info['excellent_options'])){
		echo"<p class=\"error\">This item already have $item_option.</p>";	
	}elseif($item_info['luck'] != "" && $luck_option == "Luck"){
		echo"<p class=\"error\">This item already have $luck_option.</p>";
	}elseif($item_info['skill'] != "" && $skill_option == "Skill"){
		echo"<p class=\"error\">This item already have $skill_option.</p>";
	}elseif(!in_array($item_option,$item_info['all_possible_options']) && $item_option != ""){
		echo"<p class=\"error\">$item_option can't be added to this item</p>";	
	}elseif(!in_array($luck_option,$item_info['all_possible_options']) && $luck_option == "Luck"){
		echo"<p class=\"error\">$luck_option can't be added to this item</p>";	
	}elseif(!in_array($skill_option,$item_info['all_possible_options']) && $skill_option == "Skill"){
		echo"<p class=\"error\">$skill_option can't be added to this item</p>";	
	}elseif(count($item_info['excellent_options']) < 1 && $item_info['item_DB_info']['ex_type'] != 4){
		echo"<p class=\"error\">You can't add excellent option to non excellent item.</p>";
	}else{
		$new_inventory = substr_replace($inventory,$item,$item_place*20,20);
		if(isset($_POST['warehouse_checked'])){
			$change_code ="Update warehouse Set Items = 0x$new_inventory Where AccountId=(Select Top 1 AccountId From Character Where Name='$char')";
		}else{
			$change_code ="Update Character Set Inventory = 0x$new_inventory Where Name='$char' AND AccountId='$account'";
		}
		$grizismudb->exec($change_code);
		//$grizismudb->exec("Update Renas Set Renas=Renas-$cost Where AccountId='$account'");
		$user['Renas'] = $user['Renas'] - $server['AddLuckRenas'];
		echo"<p class=\"success\">Successfully</p>";
		echo"<script>document.getElementById('Renas').innerHTML=\"Renas: ".$user['Renas']."\"</script>";		
	}	
}
if(isset($_POST['warehouse_checked'])){
	$if_warehosue_checked = "checked";
}
if(isset($_POST['Choose'])){
	$is_hidden = "hidden";
}
?>
<!--<style type="text/css">
	td.inventory_box{
		width:35px;
		height:35px;
		background-image:url('../images/item_box.jpg');
		background-size:35px 36px;
		margin:0px;
		padding:0px;
	}
</style>

<table class="content_table">
	<tr><td class="inventory_box"></td></tr>
</table>
<table class="content_table">
	<tr><td colspan="2" class="inventory_box">
		<input class="radio_button_for_items" id="radio2" type="radio" name="check" value="Female">
						<label for="radio2"><img src="images/items/80021.gif" width="70px" height="105px"/></label>	
	</td></tr>
</table>-->
<form action="" id="AddLuck" method="POST">
	<label <?=$is_hidden?>>Character:</label>
	<select onchange='this.form.submit()' name="character" <?=$is_hidden?>>
		<?php echo get_chars();?>
	</select><br>
	<label for="warehouse_checked" <?=$is_hidden?>>Warehouse</label>
	<input onchange='setTimeout(function(){document.getElementById("AddLuck").submit();},500)' type="checkbox" value="Items" name="warehouse_checked" <?=$if_warehosue_checked?> <?=$is_hidden?>/>
	<?php 
	if(!isset($_POST['Choose'])){
		if(isset($_POST['character'])){
			echo get_char_items($_POST['character'],$_POST['warehouse_checked']);
		}else{
			echo get_char_items($first_char,$_POST['warehouse_checked']);
		}
		echo"<input value=\"Choose\" name=\"Choose\" type=\"submit\"/> ";
	}else{
		echo"<p>This Item Will cost you <span id=\"cost\">0</span> Renas</p>";
		$char = $_POST['character'];
		$item_place = $_POST['item_place_from_inventory'];
		if(isset($_POST['warehouse_checked'])){
			$item_place = "warehouse".$item_place;
		}else{
			$item_place = "inventory".$item_place;
		}
		$_SESSION['item_place'] = $item_place;
		$_SESSION['character'] = $char;
		if(substr($item_place,0,9) == "warehouse"){
		$inventory = $grizismudb->query("Select ".$_POST['warehouse_checked']." From warehouse Where AccountId='$account'")->fetchAll();
		}elseif(substr($item_place,0,9) == "inventory"){
			$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char' AND AccountId='$account'")->fetchAll();
		}else{
			echo"Please Choose a Item.";
		}
		$item_place = substr($item_place,9);
		$inventory = $inventory[0][0];
		$ckeck_renas = $ckeck_renas[0][0];
		$item = substr($inventory,$item_place*20,20);
		$item_info = get_item_info($item );
		switch ($item_info['item_DB_info']['ex_type']) {
			case 0 :
				$options_name = Array('Increase Mana per kill +8',
									'Increase hit points per kill +8',
									'Increase attacking(wizardly)speed+7',
									'Increase wizardly damage +2%',
									'Increase Damage +level/20',
									'Excellent Damage Rate +10%');
				break;
			case 1:
				$options_name = Array('Increase Zen After Hunt +40%',
								'Defense success rate +10%',
								'Reflect damage +5%',
								'Damage Decrease +4%',
								'Increase MaxMana +4%',
								'Increase MaxHP +4%');
				break;
			case 4: 
				$options_name = Array(' Life +'.(50+($item['level']*5)).' Increased',
								'Mana +'.(50+($item['level']*5)).' Increased',
								'10% Mana loss instead of Life');
				break;
		}
		$item_options = "";
						foreach($item_info['excellent_options'] as $item_option){
							$item_options .= "<br>".$item_option;
						}
		$onmouseover = "<div class=show_item_info><p class=".$item_info['name_color'].">".$item_info['name']."</p><p>".$item_info['dur']." Durability</p><p class=show_item_excellent_options>".$item_info['skill']."".$item_info['luck']."".$item_options."</p></div>";				
		echo"<img onmouseover=\"return overlib('$onmouseover');\" onmouseout=\"return nd()\" src=\"images/items/".$item_info['image']."\"/>";
		echo"<br><label for=\"Luck\">Luck</label>";
		echo"<input type=\"checkbox\" name=\"Luck\" value=\"Luck\">";
		echo"<label for=\"Skill\">Skill</label>";
		echo"<input type=\"checkbox\" name=\"Skill\" value=\"Skill\">";
		echo"<select name=\"exl_option\">";
		echo"<option value=\"\">No Option</option>";
		foreach($options_name as $option){
			echo"<option value=\"$option\">$option</option>";
		}
		echo"</select><br><input value=\"AddOptions\" name=\"AddOptions\" type=\"submit\"> ";
	}
	?>
</form>