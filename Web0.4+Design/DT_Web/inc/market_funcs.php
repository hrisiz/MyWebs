<?php

function category_name($cat_id)
{
	$cat = array(0 => "Swords",1 => "Axes",2 => "Maces &amp; Scepters" ,
		3 => "Spears" ,4 => "Bows &amp; Crossbows" ,5 => "Staffs" ,6 => "Shields" ,
		7 => "Helms" ,8 => "Armors" ,9 => "Pants" ,10 => "Gloves" ,11 => "Boots" ,
		12 => "Other Items", 1337 => "All Items");
	return isset($cat[$cat_id]) ? $cat[$cat_id] : "Unknown Category";   
}

function is_banned($item)
{
	global $market;
	$banned = false;
	$items = explode(',', $market['banned_items']);
	foreach($items as $banned_item)
	{
		if($item == $banned_item)
		{
			$banned = true;
		}
	}
	return $banned;
}

function credits($account)
{
	global $option;
	$query = mssql_query("SELECT " . $option['cr_db_column'] . " FROM " . $option['cr_db_table'] . " WHERE " . $option['cr_db_check_by'] . " = '". $account ."'");
	$total = mssql_fetch_array($query);
	return $total['credits'];
}

function ItemInfo($_item)
{
	if (substr($_item,0,2)=='0x')
	{
		$_item	= substr($_item,2);
	}
	if ((strlen($_item) != ITEM_LENGTH) || ( @ preg_match('/[^a-zA-Z0-9]/', $_item)) || ($_item == str_repeat('F', ITEM_LENGTH)))
	{
		return false;
	}
	// Get the hex contents
$id 	= hexdec(substr($_item,0,2)); // Item ID
$lvl	= hexdec(substr($_item,2,2)); //Level,Option,Skill,Luck
$itemdur 	= hexdec(substr($_item,4,2)); // Item Durability
$ex		= hexdec(substr($_item,14,2)); // Item Excellent Info/ Option
$serial		= substr($_item, 6, 8); // Item serial number
//Skill Check
if ($lvl<128) 
$skill	= '';
else {
$skill	= 'This weapon has a special skill';
$lvl	= $lvl-128;
}
//Item Level Check
$itemlevel	= floor($lvl/8);
$lvl		= $lvl-$itemlevel*8;
// Luck Check
if($lvl<4)
$luck	= ''; 
else {
$luck	= "Luck (success rate of jewel of soul +25%)<br>Luck (critical damage rate +5%)";
$lvl	= $lvl-4;
}
// Excellent option check
	if($ex-128>=0){$ex=$ex-128; }
	if($ex>=64)	{ $lvl+=4; $ex+=-64; }
	if($ex<32)	{ $exc6=0; } else { $exc6=1; $ex+=-32; }
	if($ex<16)	{ $exc5=0; } else { $exc5=1; $ex+=-16; }
	if($ex<8)	{ $exc4=0; } else { $exc4=1; $ex+=-8; }
	if($ex<4)	{ $exc3=0; } else { $exc3=1; $ex+=-4; }
	if($ex<2)	{ $exc2=0; } else { $exc2=1; $ex+=-2; }
	if($ex<1)	{ $exc1=0; } else { $exc1=1; $ex+=-1; }
//Item ID Check
$level = substr($_item, 0, 1);
$level2 = substr($_item, 1, 1);
$level3 = substr($_item, 14, 2);
$AA = $level;
$BB = $level2;
$CC= $level3;
$level1 = hexdec(substr($level, 0, 1));
if(($level1 % 2) <> 0)
{
$level2 = "1" . $level2;
$level1--; }
if(hexdec($level3) >= 128)
{ 	$level1 += 16;  }
$level1 /= 2;
$level2 = hexdec($level2);

$invview = mssql_query("SELECT * FROM [WebShop] WHERE [id]=$level2 AND [type]=$level1");
$rows = mssql_fetch_array($invview);

$iopxltype	= $rows['ex_type'];
$itemname = $rows['name'];
$itemexl = "";
switch ($iopxltype) {
	case 0 :
		$op1	= 'Increase Mana per kill +8';
		$op2	= 'Increase hit points per kill +8';
		$op3	= 'Increase attacking(wizardly)speed+7';
		$op4	= 'Increase wizardly damage +2%';
		$op5	= 'Increase Damage +level/20';
		$op6	= 'Excellent Damage Rate +10%';
		$inf	= 'Additional Damage';
		break;
	case 1:
		$op1	= 'Increase Zen After Hunt +40%';
		$op2	= 'Defense success rate +10%';
		$op3	= 'Reflect damage +5%';
		$op4	= 'Damage Decrease +4%';
		$op5	= 'Increase MaxMana +4%';
		$op6	= 'Increase MaxHP +4%';
		$inf	= 'Additional Defense';
		$skill	= '';
		$nocolor= false;
		break;
	case 4: 
		$op1	= ' Life +'.(50+($itemlevel*5)).' Increased';
		$op2	= ' Mana +'.(50+($itemlevel*5)).' Increased';
		$op3	= ' 10% Mana loss instead of Life';
		$op4	= ' +50 of damage transfered as Life';
		$op5	= ' Increase Attacking(wizardry)speed +5';
		$op6	= '';
		$inf	= 'Additional Damage';
		$skill	= '';
		$nocolor= true;
	}
//Draw Excellent Options
if ($exc1==1) 		$itemexl.='<br>'.$op1;
if ($exc2==1) 		$itemexl.='<br>'.$op2;
if ($exc3==1) 		$itemexl.='<br>'.$op3;
if ($exc4==1) 		$itemexl.='<br>'.$op4;
if ($exc5==1) 		$itemexl.='<br>'.$op5;
if ($exc6==1) 		$itemexl.='<br>'.$op6;

if ($rows['optionType']==0) { $itemoption	= $lvl*4; } 
if ($rows['optionType']==1) { $itemoption= ($lvl).'%'; $inf = ' Automatic HP Recovery rate '; }
if ($rows['optionType']==2) { $itemoption= $lvl*5; $inf = 'Additional Defense rate '; } 
$c = '#FFFFFF'; // White -> Normal Item
if (($lvl>1) || ($luck!='')) {$c = '#8CB0EA'; }
if ($itemlevel>6) { $c = '#F4CB3F'; }
if ($itemexl!='') { $c	= '#2FF387';} // Green -> Excellent Item 
if (@$nocolor) { $c='#F4CB3F'; }
if ($itemoption==0) { $itemoption	= ''; }
else { $itemoption = $inf." +".$itemoption; }
if (($itemexl!='') && ($itemname) && (@!$nocolor)) $itemname = 'Excellent '.$itemname;
$nolevel = 0;

	if ($nolevel==1) 
		$ilvl=0;
	else
		$ilvl=$itemlevel;
	// Item name
	$output['name'] = $itemname;
	// Item level
	$output['level']= $ilvl;
	// Item option level
	$output['opt']	= $itemoption;
	// Item excellent options
	$output['exl']	= $itemexl;
	// Item Luck (two lines)
	$output['luck']	= $luck;
	// Item Skill
	$output['skill']= $skill;
	// Item Durability
	$output['dur']	= $itemdur;
	// Horizontal Slots The item takes
	$output['X']	= $rows['X'];
	// Vertical Slots The item takes
	$output['Y']	= $rows['Y'];
	// Item thumbnail link
	$output['thumb']= ws_image($AA,$BB,$CC,0);
	// Item title color
	$output['color']= $c;
	// Item s/n
	$output['sn']	= $serial;
	// Output the result array()
	$output['item_id']	= $rows['id'];
	$output['item']	= $level1 . $level2;
	$output['item_category']	= $rows['type'];
	// Output the result array()
	
	$itemformat ='<div align=center style=\'padding-left: 6px; padding-right:6px;font-family:arial;font-size: 10px;\'>[Name] [Image] Durability [Skill] [Luck] [Excellent]</span></div>';

	$plusche=($output['level']) ? '+'. $output['level'] : '';
	
	$option= (@$output['opt']) ? '<br /><span style=color:#9aadd5;>'.$output['opt'].'</span>' : '';
	$luck=(@$output['luck']) ? '<br /><span style=color:#9aadd5;>'.$output['luck'].'</span>' : '';
	$skill=(@$output['skill']) ? '<br /><span style=color:#9aadd5;>'.$output['skill'].'</span>' : '';
	$exl=(@$output['exl']) ? '<span style=color:#8CB0EA;>'.str_replace('^^','<br>', $output['exl']).'</span>' : '';
	
	$overlib = str_replace('[Name]', '<span style=color:'.$output['color'].'>'.$output['name'].' '.$plusche.'</span>', addslashes($itemformat));
	$overlib = str_replace('Durability', "<p style='margin-top:7px;font-weight:normal;'>Durability [".$output['dur']."]</p>", $overlib);
	$overlib = str_replace('[Luck]', $luck.$option, $overlib);
	$overlib = str_replace('[Skill]', $skill, $overlib);
	$overlib = str_replace('[Excellent]', $exl,$overlib);
	$overlib2 = str_replace('[Image]', "<p style='margin-top:7px;font-weight:normal;'><img src='".$output['thumb']."' alt='' /></p>",$overlib);
	$overlib1 = str_replace('[Image]', '',$overlib);
	$overlib3 = str_replace('<span style=color:'.$output['color'].'>'.$output['name'].' '.$plusche.'</span>', '', $overlib2);
	
	$output['info'] = ' title="'.$overlib1.'"';
	$output['info2'] = ' title="'.$overlib2.'"';
	$output['full_info'] = $overlib2;
	$output['no_name'] = $overlib3;
	$output['overlib'] = $overlib1;
	$output['style'] = 'background: url('.$output['thumb'].') center center no-repeat;';
	return $output;
}

