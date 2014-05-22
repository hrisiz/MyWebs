<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="ranking">
  <thead>
    <tr><th>#</th><th>Name</th><th>GuildMaster</th><th>Resets</th></tr>
  </thead>
  <tbody>
	<?php
		$guilds = $grizismudb->query("Select * From Guild")->fetchAll();
		$guilds_ranking = Array();
		foreach($guilds as $guild){
			$guild_members = $grizismudb->query("Select Name From GuildMember Where G_Name='".$guild['G_Name']."'")->fetchAll();
			$guild['Resets'] = 0;
			foreach($guild_members as $character){
				$resets = $grizismudb->query("Select Resets From Character Where Name='$character[0]'")->fetchAll();
				$guild['Resets'] += $resets[0][0];
			}
			$guilds_ranking[$guild['Resets']] = Array($guild['G_Name'],$guild['G_Master']);
		}
		krsort($guilds_ranking);
		$i =1;
		foreach($guilds_ranking as $resets=>$guild_row){
			echo"<tr><td>$i</td><td>$guild_row[0]</td><td><a href=\"?page=CharacterInfo&CharacterName=$guild_row[1]\">$guild_row[1]</a></td><td>$resets</td></tr>";
			$i++;
			if($i > 20){
				break;
			}
		}
	?>
  </tbody>
</table>