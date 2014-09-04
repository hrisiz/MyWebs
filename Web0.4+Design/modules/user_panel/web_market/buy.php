<?php
// if($_SESSION['User'] != 'Admin' && $_SESSION['User'] != 'hrisiz'){
  // echo "<p>Don't work for few minsutes.</p>";
  // return "";  
// }
if(isset($_GET['page_count'])){
	$page_count = $_GET['page_count'];
	if($page_count < 0){
		 $page_count = 0;
	}
}else{
	$page_count = 0;
}
$count_per_page = 5;
if(isset($_POST['GetItem'])){
	$item_id = $_POST['item_id'];
	$market_item = $grizismudb->query("Select * From Web_Market Where Id=$item_id")->fetchAll();
	$market_item = $market_item[0];
	if(empty($market_item)){
		echo "<p class=\"error\">This item does not exist anymore.</p>";
	}elseif(empty($account)){
		echo "<p class=\"error\">Please login first.</p>";
	}else{
		if($account == trim($market_item['AccountId'])){
      $grizismudb->beginTransaction();
			$grizismudb->exec("Insert Into Web_House values('$account',0x".$market_item['Item'].",".time().",'WebMarket')");
			$grizismudb->exec("Delete From Web_Market Where id=$item_id");
      $grizismudb->commit();
			echo"<p class=\"success\">You successfully got your item.</p>";
		}else{
      $account_bank_zen = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
      $account_bank_zen = $account_bank_zen[0][0];
      $account_stones_count = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
      $account_stones_count = $account_stones_count[0][0];
      $account_renas_count = $grizismudb->query("Select Renas From Renas Where AccountId='$account'")->fetchAll();
      $account_renas_count = $account_renas_count[0][0];
			if($account_bank_zen < $market_item['Zen'] && $market_item['Zen'] > 0){
			echo "<p class=\"error\">You don't have enough zen.</p>";
			}elseif($account_stones_count < $market_item['Stones'] && $market_item['Stones'] > 0){
				echo "<p class=\"error\">You don't have enough stones.</p>";
			}elseif($account_renas_count < $market_item['Renas'] && $market_item['Renas'] > 0){
				echo "<p class=\"error\">You don't have enough renas.</p>";
			}else{
				$bank_check = count($grizismudb->query("Select * From Bank Where AccountId='".$market_item['AccountId']."'")->fetchAll());
				$stones_check =count($grizismudb->query("Select * From Stones Where AccountId='".$market_item['AccountId']."'")->fetchAll());
				$renas_check =count($grizismudb->query("Select * From Renas Where AccountId='".$market_item['AccountId']."'")->fetchAll());
				$grizismudb->beginTransaction();
        if($market_item['Zen'] > 0){
					if($bank_check > 0){
						$bank_code = "Update Bank Set Bank=Bank+".$market_item['Zen']." Where AccountId='".$market_item['AccountId']."'";
					}else{
						$bank_code = "Insert Into Bank values('".$market_item['AccountId']."',".$market_item['Zen'].")";
					}
				}else{
					$bank_code = "Insert Into Bank values('".$market_item['AccountId']."',0)";
				}			
				if($market_item['Stones']){
					if($stones_check > 0){
						$stones_code = "Update Stones Set Stones=Stones+".$market_item['Stones']." Where AccountId='".$market_item['AccountId']."'";
					}else{
						$stones_code = "Insert Into Stones values('".$market_item['AccountId']."',".$market_item['Stones'].")";
					}
				}else{
					$bank_code = "Insert Into Stones values('".$market_item['AccountId']."',0)";
				}	
				if($market_item['Renas']){
					if($renas_check > 0){
						$renas_code = "Update Renas Set Renas=Renas+".$market_item['Renas']." Where AccountId='".$market_item['AccountId']."'";
					}else{
						$renas_code = "Insert Into Renas values('".$market_item['AccountId']."',".$market_item['Renas'].")";
					}
				}else{
					$bank_code = "Insert Into Renas values('".$market_item['AccountId']."',0)";
				}	
				$bank_code1 = "Update Bank Set Bank=Bank-".$market_item['Zen']." Where AccountId='$account'";
				$stones_code1 = "Update Stones Set Stones=Stones-".$market_item['Stones']." Where AccountId='$account'";
				$renas_code1 = "Update Renas Set Renas=Renas-".$market_item['Renas']." Where AccountId='$account'";
				
				$grizismudb->exec("Insert Into Web_House values('$account',0x".$market_item['Item'].",".time().",'Market')");
				
				if($market_item['Zen'] > 0)
				$grizismudb->exec($bank_code1);
				if($market_item['Stones'] > 0)
				$grizismudb->exec($stones_code1);
				if($market_item['Renas'] > 0)
				$grizismudb->exec($renas_code1);
				
				$grizismudb->exec($bank_code);
				$grizismudb->exec($stones_code);
				$grizismudb->exec($renas_code);
				
				$grizismudb->exec("Delete From Web_Market Where id=$item_id");
        $grizismudb->commit();
				echo"<p class=\"success\">You successfully buy this item.</p>";
			}
		}
	}
}

?>
<table>
  <thead>
    <tr><th>#</th><th>Posted</th><th>Item</th><th>Sell for</th><th>Buy</th></tr>
  </thead>
<tbody>
<?php
	$i = $page_count*$count_per_page+1;
	foreach($grizismudb->query("Select AccountId,Item,Stones,Zen,Renas,Posted_Date,Id From Web_Market order by Posted_Date desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY") as $market_item){
		$item_info = get_item_info($market_item[1]);
		$item_options = "";
		$char = $grizismudb->query("Select Name From Character Where AccountId='$market_item[0]' order by Resets desc,cLevel desc")->fetch();
		foreach($item_info['excellent_options'] as $item_option){
			$item_options .= "<br>".$item_option;
		}
		$onmouseover = "<div class=show_item_info><p class=".$item_info['name_color'].">".$item_info['name']." +".$item_info['level']."</p><p>".$item_info['dur']." Durability</p><p class=show_item_excellent_options>".$item_info['skill']."".$item_info['luck']."".$item_options."</p></div>";
		echo"<tr>
				<td>
					$i
				</td>
				<td>
					From:<a href=\"?page=Modules_Character-Info&CharacterName=$char[0]\">$char[0]</a><br>
					On: ".date("d.m.Y",$market_item[5])."<br>
					At: ".date(" h:i:s",$market_item[5])."</td>
				<td style=\"text-align:center;\" onmouseover=\"return overlib('$onmouseover');\" onmouseout=\"return nd()\">
					<img src=\"images/items/".$item_info['image']."\"/>
				</td>
				<td>
					Stones:".number_format($market_item[2])."<br>
					Renas:".number_format($market_item[4])."<br>
					Zen:".number_format($market_item[3])."</td>
				<td>
					<form method=\"POST\">
						<input type=\"hidden\" value=\"".$market_item[6]."\" name=\"item_id\"/>
		";
					if(!isset($_SESSION['User'])){
            echo"";
          }elseif($account != trim($market_item[0])){
						echo"<input onclick=\"startLoading()\" type=\"submit\"  name=\"GetItem\" value=\"Buy\"/>";
					}else{
						echo"<input onclick=\"startLoading()\" type=\"submit\"  name=\"GetItem\" value=\"Back\"/>";
					}
		echo"
					</form>
				</td>
			</tr>";
		$i++;
	}
?>
</tbody>
</table>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_User-Panel_Web-Market&subpage=Buy&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_User-Panel_Web-Market&subpage=Buy&page_count=<?=$page_count+1?>">Next >></a>