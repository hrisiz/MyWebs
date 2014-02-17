<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);

if (!empty($matches[0])){header("Location: /?page=News");}
$item_code = $grizismudb->query("Select Item From Auction Where ID = 1")->fetchAll();
if(count($item_code) > 0){
	$item_code = $item_code[0][0];
	$item = get_item_info($item_code);

	$item_options = "";
	foreach($item['excellent_options'] as $item_option){
		$item_options .= "<br>".$item_option;
	}
	$onmouseover = "<div class=show_item_info><p class=".$item['name_color'].">".$item['name']." +".$item['level']."</p><p>".$item['dur']." Durability</p><p class=show_item_excellent_options>".$item['skill']."".$item['luck']."".$item_options."</p></div>";
	?>
	<div onmouseover="return overlib('<?=$onmouseover?>');" onmouseout="return nd()"><img src="images/items/<?=$item['image']?>"/></div>

	<form method="POST">
		<label>Money</label>
		<input  type="text" name="bet_money"/>
		<br>
		<input type="submit" name="Bet" value="Bet"/>
	</form>

<?php
}else{
	echo"There no Item";
}
?>