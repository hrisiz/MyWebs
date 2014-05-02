<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['ready'])){
	$character = $_POST['character'];
	$item = intval($_POST['item']);
	$stones = intval($_POST['stones']);
	$renas = intval($_POST['renas']);
	$zen = intval($_POST['zen']);
	$old_inventory = "";
	if($character == "Warehouse"){
		$old_inventory = $grizismudb->query("Select Items From warehouse Where AccountId='$account'")->fetchAll();
		$old_inventory = $old_inventory[0][0];
		$item_code = substr($old_inventory,$item*20,20);
	}else{
		$old_inventory = $grizismudb->query("Select Inventory From Character Where AccountId='$account' AND Name='$character'")->fetchAll();
		$old_inventory = $old_inventory[0][0];
		$item_code = substr($old_inventory,$item*20,20);
	}
	if(empty($character) ){
		echo"<p class=\"error\">Please choose a character.</p>";
	}elseif(empty($item) && $item != 0){
		echo"<p class=\"error\">Please choose a item.</p>";
	}elseif(empty($stones) && empty($renas) && empty($zen)){
		echo"<p class=\"error\">Please use a currency.</p>";
	}elseif($character != "Warehouse" && (count($grizismudb->query("Select * From Character Where Name='$character'")->fetchAll()) <= 0)){
		echo"<p class=\"error\">This is not your character.</p>";
	}elseif(empty($account)){
		echo"<p class=\"error\">Please login first.</p>";
	}elseif(count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat=1")->fetchAll()) > 0){
		echo"<p class=\"error\">You should be offline.</p>";
	}elseif(substr($item_code,0,4) == "FFFF"){
		echo"<p class=\"error\">This isn't a correct item.</p>";
	}else{
		if($character == "Warehouse"){
			$new_inventory = substr_replace($old_inventory,"FFFFFFFFFFFFFFFFFFFF",$item*20,20);
			$update_inventory = "Update warehouse Set Items=0x$new_inventory Where AccountId='$account'";
		}else{
			$new_inventory = substr_replace($old_inventory,"FFFFFFFFFFFFFFFFFFFF",$item*20,20);
			$update_inventory = "Update Character Set Inventory=0x$new_inventory Where AccountId='$account' AND Name='$character'";
		}
		$online_time = 0;
		$grizismudb->exec("Insert Into Web_Market values('$account',0x$item_code,$stones,$renas,$zen,$online_time,".time().")");
		$grizismudb->exec($update_inventory);
		echo"<p class=\"success\">You successfully added the item for sell.</p>";
	}
}
?>
<form method="POST">
	<div id="items"></div>
	<select onchange='get_file("items","Modules_User-Panel_Web-Market_Get-Items&character="+this.options[this.selectedIndex].value)' name="character">
		<option value="">--Select--</option>
		<?php echo get_chars(-1,-1,Array("Warehouse"));?>
	</select><br>
</form>