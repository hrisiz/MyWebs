<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<table class="ranking" id="TopCharacters">
	<tr><th>Name</th><th>Level/Res</th></tr>
	<?php
	foreach($grizismudb->query('Select Top 10 Name,cLevel,Resets From Character where CtlCode=0 OR CtlCode IS NULL order by Resets desc,cLevel desc') as $char_info) {
		echo"<tr><td><a href=\"?page=Modules_Character-Info&CharacterName=$char_info[0]\">$char_info[0]</a></td><td>$char_info[1]/<span id='resets'>$char_info[2]</span></td></tr>";
	}
	?>
</table>