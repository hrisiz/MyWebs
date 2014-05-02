<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['GetZenFromStones'])){
	$inc = $_POST['stones_count'];
	$stones = array_keys($server['GetZenPerStoneArray'],$inc);
	$stones = intval($stones[0]);
	$check_your_stones = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
	if(!in_array($inc,$server['GetZenPerStoneArray'])){
		echo "<p class=\"error\">Please choose a correct value!</p>";
	}elseif($stones > $check_your_stones[0][0]){
		echo "<p class=\"error\">You don't have enough stones.</p>";
	}else{
		$get_money = $stones*$server['GetZenPerStone']*$inc ;
		$grizismudb->exec("Update Bank Set Bank=Bank+$get_money Where AccountId='$account'");
		$grizismudb->exec("Update Stones Set Stones=Stones-$stones Where AccountId='$account'");
		echo"<p class=\"success\">Successfully</p>";
		$user['Stones'] = $user['Stones']-$stones;
		$user['BankZen'] = number_format($user['BankZen'] + $get_money);
		echo"<script>document.getElementById('Stones').innerHTML=\"Stones:".$user['Stones']."\"</script>";
		echo"<script>document.getElementById('BankZen').innerHTML=\"Bank Zen:".$user['BankZen']."\"</script>";
	}
}
?>
<form method="POST">
	<label>Choose Option</label>
	<select name="stones_count">
		<?php
			foreach($server['GetZenPerStoneArray'] as $k => $v){
				echo"<option value=\"$v\">$k Stones for ".number_format($v*$server['GetZenPerStone']*$k) ." Zen</option>";
			}
		?>
	</select><br>
	<input type="submit" name="GetZenFromStones" value="GetZen"/>
</form>