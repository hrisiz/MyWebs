<?php
// this is only if you can edit the savoy functions for season versions
// ItemInfo(), ws_image() and smartsearch()
define('ITEM_LENGTH', 20);
define('WAREHOUSE_LENGTH', 1200);

// Market Setings
$market['multiplier']	= 1.3;	// Item credits multiplier.
$market['items_per_page']	= 5;	// How many items will be displayed on one page.
$market['item_remove_in']	= 7;	// Item will be remove in how much days(Default: 7).

	// Items that are forbidden in the market.
$market['banned_items'] = '1411,1413,1414,1416,1422,1215';
	// group_id item_id = item name
	// 14 11 = Box of Luck(Box of Kundun)
	// 14 13 = Jewel of Bless
	// 14 14 = Jewel of Soul
	// 14 16 = Jewel of Life
	// 14 22 = Jewel of Creation
	// 12 15 = Jewel of Chaos
	// as in /MuServer/data/lang/kor/item(kor).txt(kor can be something else)

include 'inc/market_funcs.php';

$username = $_SESSION['dt_username'];
$credits = credits($username);

?>
<table width="95%">
<tr>
	<td class="boxTitle" colspan="5">
		<span style="padding-right:15px;"><a href="index.php?p=market">Werehouse</a></span>
		<span style="padding-left:25px;"><a href="index.php?p=market&cat_id=1337">All Items</a></span>
	</td>
</tr>
<?php
$ii = -1;
while($ii < 12)
{
	$ii++;
	$category_name[$ii] = category_name($ii);
	$tr='<td>';
	if((round($ii/5)==$ii/5) && ($ii!=0))
	{
		$tr='</tr><tr><td>';
	}
	if($ii === 12)
	{
		$tr='<td colspan="3">';
	}
	echo $tr.'<a href="index.php?p=market&cat_id='.$ii.'">'.$category_name[$ii].'</a></td>';
}
?>
</tr>
</table>
<?php
if(isset($_POST['item_position']))
{
	include 'inc/market_sell.php';
}
elseif(isset($_POST['item_id']))
{
	include 'inc/market_buy.php';
}
elseif(isset($_GET['cat_id']))
{
	$category=(int)$_GET['cat_id'];
?>
<br />
<table style="width:90%;margin:0 auto 10px;">
	<tr class="title">
		<td style="text-align:center;" colspan="2">Market Items (<?php echo category_name($category); ?>)</td>
	</tr>
<?php
$i=0;
$page= (isset($_GET['page']) &&  $_GET['page'] > 0) ? (int)$_GET['page'] : 1;

$category_str = "cat_id=". $category;
if($category == 12)
{
	$category_str = "cat_id=12 OR cat_id=13 OR cat_id=14 OR cat_id=15";
}
elseif($category == 1337)
{
	$category_str = 'market_id > 0';
}

$limit = $market['items_per_page'];

$pages = $page-1;
$offset = $limit * $pages;

$querystr = pagination($offset, $limit, 'market_id,item,price,added_on,expires_on,seller', 'MarketPlace', 'added_on DESC', 'market_id', $category_str);
$qmarket = mssql_query($querystr);

while($item = mssql_fetch_array($qmarket)):

	$item_i = ItemInfo($item['item']);
	$market_id=$item['market_id'];
	$time=time();
	if($item['expires_on'] <= $time)
	{
		mssql_query("DELETE FROM [MarketPlace] WHERE market_id=".$market_id);
		header('Location: index.php?p=market&cat_id='.$category);
	}
	$added_on=date("d-m-Y H:i",$item['added_on']);
	$expires_on=date("d-m-Y H:i",$item['expires_on']);
	$price= round($market['multiplier'] * $item['price']);

	$imgsize = @getimagesize($item_i['thumb']);
	$width = $imgsize[0];
	$height = $imgsize[1];
	if($width>=40){ $width=32; }
	$size='width="'.$width.'"';
	if($height>40 && $width<37){ $size='height="32"'; }

	$text= "onclick=\"return confirm('Are you sure you want to buy ".$item_i['name']." for ".$price." Credits');\"";

	if($credits < $price && $username != $item['seller'])
	{
		$text ="onclick=\"alert('Not enough Credits!'); return false;\"";
	}
?>
<tr>
	<td style="text-align:center;width: <?php echo ($width+50); ?>px;">
	<form method="post" action="?p=market">
		<input type="hidden" name="item_id" value="<?php echo $item['market_id']; ?>" />
		<input type="image" class="item_image" src="<?php echo $item_i['thumb']; ?>" <?php echo $size; ?> alt="<?php echo $item_i['name']; ?>" <?php echo $item_i['info2']; ?>  <?php echo $text; ?> />
	</form>
	</td>
	<td valign="top">
		<div class="clearfix">
			<p class="left">Added on:</p> <p class="right" style="color:#999;"><?php echo $added_on; ?></p>
		</div>
		<hr />
		<div class="clearfix">
			<p class="left">Price:</p> <p class="right" style="color:#999;"><?php echo $price; ?> Credits</p>
		</div>
		<hr />
		<div class="clearfix">
			<p class="left">Expires on:</p> <p class="right" style="color:#999;"><?php echo $expires_on; ?></p>
		</div>
	</td>
</tr>
<tr><th colspan="2"></th></tr>
<?php
	$i++;
	endwhile;
	if($i===0):
?>
	<tr>
		<td class="warning">No items for sale.</td>
	</tr>
</table>
<?php

	else:
		$count = mssql_num_rows(mssql_query('SELECT price FROM [MarketPlace] WHERE '. $category_str));
		$max_pages= ceil($count/$limit);

		$prev='Previous'; 
		$next='Next';
		if($page > 1)
		{
			$prev='<a href="index.php?p=market&cat_id='. $category .'&page='.($page-1).'">Previous</a>';
		}
		if($page < $max_pages)
		{
			$next='<a href="index.php?p=market&cat_id='. $category .'&page='.($page+1).'">Next</a>';
		}

?>
</table>

<div class="pages">
	<p>
	<?php echo $prev; ?>
		<span><?php echo $page; ?></span>
	<?php echo $next; ?>
	</p>
</div>
<br />
<?php

	endif;

}else{
?>
<div class="warehouse">
	<h2 class="boxTitle2">WAREHOUSE ITEMS</h2>
	<?php
		$warehouse = market_warehouse($username);
		foreach($warehouse as $item):
	?>
	<div class="box inline_box">
			<div class="boxTitle normal_caps">
				 <?php echo $item['name']; ?>
			</div>
			<div class="boxBody" style="cursor:help;" <?php echo $item['info2']; ?>>
				<img src="<?php echo $item['thumb']; ?>" />
			</div>
			<div class="boxBody" style="margin-top:-1px;border-top-width:0;padding:5px 0 10px;">
				<form action="?p=market" method="post">
					<input type="hidden" name="item_position" value=" <?php echo $item['item_position']; ?>" />
					<input type="submit" class="button pointer" name="submit" value="Sell in Market" />
				</form>
			</div>
			<div class="boxFooter-line"></div>
	</div>
	<?php endforeach; ?>
</div>
<?php
}
?>