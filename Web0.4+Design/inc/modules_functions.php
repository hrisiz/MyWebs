<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
function get_time($full){
	$end_time['Hours'] = floor($full/60/60);
	$end_time['Minutes'] = floor(($full/60) - ($end_time['Hours']*60));
	$end_time['Seconds'] = floor($full - ($end_time['Minutes']*60) - ($end_time['Hours']*60*60));
	return $end_time;
}
function get_chars($check = -1,$check_value = -1,$another_chars){
	global $grizismudb;
	global $account;
	$string = "";
	$all_chars = $grizismudb->query("Select GameID1,GameID2,GameID3,GameID4,GameID5 From AccountCharacter Where ID='$account'")->fetchAll();
	$all_chars = array_filter($all_chars[0]);
	$all_chars = array_unique($all_chars);
	foreach($another_chars as $another_char){
		array_unshift($all_chars,$another_char);
	}
	if($_POST['character']){
		$all_chars = array_diff($all_chars,Array($_POST['character']));
		array_unshift($all_chars,$_POST['character']);
	}
	foreach($all_chars as $char){
		if($check != -1){
			$char_info = $grizismudb->query("Select $check From Character Where Name='$char'")->fetchAll();
			$string .= "<option value=\"$char\">$char [".$char_info[0][0]." $check_value]</option>";
		}else{
			$string .= "<option value=\"$char\">$char</option>";
		}
	}
	return $string;
}


function free_slots($x,$y,$zaeti_slotove){ 
	for($i=1;$i<=120;$i++){ 
		$svobodni=0; 
		for($k=0;$k<$x;$k++){
			if((!in_array($i+$k,$zaeti_slotove) && $x==1) || (!in_array($i+$k,$zaeti_slotove) && $x>1 && $i%8!=0 && $i%8+$k<=8))
				++$svobodni; 
			for($l=1;$l<$y;$l++)
				if(!in_array($i+$k+$l*8,$zaeti_slotove) && (int)(($i+$k+$l*8)/8)<15 )
					++$svobodni; 
			if($svobodni==$x*$y)
				return $i-1;
		}
	} 
	return 1993; 
} 

function generate_item_hex($item_type,$item_id,$item_durability,$item_level,$item_option,$item_skill,$item_luck,$ex1,$ex2,$ex3,$ex4,$ex5,$ex6){ 
	global  $grizismudb;
	$serial = $grizismudb->query("exec WZ_GetItemSerial")->fetchAll(); 
	$serial = $serial[0];
	$BB        = 0; 
	$CC        = $item_durability; 
	$DDEE    = sprintf("%08X", $serial[0],00000000); 
	$HH        = 0; 
	if($item_level>0)
		$BB+=$item_level*8; 
	if($item_option>0 && $item_option<=7) 
	if($item_option>=4){
	$BB+=$item_option-4;$HH+=64;
	}else{
		$BB+=$item_option; 
	}
	if($item_skill==1)
		$BB+=128; 
	if($item_luck==1)
		$BB+=4; 
	if($BB<0)
		$BB=0; 
	if($ex1==1)
		$HH+=1;
	if($ex2==1)
		$HH+=2;
	if($ex3==1)
		$HH+=4;
	if($ex4==1)
		$HH+=8;
	if($ex5==1)
		$HH+=16;
	if($ex6==1)
		$HH+=32; 


	if($item_type*2 >= 16)
		$HH+=128; 

	$names = ($item_type*32)+$item_id; 

	$AA = sprintf("%02X",$names,00); 
	if($names >=255)
		$AA = substr($AA,1,2); 

	$item_hex = sprintf("%02s%02X%02X%08s%02X%04s",$AA,$BB,$CC,$DDEE,$HH,0000); 
	return $item_hex; 
} 


function add_item($item_type,$item_id=0,$item_durability=255,$item_level=0,$item_option=0,$item_skill=0,$item_luck=0,$ex1=0,$ex2=0,$ex3=0,$ex4=0,$ex5=0,$ex6=0){ 
	global $account;
	global $grizismudb;
	$items = $grizismudb->query("Select Items From warehouse Where AccountID='$account'")->fetchAll(); 
	$items = $items[0][0];
	$br=0; 
	for($i=1;$i<=120;$i++){ 
		$code=substr($items,($i-1)*20,2); 
		if($code!="FF"){ 
			$id            = substr($code,1,1);              
			$itemtype     = hexdec(substr($code,0,1)); 

			$ioo = hexdec(substr($items,($i-1)*20+14,2)); 

			if(($itemtype % 2) != 0){
				$id = '1'.$id.'';$itemtype--; 
			} 
			if($ioo >= 128){
				$itemtype += 16;
			} 

			$itemtype /= 2;     
			$id=hexdec($id); 
			$item_info=$grizismudb->query("select X,Y from Items where type='$itemtype' and id='$id'")->fetchAll(); 
			$item_info = $item_info[0];
			for($k=0;$k<$item_info[0];$k++){
				$zaeti_slotove[]=$i+$k; 
				for($l=1;$l<$item_info[1];$l++)
					$zaeti_slotove[]=$i+$k+$l*8;
			} 
		} 
		else $br++; 
	} 
  if(is_numeric($item_type)){
    $item_info=$grizismudb->query("select X,Y from Items where type='$item_type' and id='$item_id'")->fetchAll();
    $new_item=generate_item_hex($item_type,$item_id,$item_durability,$item_level,$item_option,$item_skill,$item_luck,$ex1,$ex2,$ex3,$ex4,$ex5,$ex6); 
  }else{
    $item_info = get_item_info($item_type);
    $item_info= $grizismudb->query("select X,Y from Items where type='".$item_info['item_DB_info']['type']."' and id='".$item_info['item_DB_info']['id']."'")->fetchAll();
    $new_item = $item_type;
  }
	$item_info = $item_info[0];
	if($br==120)
		$svoboden_slot=0; 
	else 
		$svoboden_slot = free_slots($item_info['X'],$item_info['Y'],$zaeti_slotove); 
	if($svoboden_slot != 1993){ 
    $new_items=substr_replace($items,$new_item, $svoboden_slot*20, 20);
		$grizismudb->exec("Update warehouse Set items=0x$new_items Where AccountID='$account'"); 
		return 1; 
	} 
	return 0; 
} 
?>