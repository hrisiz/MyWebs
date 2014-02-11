<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
function get_chars($check = -1,$check_value){
	global $grizismudb;
	$string = "";
	$all_chars = $grizismudb->query("Select GameID1,GameID2,GameID3,GameID4,GameID5 From AccountCharacter Where ID='".$_SESSION['LoggedUser']."'")->fetchAll();
	$all_chars = array_filter($all_chars[0]);
	$all_chars = array_unique($all_chars);
	if(in_array($_POST['character'],$all_chars)){
		$all_chars = array_diff($all_chars,Array($_POST['character']));
		array_unshift($all_chars,$_POST['character']);
	}
	$check_is_first = 0;
	foreach($all_chars as $char){
		if($check_is_first == 0){
			global $first_char;
			$first_char = $char;
			$check_is_first = 1;
		}
		if($check != -1){
			$char_info = $grizismudb->query("Select $check From Character Where Name='$char'")->fetchAll();
			$string .= "<option value=\"$char\">$char [".$char_info[0][0]." $check_value]</option>";
		}else{
			$string .= "<option value=\"$char\">$char</option>";
		}
	}
	return $string;
}
function get_char_items($char,$warehouse = false){
	global $grizismudb;
	global $web;
	$boxes_size = $web['items_box_size'];
	$result ="
		
		<table class=\"content_table\">
	";
	if($warehouse){
		$inventory = $grizismudb->query("Select $warehouse From warehouse Where AccountId=(Select Top 1 AccountId From Character Where Name='$char')")->fetchAll();
		$inventory_counter = 0;
		$tds_count = array_fill(0,15,array_fill(0,8,1));
	}else{
		$inventory = $grizismudb->query("Select Inventory From Character Where Name='$char'")->fetchAll();
		$inventory_counter = 12;
		$tds_count = array_fill(0,8,array_fill(0,8,1));
	}
	$inventory = str_split($inventory[0][0],20);
	if(count($inventory) > 1){
		for($row = 0;$row < count($tds_count);$row++){
			$result .="<tr>"; 
			for($column = 0;$column < count($tds_count[$row]);$column++){
				$item = get_item_info($inventory[$inventory_counter]);
				$item_width_boxes = $item['width'];
				$item_height_boxes = $item['height'];
				$image = $item['image'];
				if($tds_count[$row][$column] != 0){
					$result .="
						<td rowspan=\"$item_height_boxes\" colspan=\"$item_width_boxes\" class=\"inventory_box\">
					";
					if($item && $item['item_DB_info']['ex_type'] != 30){
						$item_options = "";
						foreach($item['excellent_options'] as $item_option){
							$item_options .= "<br>".$item_option;
						}
						$onmouseover = "<div class=show_item_info><p class=".$item['name_color'].">".$item['name']."</p><p>".$item['dur']." Durability</p><p class=show_item_excellent_options>".$item['skill']."".$item['luck']."".$item_options."</p></div>";
						$result .="
							<input class=\"radio_button_for_items\" id=\"radio$row$column\" type=\"radio\" name=\"item_place_from_inventory\" value=\"$inventory_counter\">
							<label for=\"radio$row$column\" onmouseover=\"return overlib('$onmouseover');\" onmouseout=\"return nd()\">
								<img src=\"images/items/$image\" width=\"".$boxes_size*$item_width_boxes ."\" height=\"".$boxes_size *$item_height_boxes ."\"/>
							</label>	
						";
					}
					$result .="
						</td>
					";
				}
				if($item_width_boxes > 1 ){
					for($i = $column+1;$i < $item_width_boxes+$column;$i++){
						$tds_count[$row][$i] = 0;
					}		
					
				}
				if($item_height_boxes > 1){
					for($i = $row+1;$i < $item_height_boxes+$row;$i++){
						for($i1 = $column;$i1 < $item_width_boxes+$column;$i1++){
							$tds_count[$i][$i1] = 0;
						}	
					}				
				}
				
				$inventory_counter++;
			}
			$result .="</tr>";
		}
	}else{
		$result .= "<tr><td class=\"error\">There no items.</td></tr>";
	}
	$result .= "
	</table>
	";
	return $result;
}
function get_time($full){
	$min = $full; 
	$chas = floor($min/60); 
	$days = floor($chas/24); 
	$chas = $chas % 24; 
	$min = $full % 60;
	return "$days days $chas hours";
}
function get_empty_item_places($inventory,$item_x,$item_y,$inventory_rows = 8,$inventory_columns = 8,$count = 1){
	/*$rows =  array_fill(0,$inventory_rows,array_fill(0,$inventory_columns,0));
	$inventory = str_split($inventory,20);
	for($i = 0; $i < count($inventory);$i++){
		if(substr($inventory[$i],0,4) != "FFFF"){
			$item_info = get_item_info($inventory[$i]);
			$column = $i % $inventory_columns;
			$row = floor($i / $inventory_columns);
			for($i1 = 0; $i1 < $item_info['item_DB_info']['Y'];$i1++){
				for($i2 = 0; $i2 < $item_info['item_DB_info']['X'];$i2++){
					$rows[$row+$i1][$column+$i2] = 1;
				}
			}
		}
	}
	echo "<br>";
	$result = Array(0);
	for($row = 0; $row < count($rows); $row++){
		for($column = 0; $column < count($rows[$row]); $column++){
			echo $rows[$row][$column];
			if($rows[$row][$column] == 0){
				$is_found = true;
				for($i1 = $row; $i1 < $item_y;$i1++){
					for($i2 = $column; $i2 < $item_x;$i2++){
						if($rows[$i1][$i2] != 0 || $i1 >= $inventory_rows-3 || $i2 >= $inventory_columns-3){
							$is_found = false;
							break 2;
						}
					}
				}
				if ($is_found){
					array_push($result,($row*$inventory_columns)+$column);
				}
			}
		}
		echo"<br>";
	}
	print_r($result);*/
	$inventory = str_split($inventory,20);
	for($i = 0; $i < count($inventory);$i++){
		if(substr($inventory[$i],0,4) == "FFFF"){
			//provaerqva dali drugite sa svobodni
		}else{
			//premahva $i i drugite mesta koito zaema itema za da se propusnat
		}
	}
}
?>