function ws_image($level,$level2,$level3,$arr = 0)
{
	if(@$arr) { 
	$xx="00"; 
	$images = "image/$level$xx$level2"; 
	return $images; 
	}
	else {
		$level1 = hexdec(substr($level, 0, 1));
		if(($level1 % 2) <> 0)
		{
		$level2 = "1" . $level2;
		$level1--; }
		if(hexdec($level3) >= 128)
		{ 	$level1 += 16;  }
		$level1 /= 2;
		$level2 = hexdec($level2);
		$xx = "00";
		//Images
		$images = "image/$level1$xx$level2.gif";
		return $images;
	}
}

// Smart space locater v0.9
function smartsearch($whbin,$itemX,$itemY)
{
	if (substr($whbin,0,2)=='0x') $whbin=substr($whbin,2);	
	$items 	= str_repeat('0', 120);
	$itemsm = str_repeat('1', 120);
	$i	= 0; 
	while ($i<120) {
		$_item	= substr($whbin,(ITEM_LENGTH*$i), ITEM_LENGTH);

$level = substr($_item, 0, 1);
$level2 = substr($_item, 1, 1);
$level3 = substr($_item, 14, 2);
$level1 = hexdec(substr($level, 0, 1));
if(($level1 % 2) <> 0)
{
$level2 = "1" . $level2;
$level1--; }
if(hexdec($level3) >= 128)
{ 	$level1 += 16;  }
$level1 /= 2;
$level2 = hexdec($level2);
		$res	= mssql_fetch_row(mssql_query("select [X],[Y],[Name] from [WebShop] where [id]=$level2 and [type]='$level1'"));
		$y	= 0;
		while($y<$res[1]) {
			$y++;$x=0;
			while($x<$res[0]) {
				$items	= substr_replace($items, '1', ($i+$x)+(($y-1)*8), 1);
				$x++;	
			} 
		}	
		$i++;
	}
	$y	= 0;
	while($y<$itemY) {
		$y++;$x=0;
		while($x<$itemX) {
			$x++;
			$spacerq[$x+(8*($y-1))] = true;
		} 
	}
	$walked	= 0;
	$i	= 0;
	while($i<120) {
		if (isset($spacerq[$i])) {
			$itemsm	= substr_replace($itemsm, '0', $i-1, 1);
			$last	= $i;
			$walked++;
		}
		if ($walked==count($spacerq)) $i=119;
		$i++;
	}
	$useforlength	= substr($itemsm,0,$last);
	$findslotlikethis='^'.str_replace('++','+',str_replace('1','+[0-1]+', $useforlength));
	$i=0;$nx=0;$ny=0;
	while ($i<120) {
		if ($nx==8) { $ny++; $nx=0; }
		if ((@eregi($findslotlikethis,substr($items, $i, strlen($useforlength)))) && ($itemX+$nx<9) && ($itemY+$ny<16))
			return $i;
		$i++;
		$nx++;
	}
	return 1337;
}

function warehouse_items($account_name)
{
	mssql_query("declare @items varbinary(" . WAREHOUSE_LENGTH . ");  
		set @items = (SELECT items FROM [warehouse] WHERE [AccountId]='".$account_name."'); 
		print @items;");

	$items  = mssql_get_last_message(); 
	return $items;
}

function market_warehouse($account)
{
	$item_length	= ITEM_LENGTH;
	$output = array();
	$items	= warehouse_items($account);
	$user_items	= substr($items,2);

	$item_position	= -1;
	while($item_position < 119)
	{
		$item_position++;

		$item 	= ItemInfo(substr($user_items,($item_length * $item_position), $item_length));
	
		if (@$item['name'])
		{
			$item['item_position'] = $item_position;
			$output[] = $item; 
		}
	}

	return $output;
}