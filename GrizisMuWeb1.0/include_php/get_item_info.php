<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
function get_item_info($item_code){
	global $grizismudb;
	if(substr($item_code, 0, 4) != "FFFF")
	{
		$itemdur = hexdec(substr($item_code,4,2)); 
		$itemtype = hexdec(substr($item_code, 0, 1)); 
		$itemid = substr($item_code, 1, 1); 
		$ex	= hexdec(substr($item_code,14,2));
		if(($itemtype % 2) <> 0){
			$itemid = "1" . $itemid;
			$itemtype--; 
		}
		if($ex >= 128){ 	
			$itemtype += 16;  
		}
		$itemtype /= 2;
		$itemid = hexdec($itemid);
		$item['dur'] = $itemdur;
		$item['image'] = $itemtype."00".$itemid.".gif";
		$item_info = $grizismudb->query("Select * From Items Where id=$itemid AND type=$itemtype")->fetchAll();
		$item_info = $item_info[0];
		$item['item_DB_info'] = $item_info;
		$item['width'] = $item_info['X'];
		$item['height'] = $item_info['Y'];
		$item['name'] = $item_info['name'];
		$options=hexdec(substr($item_code,2,2));
		$item['skill'] = "";
		$item['all_possible_options'] = Array();
		if($item_info['skill'] == 1){
			$item['all_possible_options'][count($item['all_possible_options'])] = "Skill";
		}
		if($item_info['luck'] == 1){
			$item['all_possible_options'][count($item['all_possible_options'])] = "Luck";
		}
		if ($options>=128){
			$options = $options-128;
			if($item_info['skill'] == 1){
				$item['skill']="This weapon has a special skill<br>";
			}
		}
		$item['level'] = floor($options/8);
		$options = $options - ($item['level']*8);
		$item['luck'] = "";
		if ($options>=4){
			$item['luck']="Luck (success rate of jewel of soul +25%)<br>Luck (critical damage rate +5%)";
			$options-=4;
		}
		switch ($item_info['ex_type']) {
			case 0 :
				$options_name = Array('Increase Mana per kill +8',
									'Increase hit points per kill +8',
									'Increase attacking(wizardly)speed+7',
									'Increase wizardly damage +2%',
									'Increase Damage +level/20',
									'Excellent Damage Rate +10%',
									'Additional Damage');
				break;
			case 1:
				$options_name = Array('Increase Zen After Hunt +40%',
								'Defense success rate +10%',
								'Reflect damage +5%',
								'Damage Decrease +4%',
								'Increase MaxMana +4%',
								'Increase MaxHP +4%',
								'Additional Defense');
				break;
			case 4: 
				$options_name = Array(' Life +'.(50+($item['level']*5)).' Increased',
								'Mana +'.(50+($item['level']*5)).' Increased',
								'10% Mana loss instead of Life',
								'+50 of damage transfered as Life',
								'Increase Attacking(wizardry)speed +5',
								'',
								'Additional Damage');
				break;
			}
		if($ex>=128){
			$ex -= 128; 
		}
		if($ex>=64){ 
			$options+=4; 
			$ex -= 64; 
		}
		if($ex>=32){ 
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[5];
			$ex -= 32;
		}
		if($ex>=16){
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[4]; 
			$ex -= 16; 
		}
		if($ex>=8){ 
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[3];
			$ex -= 8; 
		}
		if($ex>=4){ 
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[2]; 
			$ex -= 4; 
		}
		if($ex>=2){ 
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[1]; 
			$ex -= 2; 
		}
		if($ex>=1){ 
			$item['excellent_options'][count($item['excellent_options'])] = $options_name[0];
			$ex -= 1; 
		}	
		if ($item_info['optionType']==0) { $itemoption	= $options_name[6]." +".$options*4; } 
		if ($item_info['optionType']==1) { $itemoption=  "Automatic HP Recovery rate +".($options).'%'; }
		if ($item_info['optionType']==2) { $itemoption= 'Additional Defence rate +'.$options*5;} 
		$item['option'] = $itemoption;
		$item['name_color']=' ';
		if ($item['level']>6) { $item['name_color'] = 'gold_item_name'; }
		if (!empty($item['excellent_options'])) { $item['name_color'] = 'excellent_item_name';}
		$item['all_possible_options'] = array_merge($item['all_possible_options'],$options_name);
		
		return $item;
	}else{
		return false;
	}
}
?>