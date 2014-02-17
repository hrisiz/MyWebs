<?php
$check = $grizismudb->query("Select * From Auction Where Id = 1")->fetchAll();
$check = $check[0];
if(count($check) <= 0 || time() >= $check["EndTime"]){
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
	$item_code = generate_item_hex($item["type"],$item["id"],255,rand(0,11),rand(0,7),$item['skill'],rand(0,1),$ex[0],$ex[1],$ex[2],$ex[3],$ex[4],$ex[5]);
	$end_time = time()+48000;
	$grizismudb->exec("Delete From Auction Where Id=101");
	if(count($check) > 0){
		$grizismudb->exec("Update Auction Set Item=0x$item_code,EndTime=$end_time");
	}else{
		$grizismudb->exec("Insert Into Auction values(1,0x$item_code,$end_time)");
	}
}
?>