<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if (isset($_POST['DepositStones'])){
	$char = $_POST['character'];
	$is_char_exist = $grizismudb->query("Select Money From Character Where AccountId='$account' AND Name='$char'")->fetchAll();
	$is_online = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat > 0")->fetchAll());
	if(count($is_char_exist) <= 0){
		echo"<p class=\"error\">This is not your character!!!</p>";
	}elseif($is_online > 0){
		echo"<p class=\"error\">This account is On-line</p>";
	}else{
		$inventory = $grizismudb->query("Select Inventory From Character Where AccountId='$account' And Name='$char'")->fetchAll();
		$inventory = $inventory[0][0];
		$items = str_split($inventory,20);
		$stones = 0;
		$empty_item = "";
		for($i=0;$i<20;$i++){
			$empty_item .= "F";
		}
		foreach($items as $item){
			$item_identity = substr($item,0,4);
			if($item_identity == "D508"){
				$stones++;
				$inventory = str_replace($item,$empty_item,$inventory);
			}
		}
		$is_exist = count($grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll());
		if($is_exist > 0){
			$stones_add="Update Stones Set Stones=Stones+$stones Where AccountId='$account'";
		}else{
			$stones_add="Insert Into Stones values('$account',$stones)";
		}
		$grizismudb->exec($stones_add);
		$grizismudb->exec("Update Character Set Inventory=0x$inventory Where AccountId='$account' And Name='$char'");
		echo"<p class=\"success\">You successfully added $stones Stones.</p>";
		$user['Stones'] = $user['Stones']+$stones;
		echo"<script>document.getElementById('Stones').innerHTML=\"Stones: ".$user['Stones']."\"</script>";
	}
}
?>
<form Method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars();?>
	</select><br>
	<input type="submit" value="DepositStones" name="DepositStones"/>
</form>