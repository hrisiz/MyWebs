<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

$guild = $_GET['GuildName'];
$characters = $grizismudb->query("Select Character.Name,Character.Resets,Character.cLevel,Character.Class,Character.AccountId From GuildMember,Character Where Character.Name=GuildMember.Name AND GuildMember.G_Name = '$guild'")->fetchAll();
$guild_info = $grizismudb->query("Select * From Guild Where G_Name='$guild'")->fetchAll();
$guild_info = $guild_info[0];
$guild_resets = $grizismudb->query("Select SUM(Character.Resets) From Guild,GuildMember,Character Where Guild.G_Name = GuildMember.G_Name AND Character.Name = GuildMember.Name AND GuildMember.G_Name='$guild' ")->fetchAll();
$all_races_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
?>
<br>
<p>Guild Name:<?=$guild_info['G_Name']?></p>
<p>Guild Master:<a href="/?page=Modules_Character-Info&CharacterName=<?=$guild_info['G_Master']?>"><?=$guild_info['G_Master']?></a></p>
<p>Guild Score:<?=$guild_info['G_Score']?></p>
<p>All Guild Resets:<?=$guild_resets[0][0]?></p>
<h3>Guild Members</h3>
<table class="ranking">
<tr><th>#</th><th>Name</th><th>Level/Resets</th><th>Class</th><th>Status</th></tr>
<?php
	$counter = 1;
	foreach($characters as $char){	
		$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='$char[4]' AND ConnectStat = 1")->fetchAll());
		$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
		$status = "<span class='error'>Offline</span>";
		if ($status >= 1 && $char_in_game >= 1)
		{
			$status = "<span class='success'>Online</span>";
		}
		echo"<tr><td>$counter</td><td><a href=\"/?page=Modules_Character-Info&CharacterName=$char[0]\">$char[0]</a></td><td>$char[1]/$char[2]</td><td>".$all_races_name[$char[3]]."</td><td>$status</td></tr>";
		$counter++;
	}
?>
</table>