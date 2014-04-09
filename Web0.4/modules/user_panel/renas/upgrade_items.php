
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['ready'])){
	$item = $_POST['item'];
	$option = $_POST['option'];
	$luck = $_POST['luck'];
	$skill = $_POST['skill'];
	$level = $_POST['level'];
	$character = $_POST['character'];
	if($character == "Warehouse"){
		$inventory = $grizismudb->query("Select Items From warehouse Where AccountId='$account'")->fetchAll();
		$inventory = $inventory[0][0];
	}elseif(!empty($character)){
		$inventory = $grizismudb->query("Select Inventory From Character Where Name='$character'")->fetchAll();
		$inventory = $inventory[0][0];
	}else{
		echo "<p class=\"error\">Please choose a character.</p>";
	}
	if(substr($inventory,$item*20,4) == "FFFF"){
		echo"<p class=\"error\">This isn't your item</p>";
	}else{
		$item_info = get_item_info(substr($inventory,$item*20,20));
		switch ($item_info['item_DB_info']['ex_type']) {
			case 0 :
				$options_arr = Array('Increase Mana per kill +8',
									'Increase hit points per kill +8',
									'Increase attacking(wizardly)speed+7',
									'Increase wizardly damage +2%',
									'Increase Damage +level/20',
									'Excellent Damage Rate +10%');
				break;
			case 1:
				$options_arr = Array('Increase Zen After Hunt +40%',
								'Defense success rate +10%',
								'Reflect damage +5%',
								'Damage Decrease +4%',
								'Increase MaxMana +4%',
								'Increase MaxHP +4%');
				break;
		}
		$all_cost = 0;
		if($level > $item_info['level'])
			$all_cost += (($level-$item_info['level'])*$options_cost['Level']);
		if($option >= 0 && $option <= 5)
			$all_cost += $options_cost[$options_arr[$option]];
		if($luck && $item_info['luck'] == "" && $item_info['item_DB_info']['luck'] == 1)
			$all_cost += $options_arr['Luck'];
		if($skill && $item_info['skill'] == "" && $item_info['item_DB_info']['skill'] == 1)
			$all_cost += $options_arr['Skill'];
		if(count($item_info['excellent_options']) < 1){
			echo"<p class=\"error\">This item is not a excellent item and you can't upgrade it.</p>";
		}elseif(count($item_info['excellent_options']) >= 2 && $option >= 0 && $option <= 5){
			echo"<p class=\"error\">This item have more then 1 option and you can't add more options.</p>";
		}elseif(count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat=1")->fetchAll()) > 0){
			echo"<p class=\"error\">Your Account is Online.</p>";
		}elseif(in_array($options_arr[$option],$item_info['excellent_options']) && $option >= 0 && $option <= 5){
			echo"<p class=\"error\">This option already exist for this item.</p>";
		}elseif($all_cost > $user['Renas']){
			echo"<p class=\"error\">You don't have enough renas.</p>";
		}elseif($level > 11){
			echo"<p class=\"error\">11 is maximum item level.</p>";
		}else{
			$new_item = substr($inventory,$item*20,20);
			$coutner = 1;
			if($luck && $item_info['luck'] == "" && $item_info['item_DB_info']['luck'] == 1){
				$new_item = substr_replace($new_item,sprintf("%02X",hexdec(substr($new_item,2,2))+4),2,2);
				echo"<p class=\"success\">$coutner) Luck Added</p>";
				$coutner++;
			}
			if($skill && $item_info['item_DB_info']['skill'] == 1 && $item_info['skill'] == ""){
				$new_item = substr_replace($new_item,sprintf("%02X",hexdec(substr($new_item,2,2))+128),2,2);
				echo"<p class=\"success\">$coutner)Skill Added</p>";
				$coutner++;
			}
			if($level > $item_info['level']){
				$new_item = substr_replace($new_item,sprintf("%02X",hexdec(substr($new_item,2,2))+(($level - $item_info['level']) * 8)),2,2);
				echo"<p class=\"success\">$coutner)Level Upgraded</p>";
				$coutner++;
			}
			if($option >= 0 && $option <= 5){
				$new_item = substr_replace($new_item,sprintf("%02X",hexdec(substr($new_item,14,2))+(pow(2,$option))),14,2);
				echo"<p class=\"success\">$coutner)Option Added</p>";
				$coutner++;
			} 
			$grizismudb->exec("Update Renas Set Renas=Renas-$all_cost Where AccountId='$account'");
			$grizismudb->exec("Update Warehouse Set Items=0x".substr_replace($inventory,$new_item,$item*20,20)." Where AccountId='$account'");
			$user['Renas'] = $user['Renas'] - $all_cost;
			echo"<script>update_info('user_renas',".$user['Renas'].")</script>";
			echo"<p class=\"success\">You successfully upgraded your ".$item_info['name']."</p>";
		}
	}
}
?>
<form method="POST">
	<div id="items"></div>
	<select onchange='get_file("items","Modules_User-Panel_Renas_Get-Items&character="+this.options[this.selectedIndex].value)' name="character">
		<option value="">--Select--</option>
		<?php echo get_chars(-1,-1,Array("Warehouse"));?>
	</select><br>
</form>