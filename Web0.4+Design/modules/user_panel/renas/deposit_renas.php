<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}

if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if (isset($_POST['DepositRenas'])){
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
		$renas = 0;
		$empty_item = "";
		for($i=0;$i<20;$i++){
			$empty_item .= "F";
		}
		foreach($items as $item){
			$item_identity = substr($item,0,4);
			if($item_identity == "D500"){
				$renas++;
				$inventory = str_replace($item,$empty_item,$inventory);
			}
		}
		$is_exist = count($grizismudb->query("Select Renas From Renas Where AccountId='$account'")->fetchAll());
		if($is_exist > 0){
			$renas_add="Update Renas Set Renas=Renas+$renas Where AccountId='$account'";
		}else{
			$renas_add="Insert Into Renas values('$account',$renas)";
		}
		$grizismudb->exec($renas_add);
		$grizismudb->exec("Update Character Set Inventory=0x$inventory Where AccountId='$account' And Name='$char'");
		echo"<p class=\"success\">You successfully added $renas Renas.</p>";
	}
}
?>
<form Method="POST">
	<label>Character:</label>
	<select name=\"character\">
		<?php echo get_chars();?>
	</select><br>
	<input onclick="startLoading()" type="submit" value="DepositRenas" name="DepositRenas"/>
</form>