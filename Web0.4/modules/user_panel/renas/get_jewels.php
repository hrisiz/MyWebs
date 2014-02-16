
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
$inventory = $grizismudb->query("Select * From warehouse Where AccountId='Admin'")->fetchAll();
$inventory = $inventory[0]['Items'];
get_empty_item_places($inventory,2,2,15)
?>