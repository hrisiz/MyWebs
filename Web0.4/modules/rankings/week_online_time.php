<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<table class="ranking">
<tr><th>#</th><th>Name</th><th>Online Time</th></tr>
<?php
$i = 0;
foreach(($grizismudb->query("Select Top 100 * From Character Order by WeekOnlineTime desc")->fetchAll()) as $account){
	$i++;
	$min = $account['WeekOnlineTime']; 
	$chas = floor($min/60); 
	$days = floor($chas/24); 
	$chas = $chas % 24; 
	$min = $account['WeekOnlineTime'] % 60;
	echo"<tr><td>$i</td><td><a href=\"?page=CharacterInfo&CharacterName=".$account['Name']."\">".$account['Name']."<a/></td>";
	if($days > 0 && $chas >0){
		echo"<td>$days Days $chas Hours</td>";
	}else{
		echo"<td>$min Minutes</td>";
	}
	echo"</tr>";
}
?>
</table>