<?php
$last_auction = $grizismudb->query("Select Top 1 * From Auction order by ID desc")->fetchAll();
if(count($last_auction) <= 0 || time() >= $last_auction[0]["EndTime"]){
	$item = $grizismudb->query("Select Top 1 * From Items Where (type BETWEEN 7 AND 11 AND id>10) OR (id>8 AND type BETWEEN 1 AND 6) OR (type=0 and id>15) order by newid()")->fetchAll();
	$item = $item[0];
	$ex = array(0,0,0,0,0);
	for($i=0;$i < 5;$i++){
		if(count(array_keys($ex,1)) < 2){
			$ex[rand(0,4)] = 1;
		}else{
			break;
		}
	}
	if($item['luck']){
		$is_luck = rand(0,1);
	}else{
		$is_luck = 0;
	}
	$item_code = generate_item_hex($item["type"],$item["id"],255,rand(0,11),rand(0,7),$item['skill'],$is_luck,$ex[0],$ex[1],$ex[2],$ex[3],$ex[4],$ex[5]);
	$end_time = time()+86400;
	$grizismudb->beginTransaction();
	if(count($last_auction) > 0){
		$last_auction = $last_auction[0];
		$winner = $grizismudb->query("Select Top 1 * From AuctionBets Bet Where AuctionID=".$last_auction['ID']." order by Zen desc")->fetchAll();
		foreach($grizismudb->query("Select * From AuctionBets Bet Where AuctionId=".$last_auction['ID']." AND AccountId <> '".$winner[0]['AccountId']."' order by Zen desc") as $bets){
			$grizismudb->exec("Update Bank Set Bank=Bank+".$bets['Zen']/2 ." Where AccountId='".$bets['AccountId']."'");
		}
		$grizismudb->exec("Insert Into Web_House values((Select Top 1 AccountId From AuctionBets order by Zen desc),0x".$last_auction['Item'].",".time().")");
		$grizismudb->exec("Insert Into AuctionWinners values(".$last_auction['ID'].",(Select Top 1 AccountId From AuctionBets order by Zen desc),0x".$last_auction['Item'].",(Select Top 1 Zen From AuctionBets order by Zen desc),".time().")");
		$grizismudb->exec("Delete From AuctionBets Where AuctionId=".$last_auction['ID']."");
	}else{
		$grizismudb->exec("Delete From AuctionBets");
	}
	$grizismudb->exec("Insert Into Auction values(".$last_auction['ID']."+1,0x$item_code,$end_time)");
	$grizismudb->commit();
	
}
?>