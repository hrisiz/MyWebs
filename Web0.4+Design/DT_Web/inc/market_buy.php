<?php

if(isset($_POST['item_id']))
{
	$item_length = ITEM_LENGTH;
	$item_id=(int)$_POST['item_id'];
		
	$shop = mssql_query("SELECT * FROM [MarketPlace] WHERE [market_id] = '$item_id'");
	$check_item = mssql_num_rows($shop);
	$item_info = mssql_fetch_array($shop);
	if($check_item <= 0)
	{
		show_msg('Invalid Item!');
	}
	else
	{
		$credits = credits($username);
		$seller_cr = credits($item_info['seller']);
		$rqcredit = round($item_info['price']*$market['multiplier']);

		$query = mssql_fetch_row(mssql_query("exec WZ_GetItemSerial"));
		$serial = sprintf("%08X", $query[0], 00000000);
		
		$mycuritems = warehouse_items($username);
		$newitem = $item_info['item'];
		$new_credits=($credits - $rqcredit);
		$new_seller_cr=($seller_cr + $item_info['price']);
		if($item_info['serial'] != '00000000')
		{
			$newitem = str_replace($item_info['serial'], $serial, $newitem);
		}
		$slot = smartsearch($mycuritems,$item_info['X'],$item_info['Y']);
		$test = $slot * $item_length;

		if($username == $item_info['seller'])
		{
			$new_credits=($credits);
			$new_seller_cr=($credits);
			show_msg('This item was yours!');
		}
		
		if ($slot==1337)
		{
			show_msg('Not enough free space in the vault!');
		}
		elseif ($new_credits < 0 || $rqcredit <= 0)
		{
			show_msg('Not enough credits!');
		}
		else
		{
			$mynewitems = substr_replace($mycuritems, $newitem, ($test+2), $item_length);

			mssql_query("
				UPDATE " . $option['cr_db_table'] . " SET " . $option['cr_db_column'] . " = '".$new_credits."' WHERE " . $option['cr_db_check_by'] . " = '".$username."';
				UPDATE " . $option['cr_db_table'] . " SET " . $option['cr_db_column'] . " = '".$new_seller_cr."' WHERE " . $option['cr_db_check_by'] . " = '".$item_info['seller']."';
				UPDATE [warehouse] SET [Items]=".$mynewitems." WHERE [AccountId]='".$username."';
				DELETE FROM [MarketPlace] WHERE market_id=".$item_id.";
			");
			make_log('MarketBuyers','Buyer: '.$username.' | Seller: '.$item_info['seller'].' | Item: '.$newitem);
			show_msg('Item added in your warehouse!',1);
		}
	}
}
