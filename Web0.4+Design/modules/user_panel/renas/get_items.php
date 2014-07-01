<br>
<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}

if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
echo"<div id=\"choose_item_options\">
</div>";
$character = $_REQUEST['character'];
if(!empty($character)){
	$inventory = 0;
	if($character == "Warehouse"){
		$inventory = $grizismudb->query("Select items from warehouse Where AccountId='$account'")->fetchAll();
		$inventory = $inventory[0][0];
	}else{
		$inventory = $grizismudb->query("Select Inventory from Character Where AccountId='$account' AND Name='$character'")->fetchAll();
		$inventory = substr($inventory[0][0],20*12);
	}
	echo"<table id=\"get_items\"><tr>";
	$inventory = str_split($inventory,20);
	$rows = 0;
	$cols = 0;
	$inventory_array = array_fill(0,count($inventory)/8,(array_fill(0, 8,1)));	
	foreach($inventory as $item){
		if(substr($item,0,4) != "FFFF"){
			$item_info = get_item_info($item);
			if($character == "Warehouse"){
				$item_number = $rows*8+$cols;
			}else{
				$item_number = $rows*8+$cols+12;
			}
			$item_options = "";
			foreach($item_info['excellent_options'] as $item_option){
				$item_options .= "<br>".$item_option;
			}
			$onmouseover = "<div class=show_item_info><p class=".$item_info['name_color'].">".$item_info['name']." +".$item_info['level']."</p><p>".$item_info['dur']." Durability</p><p class=show_item_excellent_options>".$item_info['skill']."".$item_info['luck']."".$item_options."</p></div>";
			
			?>
				<td colspan="<?=$item_info['width']?>" rowspan="<?=$item_info['height']?>">
				<?php if(count($item_info['excellent_options']) == 1 && $item_info['ex_type'] <= 2 && $item_info['ex_type'] != 30){?>
					<input type="radio" name="item" value="<?=$item_number?>"  onclick='loadAjaxPage("Modules_User-Panel_Renas_Item-Options&TheChosenItemType=<?=($item_info['item_DB_info']['ex_type'])?>&ItemLevel=<?=($item_info['level'])?>","choose_item_options")' id="item<?=$rows?><?=$cols?>"/>
					<label onmouseover="return overlib('<?=$onmouseover?>');" onmouseout="return nd()" for="item<?=$rows?><?=$cols?>">
				<?php }else{ ?>
					<input type="radio"/>
					<label onmouseover="return overlib('This item cannot be upgrade.<?=$onmouseover?>');" onmouseout="return nd()">
				<?php } ?>	
					 	<img width="<?=($item_info['width']*30)?>px" height="<?=($item_info['height']*30) ?>px" src="images/items/<?=$item_info['image']?>"/>
					</label>
				</td>
			<?php for($col_i = $cols; $col_i < $cols+$item_info['width'];$col_i++){
				for($row_i = $rows; $row_i < $rows+$item_info['height'];$row_i++){
					$inventory_array[$row_i][$col_i] = 0;
				}
			}
			$inventory_array[$row][$col] = 2;
		}elseif(intval($inventory_array[$rows][$cols]) == 1){
			echo"<td></td>";
		}
		$cols++;
		if($cols >= 8){
			echo"</tr><tr>";
			$cols = 0;
			$rows++;
		}
	}

	echo "</tr></table>";
}

?>
