<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table id="TopCharacters">
  <thead>
    <tr><th>Name</th><th>Resets</th></tr>
  </thead>
	<?php
	foreach($grizismudb->query('Select Top 10 Guild.G_Name,SUM(Character.Resets) From Guild,GuildMember,Character Where Guild.G_Name = GuildMember.G_Name AND Character.Name = GuildMember.Name GROUP BY Guild.G_Name order by SUM(Character.Resets) desc') as $char_info) {
		echo"<tr><td><a href=\"?page=Modules_Guild-Info&GuildName=$char_info[0]\">$char_info[0]</a></td><td>$char_info[1]</td></tr>";
	}
	?>
</table>