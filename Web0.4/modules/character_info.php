<?php
	$char = $_GET['CharacterName'];
	$guild = $grizismudb->query("Select G_Name From GuildMember Where Name='$char'")->fetchAll();
	$guild = $guild[0][0];
	$char_info = $grizismudb->query("Select * From Character Where Name='$char'")->fetchAll();
	$char_info = $char_info[0];
	$acc_info = $grizismudb->query("Select * From MEMB_INFO Where memb___id=(Select AccountId From Character Where Name='$char')")->fetchAll();
	$acc_info = $acc_info[0];
	$char_info_for_acc = $grizismudb->query("Select * From MEMB_STAT Where memb___id=(Select AccountId From Character Where Name='$char')")->fetchAll();
	$char_info_for_acc = $char_info_for_acc[0];
	$all_races_short_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
	$all_races_full_name = Array(1=>"SoulMaster",17=>"BladeKnight",33=>"MuseElf",48=>"MagicGladiator",0=>"DarkWizard",16=>"DarkKnight",32=>"Elf");
	$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char["Name"]."' AND ConnectStat = 1")->fetchAll());
	$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
	$status = "<span class='error'>Offline</span>";
	if ($status >= 1 && $char_in_game >= 1)
	{
		$status = "<span class='success'>Online</span>";
	}
	$special = Array(0=>"Normal User",NULL=>"Normal User",8=>"Game Master");
	$maps = Array("Lorencia","Dungeon","Davias","Noria","Losttower","Exile","Stadium","Atlans","Tarkan","Devil Squeare","Icarus","Blood Castle 1","Blood Castle 2","Blood Castle 3","Blood Castle 4","Blood Castle 5","Blood Castle 6");
	if(empty($acc_info['country'])){
		$acc_info['country'] = "-";
	}
?>
<table id="character_info">
<tr><td style="text-align:right;" rowspan="14" colspan="2"><img width="80%" src="images/<?=$all_races_short_name[$char_info['Class']]?>.jpg" alt="Class Picture" /></td></tr>
<tr><td>Name:</td><td><?=$char?></td></tr>
<tr><td>Guild:</td><td><?=$guild ?></td></tr>
<tr><td>Country:</td><td><?=$acc_info['country'] ?></td></tr>
<tr><td>Class:</td><td><?=$all_races_full_name[$char_info['Class']]?></td></tr>
<tr><td>Map:</td><td><?=$maps[$char_info['MapNumber']] ?></td></tr>
<tr><td>Status:</td><td><?=$status ?></td></tr>
<tr><td>Spacial:</td><td><?=$special[$char_info['CtlCode']] ?></td></tr>
<tr><td>Level:</td><td><?=$char_info['cLevel'] ?></td></tr>
<tr><td>Resets:</td><td><?=$char_info['Resets'] ?></td></tr>
<tr><td>GrandResets:</td><td><?=$char_info['GrandResets'] ?></td></tr>
<tr><td>Bonus Points:</td><td><?=intval($char_info['BonusPoints']) ?></td></tr>
<tr><td>Quest:</td><td><?=$char_info['QuestNumber'] ?></td></tr>
<tr><td>Kills:</td><td><?=$char_info['PkCount'] ?></td></tr>
<tr><td>Last Connect:</td><td><?=date("d/m/Y H:i", strtotime($char_info_for_acc['ConnectTM'])) ?></td><td>Last Disconnect:</td><td><?=date("d/m/Y H:i", strtotime($char_info_for_acc['DisConnectTM'])) ?></td></tr>
<tr><td>Week Online Time:</td><td><?=get_time($char_info['WeekOnlineTime']) ?></td><td>Tatal Online Time:</td><td><?=get_time($char_info_for_acc['TotalTime'])  ?></td></tr>
</table>