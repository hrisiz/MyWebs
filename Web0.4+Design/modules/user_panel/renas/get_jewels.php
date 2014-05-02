<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
$inventory = $grizismudb->query("Select * From warehouse Where AccountId='Admin'")->fetchAll();
$inventory = $inventory[0]['Items'];
if(isset($_POST['get_jewels'])){
	$all_jewels = 	array(array(15,12,"Jewel of Chaos"),
					array(13,14,"Jewel of Bless"),
					array(14,14,"Jewel of Soul"),
					array(16,14,"Jewel of Life"),
					array(22,14,"Jewel of Creation")
	);
	$jewel_type = $all_jewels[intval($_POST['jewel_type'])];
	$jewels_count = intval($_POST['count']);
	$i = 0;
	$renas_check = $grizismudb->query("Select Renas From Renas Where AccountId='$account'")->fetchAll();
	if($renas_check[0][0] < $jewels_count*$jewels_cost[$jewel_type[2]]){
		echo"<p class=\"error\">You don't have enough Renas.</p>";
	}else{
			$grizismudb->beginTransaction();
		for($i = 0; $i < $jewels_count;$i++){
			if(!add_item($jewel_type[1],$jewel_type[0])){
				echo"<p class=\"error\">You don't have enough space to get $jewels_count jewels.</p>";
				break;
			}
		}
		$cost = $i * $jewels_cost[$jewel_type[2]];
		$grizismudb->exec("Update Renas Set Renas=Renas-$cost Where AccountId='$account'");

		if($i == $jewels_count){
			$grizismudb->commit();			
			$user['Renas'] = $user['Renas'] - $cost;
			echo"<script>update_info('user_renas',".$user['Renas'].")</script>";
			echo"<p class=\"success\">$i $jewel_type[2] were Successfully Add.</p>";
		}else{
			$grizismudb->rollBack();
		}
	}
}
?>
<form method="POST">
	<label for="count">Jewels count</label>
	<input type="number" name="count" id="count" value="1" min="1" max="120"/><br>
	<label for="jewel_type">Jewels type</label>
	<select name="jewel_type" id="jewel_type">
		<option value="0">Jewel of Chaos[<?=$jewels_cost['Jewel of Chaos']?> Renas]</option>
		<option value="1">Jewel of Bless[<?=$jewels_cost['Jewel of Bless']?> Renas]</option>
		<option value="2">Jewel of Soul[<?=$jewels_cost['Jewel of Soul']?> Renas]</option>
		<option value="3">Jewel of Life[<?=$jewels_cost['Jewel of Life']?> Renas]</option>
		<option value="4">Jewel of Creation[<?=$jewels_cost['Jewel of Creation']?> Renas]</option>
	</select><br>
	<input type="submit" name="get_jewels" value="Get Jewels"/>
</form>