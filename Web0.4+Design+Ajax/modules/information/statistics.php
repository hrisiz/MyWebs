<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
	$characters = count($grizismudb->query("Select Name From Character")->fetchAll());
	$maxresetsa = count($grizismudb->query("Select Name From Character Where Resets='".$serverinfo['max_resets']."'")->fetchAll());
	$mules = count($grizismudb->query("Select Name From Character Where Resets='0' AND cLevel>'0' AND cLevel<'20'")->fetchAll());
	$accounts = count($grizismudb->query("Select memb___id From MEMB_INFO")->fetchAll());
	$guilds = count($grizismudb->query("Select G_Name From Guild")->fetchAll());
	$max = $grizismudb->query("SELECT MaxPlayers,Date FROM MaxPlayers")->fetchAll();            
	$dw = count($grizismudb->query("Select Name From Character Where Class='0'")->fetchAll());
	$sm = count($grizismudb->query("Select Name From Character Where Class='1'")->fetchAll());
	$dk = count($grizismudb->query("Select Name From Character Where Class='16'")->fetchAll());
	$bk = count($grizismudb->query("Select Name From Character Where Class='17'")->fetchAll());
	$elf = count($grizismudb->query("Select Name From Character Where Class='32'")->fetchAll());
	$me = count($grizismudb->query("Select Name From Character Where Class='33'")->fetchAll());
	$mg = count($grizismudb->query("Select Name From Character Where Class='48'")->fetchAll());
	$dl= count($grizismudb->query("Select Name From Character Where Class='64'")->fetchAll());
	$banned = count($grizismudb->query("Select memb___id From MEMB_INFO Where bloc_code='1'")->fetchAll());
	$admins = count($grizismudb->query("Select Name From Character Where CtlCode='8'")->fetchAll());
	if($characters > 0)
	{
		$dwp=round((($dw*100)/$characters),3);
		$smp=round((($sm*100)/$characters),3);
		$bkp=round((($bk*100)/$characters),3);
		$dkp=round((($dk*100)/$characters),3);
		$elfp=round((($elf*100)/$characters),3);
		$mep=round((($me*100)/$characters),3);
		$mgp=round((($mg*100)/$characters),3);
	}
	else
	{
		$dwp=0;
		$smp=0;
		$bkp=0;
		$dkp=0;
		$elfp=0;
		$mep=0;
		$mgp=0;
	}
	if(empty($max[0][0])) {
		$max[0][0] = 0;
	}
	echo"
		<table class=\"information\">
		<tr><td>Server Name:</td><td>".$server['Name']."</td></tr>
		<tr><td>Accounts:</td><td>".$server['Accounts']."</td></tr>
		<tr><td>Characters:</td><td>".$server['Characters']."</td></tr>
		<tr><td>Guilds:</td><td>".$server['Guilds']."</td></tr>
		<tr><td>BannedPlayers:</td><td>$banned</td></tr>
		<tr><td>Server Status:</td><td>".$server['Stats']."</td></tr>
		<tr><td>Online Players:</td><td>".$server['Online_Players']."</td></tr>
		<tr><td>Online Record:</td><td>".$max[0][0]."</td></tr>
		<tr><td>Blade Knights:</td><td>$bk <font color='orange'>($bkp%)</font></td></tr>
		<tr><td>Dark Knights:</td><td>$dk <font color='orange'>($dkp%)</font></td></tr>
		<tr><td>Soul Masters:</td><td>$sm <font color='orange'>($smp%)</font></td></tr>
		<tr><td>Dark Wizards:</td><td>$dw <font color='orange'>($dwp%)</font></td></tr>
		<tr><td>Muse Elfs:</td><td>$me <font color='orange'>($mep%)</font></td></tr>
		<tr><td>Elfs:</td><td>$elf <font color='orange'>($elfp%)</font></td></tr>
		<tr><td>Magic Gladiators:</td><td>$mg <font color='orange'>($mgp%)</font></td></tr>
		<tr><td>Max Resets Characters:</td><td>$maxresetsa</td></tr>
		<tr><td>mules(1-20):</td><td>$mules</td></tr>
		<tr><td>Admins:</td><td>$admins</td></tr>
		</table>
	";
?>