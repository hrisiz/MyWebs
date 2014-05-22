<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
	$char = $_REQUEST['CharacterName'];
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
	$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char."' AND ConnectStat = 1")->fetchAll());
	$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char'")->fetchAll());
	$status = "<span class='error'>Offline</span>";
	if ($status >= 1 && $char_in_game >= 1)
	{
		$status = "<span class='success'>Online</span>";
	}
	$special = Array(0=>"Normal User",NULL=>"Normal User",8=>"Game Master");
	$maps = Array("Lorencia","Dungeon","Davias","Noria","Losttower","Exile","Stadium","Atlans","Tarkan","Devil Squeare","Icarus","Blood Castle 1","Blood Castle 2","Blood Castle 3","Blood Castle 4","Blood Castle 5","Blood Castle 6");
	if(empty($acc_info['country'])){
		$acc_info['country'] = "Unknown";
	}
	$week_online_time = get_time($char_info['WeekOnlineTime']);
	$total_online_time = get_time($char_info_for_acc['TotalTime']);
	$week_online_time = $week_online_time['Hours'].":".$week_online_time['Minutes'].":".$week_online_time['Seconds'];
	$total_online_time = $total_online_time['Hours'].":".$total_online_time['Minutes'].":".$total_online_time['Seconds'];
	
?>
<div id="character_info">
  <img src="images/<?=$all_races_short_name[$char_info['Class']]?>.jpg" alt="Class Picture" />
  <dl>
    <dt>Name</dt>
      <dd><?=$char?></dd>
    <dt>Guild</dt>
      <dd><?=$guild ?></dd>
    <dt>Country</dt>
      <dd><?=$acc_info['country'] ?></dd>
    <dt>Map</dt>
      <dd><?=$maps[$char_info['MapNumber']] ?></dd>
    <dt>Type</dt>
      <dd><?=$special[$char_info['CtlCode']] ?></dd>
    <dt>Status</dt>
      <dd><?=$status ?></dd>
    <dt>Level</dt>
      <dd><?=$char_info['cLevel'] ?></dd>
    <dt>Reset</dt>
      <dd><?=$char_info['Resets'] ?></dd>
    <dt>Bonus Points</dt>
      <dd><?=intval($char_info['BonusPoints']) ?></dd>
    <dt>Quest</dt>
      <dd><?=$char_info['QuestNumber'] ?></dd>
    <dt>Kills</dt>
      <dd><?=$char_info['PkCount'] ?></dd>
  </dl>
  <dl>
    <dt>Last Connect</dt>
      <dd><?=date("d/m/Y H:i", strtotime($char_info_for_acc['ConnectTM'])) ?></dd>
    <dt>Last Disconnect</dt>
      <dd><?=date("d/m/Y H:i", strtotime($char_info_for_acc['DisConnectTM'])) ?></dd>
    <dt>Week Online Time</dt>
      <dd><?=$week_online_time ?></dd>
    <dt>Tatal Online Time</dt>
      <dd><?=$total_online_time?></dd>
  </dl>
</div>