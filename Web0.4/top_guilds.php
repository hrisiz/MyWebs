<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<table id="TopCharacters">
	<tr><th>Name</th><th>Resets</th></tr>
	<?php
	foreach($grizismudb->query('Select Top 10 Guild.G_Name,SUM(Character.Resets) From Guild,GuildMember,Character Where Guild.G_Name = GuildMember.G_Name AND Character.Name = GuildMember.Name GROUP BY Guild.G_Name order by SUM(Character.Resets) desc') as $char_info) {
		echo"<tr><td><a href=\"?page=Modules_Guild-Info&GuildName=$char_info[0]\">$char_info[0]</a></td><td>$char_info[1]</td></tr>";
	}
	?>
</table>