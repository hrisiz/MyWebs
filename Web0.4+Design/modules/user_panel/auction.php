<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
$auction = $grizismudb->query("Select Top 1 * From Auction order by ID desc")->fetchAll();
if(count($auction) > 0){
	$auction = $auction[0];
	$item = get_item_info($auction['Item']);
	$biggest_bet = $grizismudb->query("Select Top 1 Zen From AuctionBets order by Zen desc")->fetchAll();
	if(count($biggest_bet) <= 0){
		$biggest_bet = $grizismudb->query("Select Zen From Items Where uid=".$item['item_DB_info']['uid']."")->fetchAll();
	}
	$biggest_bet = $biggest_bet[0][0];
	
	if(isset($_POST['Bet'])){
		$bet = intval($_POST['bet_money']);
		if($bet <= $biggest_bet){
			echo "<p class=\"error\">You do not cover the minimum bet.</p>";
		}elseif($bet > $user['Bank_Zen']){
			echo"<p class=\"error\">You don't have enough Zen</p>";
		}else{
			$check_is_exist = count($grizismudb->query("Select * From AuctionBets Where AccountId='$account'")->fetchAll());
			$grizismudb->beginTransaction();
			if(($auction['EndTime']-time()) < 600){
				$grizismudb->exec("Update Auction Set EndTime=".(time()+600) ." Where ID=".$auction['ID']."");
			}
			if ($check_is_exist > 0){
				$last_user_bet = $grizismudb->query("Select Zen From AuctionBets Where AccountId='$account'")->fetchAll();
				$grizismudb->exec("Update AuctionBets Set Zen=$bet,Posted_date=".time()." Where AccountId='$account'");
				$bet = $bet-$last_user_bet[0]['Zen'];
			}else{
				$grizismudb->exec("Insert Into AuctionBets values('$account',(Select MAX(ID) From Auction),$bet,".time().")");	
			}
			$grizismudb->exec("Update Bank Set Bank=Bank-$bet Where AccountId='$account'");
			$grizismudb->commit();
			$user['Bank_Zen'] = $user['Bank_Zen'] - $bet;
			echo"<script>update_info('user_bank_zen',".$user['Bank_Zen'].")</script>";
			echo"<p class=\"success\">You successfully bet</p>";
			$biggest_bet = $bet + $last_user_bet[0]['Zen'];
		}
	}

	$item_options = "";
	foreach($item['excellent_options'] as $item_option){
		$item_options .= "<br>".$item_option;
	}
	$onmouseover = "<div class=show_item_info><p class=".$item['name_color'].">".$item['name']." +".$item['level']."</p><p>".$item['dur']." Durability</p><p class=show_item_excellent_options>".$item['skill']."".$item['luck']."".$item_options."</p></div>";
	$time_to_end = $auction['EndTime']-time();
	$end_time = get_time($time_to_end);
	
	?>
	<p id="auction_timer"><?=$end_time['Hours']?> Hours <?=$end_time['Minutes']?> Minutes <?=$end_time['Seconds']?> Seconds</p>
	<script>timer_start(<?=$time_to_end?>,'auction_timer')</script>
	<div onmouseover="return overlib('<?=$onmouseover?>');" onmouseout="return nd()"><img src="images/items/<?=$item['image']?>"/></div>

	<form method="POST">
		<label for="money">Money</label>
		<input id="money" class="money" type="number" name="bet_money" value="<?=$biggest_bet+1?>" min="<?=$biggest_bet+1?>"/>
		<br>
		<input type="submit" name="Bet" value="Bet"/>
	</form>

<?php
	include "modules/rankings/auction.php";
}else{
	echo"There no Item";
}
?>