<?php
$check = $grizismudb->query("Select * From Auction Where Id = 1")->fetchAll();
$check = $check[0];
if(count($check) <= 0 || time() >= $check["EndTime"]){
	$item = $grizismudb->query("Select Top 1 * From Items Where (type BETWEEN 7 AND 11 AND id>10) OR (id>8 AND type BETWEEN 1 AND 6) OR (type=0 and id>15) order by newid()")->fetchAll();
	$item = $item[0];
	$item_array = Array("Level" => rand(0,11),"Duration" => 255,"Option" => rand(0,7),"Id"=>$item["id"],"Type" => $item["type"],"ExOptions" => 63,"Luck" => rand(0,1),"Skill" => 1);
	$item_code = create_item_code($item_array);
	$end_time = time()+48000;
	$grizismudb->exec("Delete From Auction Where Id=101");
	if(count($check) > 0){
		$grizismudb->exec("Update Auction Set Item=0x$item_code,EndTime=$end_time");
	}else{
		$grizismudb->exec("Insert Into Auction values(1,0x$item_code,$end_time)");
	}
}
?>