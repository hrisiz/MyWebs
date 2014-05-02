<?php

	$accounts = mssql_num_rows(mssql_query('SELECT bloc_code FROM MEMB_INFO'));
	$characters = mssql_num_rows(mssql_query('SELECT Name FROM Character'));
	$guilds = mssql_num_rows(mssql_query('SELECT G_Name FROM Guild'));
	
	$ban_chars = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE CtlCode = 1'));
	$ban_accs = mssql_num_rows(mssql_query('SELECT bloc_code FROM MEMB_INFO WHERE bloc_code = 1'));
	
	$dw = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 0'));
	$sm = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 1'));
	$dk = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 16'));
	$bk = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 17'));
	$elf = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 32'));
	$me = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 33'));
	$mg = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 48'));
	$dl = mssql_num_rows(mssql_query('SELECT Name FROM Character WHERE Class = 64'));
	
	$online = mssql_num_rows(mssql_query('SELECT ConnectStat FROM MEMB_STAT WHERE ConnectStat > 0'));
	
	$status='<span style="color:#890000;">Offline</span>';
	
	if($stscheck=@fsockopen($option['server_ip'], $option['server_port'], $ERROR_NO, $ERROR_STR, (float)0.5))
	{ 
		$status='<span style="color:#089000;">Online</span>';
		fclose($stscheck); 
	}

?>
<table>
	<tr class="title">
		<td>Information</td>
		<td>Statistics</td>
	</tr>
	<tr>
		<td><p class="left">Server name: </p><p class="right" style="color:#777;"><?php echo $option['server_name']; ?></p></td>
		<td><p class="left">Total Accounts: </p><p class="right" style="color:#777;"><?php echo $accounts; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Server is from: </p><p class="right" style="color:#777;"><?php echo $option['server_hosted']; ?></p></td>
		<td><p class="left">Total Characters: </p><p class="right" style="color:#777;"><?php echo $characters; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Version: </p><p class="right" style="color:#777;"><?php echo $option['server_version']; ?></p></td>
		<td><p class="left">Total Guilds: </p><p class="right" style="color:#777;"><?php echo $guilds; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Exp &amp; Drops: </p><p class="right" style="color:#777;"><?php echo $option['server_exp'].' &amp; '.$option['server_drop']; ?></p></td>
		<td><p class="left">Banned Characters/Accounts: </p><p class="right" style="color:#890000;"><?php echo $ban_chars .'/'. $ban_accs; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Server status: </p><p class="right"><?php echo $status; ?></p></td>
		<td><p class="left">Users Online: </p><p class="right" style="color:#089000;"><?php echo $online; ?></p></td>
	</tr>
</table>
<table>
	<tr class="title">
		<td>First Class</td>
		<td>Second Class</td>
	</tr>
	<tr>
		<td><p class="left">Dark Wizard: </p><p class="right" style="color:#777;"><?php echo $dw; ?></p></td>
		<td><p class="left">Soul Master: </p><p class="right" style="color:#777;"><?php echo $sm; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Dark Knight: </p><p class="right" style="color:#777;"><?php echo $dk; ?></p></td>
		<td><p class="left">Blade Knight: </p><p class="right" style="color:#777;"><?php echo $bk; ?></p></td>
	</tr>
	<tr>
		<td><p class="left">Fairy Elf: </p><p class="right" style="color:#777;"><?php echo $elf; ?></p></td>
		<td><p class="left">Muse Elf: </p><p class="right" style="color:#777;"><?php echo $me; ?></p></td>
	</tr>
	<tr>
		<td colspan="2"><p class="left">Magic Gladiator: </p><p class="right" style="color:#777;"><?php echo $mg; ?></p></td>
	</tr>
	<?php if($option['has_dl'] === 1): ?>
	<tr>
		<td colspan="2"><p class="left">Dark Lord: </p><p class="right" style="color:#777;"><?php echo $dl; ?></p></td>
	</tr>
	<?php endif; ?>
</table>