<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
$bank_money = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
if (isset($_POST['GetZen']))
{
	$money = intval($_POST['Money']);
	$char = $_POST['character'];
	$is_char_exist = $grizismudb->query("Select Money From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	if(count($is_char_exist) <= 0){
		echo"<p class=\"error\">This is not your character!!!</p>";
	}elseif($money < 0){
		echo"<p class=\"error\">Use only positive(+) numbers!</p>";		
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif(count($bank_money) < 0){
		echo"<p class=\"error\">You don't have bank.</p>";		
	}elseif($money > $bank_money[0][0]){
		echo"<p class=\"error\">There no enough money</p>";		
	}elseif($is_char_exist[0][0]+$money > 2000000000){
		echo"<p class=\"error\">Character limit is 2000000000</p>";		
	}else{
		$grizismudb->exec("Update Character Set Money=Money+$money Where Name='$char' AND AccountId='$account'");
		$grizismudb->exec("Update Bank Set Bank = Bank - $money Where AccountId='$account'");
		echo"<p class=\"success\">Successfully</p>";
		// echo"<script>document.getElementById(\"BankZen\").innerHTML=\"BankZen: ".number_format($bank_money[0][0]-$money)."\"</script>";
	}
}
if (isset($_POST['PutZen']))
{
	$money = intval($_POST['Money']);
	$char = $_POST['character'];
	$is_char_exist = $grizismudb->query("Select Money From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat>0")->fetchAll());
	if(count($is_char_exist) <= 0){
		echo"<p class=\"error\">This is not your character!!!</p>";
	}elseif($money < 0){
		echo"<p class=\"error\">Use only positive(+) numbers!</p>";		
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}elseif($money > $is_char_exist[0][0]){
		echo"<p class=\"error\">There no enough money</p>";		
	}elseif($bank_money[0][0]+$money > 9223372036854775800){
		echo"<p class=\"error\">Bank limit is 9223372036854775800</p>";		
	}else{
		$is_exist = count($grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll());
		if($is_exist > 0){
			$bank_moneya="Update Bank Set Bank = Bank + $money Where AccountId='$account'";
		}else{
			$bank_moneya="Insert Into Bank values('$account',$money)";
		}
		$grizismudb->exec($bank_moneya);
		$grizismudb->exec("Update Character Set Money=Money-$money Where AccountId='$account' AND Name='$char'");
		echo"<p class=\"success\">Successfully</p>";
		// echo"<script>document.getElementById(\"BankZen\").innerHTML=\"Bank Zen: ".number_format($bank_money[0][0]+$money)."\"</script>";
	}
}
echo "<p> You have ".number_format($bank_money[0][0])." Zen in the bank</p>";
?>
<form Method="POST">
	
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars("Money","Zen");?>
	</select><br>
	<label>Zen</label>
	<input type="number" name="Money"/><br>
	<input onclick="startLoading()" type="submit" name="PutZen" value="PutZen"/>
	<input onclick="startLoading()" type="submit" name="GetZen"value="GetZen"/>
</form>