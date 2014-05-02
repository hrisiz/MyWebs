<?php

function make_log($file_name, $content)
{
	$file_date = date('d_m_Y', time());
    $log_date = date('h:i:s', time());
	$log_content='Date: '.$log_date .' | ' . $content . "\r\n";
	file_put_contents('logs/'.$file_name.'['.$file_date.'].log', $log_content, FILE_APPEND);
}

function show_messages($store)
{
	$msgs = (@$store['error']) ? $store['error'] : $store['success'];
	$msg_type = (@$store['error']) ? 'error' : 'success';
	foreach($msgs as $msg)
	{
		echo '<p class="'.$msg_type.'"> '.$msg.'</p>';
	}
}

function show_msg($msg, $num = 0)
{
	$label = ($num === 0) ? 'error' : 'success';
	$message[$label] = array();
	$message[$label][] = $msg;
	show_messages($message);
}

function char_class($value, $view=0)
{
	$class = array(
		0 => array("Dark Wizard","DW"),1 => array("Soul Master","SM"),2 => array("Grand Master","GrM"),3 => array("Grand Master","GrM"),
		16 => array("Dark Knight","DK"),17 => array("Blade Knight","BK"),18 => array("Blade Master","BM"),19 => array("Blade Master","BM"),
		32 => array("Fairy Elf","Elf"),33 => array("Muse Elf","ME"),34 => array("High Elf","HE"),35 => array("High Elf","HE"),
		48 => array("Magic Gladiator"),49 => array("Duel Master","DM"),50 => array("Duel Master","DM"),
		64 => array("Dark Lord","DL"),65 => array("Lord Emperor","LE"),66 => array("Lord Emperor","LE"),
		80 => array("Summoner","Sum"),81 => array("Bloody Summoner","BS"),82 => array("Dimension Master","DiM"),83 => array("Dimension Master")
	);
	return isset($class[$value][$view]) ? $class[$value][$view] : 'Unknown';   
}

function pk_level($value, $view=0)
{
	$pklevel = array( 
		1 => array('<span style="color:#605ca8;">Hero</span>','<span style="color:#605ca8;">H.</span>'), 
		2 => array('<span style="color:#605ca8;">Commoner</span>','<span style="color:#605ca8;">C.</span>'), 
		3 => array('<span>Normal</span>','<span>N.</span>'), 
		4 => array('<span style="color:#fbaf5d;">Against Murderer</span>','<span style="color:#fbaf5d;">A.M.</span>'), 
		5 => array('<span style="color:#a0410d;">Murderer</span>','<span style="color:#a0410d;">M.</span>'), 
		6 => array('<span style="color:#c81118;">Phonomania</span>','<span style="color:#c81118;">P.</span>')
	);
	return isset($pklevel[$value][$view]) ? $pklevel[$value][$view] : 'Unknown';   
}

function is_online($char_name, $only_user=0)
{
	$accountid = mssql_fetch_row(
		mssql_query("SELECT AccountID FROM Character WHERE Name='". $char_name ."'")
	);
	
	$check_status = mssql_fetch_row(
		mssql_query("SELECT ConnectStat FROM MEMB_STAT WHERE memb___id='". $accountid[0] ."'")
	);
	
	$name = mssql_fetch_row(
		mssql_query("SELECT GameIDC FROM AccountCharacter WHERE id='". $accountid[0] ."'")
	);
	
	if($only_user===1 && $check_status[0] >= 1){ return 1; }
	elseif($check_status[0] >= 1 && $name[0] == $char_name){ return 1; }
	else{ return 0; }
}

function char_info($char_name)
{
	$char = mssql_fetch_array(
		mssql_query("SELECT * FROM Character WHERE Name='". $char_name ."'")
	);
	
	$guild = mssql_fetch_array(
		mssql_query("SELECT G_Name FROM GuildMember WHERE Name='". $char['Name'] ."'")
	);
	
	if($guild['G_Name']==NULL)
	{
		$char['cGuild'] = 'No Guild';
	}
	else
	{
		$char['cGuild'] = $guild['G_Name'];
	}
	return $char;
}

function pagination($offset = 0, $limit = 0, $select = NULL, $table = NULL, $order = NULL, $id_field = NULL, $where = NULL)
{
	$sql_query = 'SELECT TOP ' . (intval($limit)).' ' . $select . '
		FROM ' . $table . ' WHERE '.(!empty($where) ? $where . ' AND ': '').' ' . $id_field . '
		NOT IN (SELECT TOP ' . (intval($offset)).' ' . $id_field . ' 
		FROM ' . $table . (!empty($where) ? ' WHERE ' . $where : '').' 
		ORDER BY ' . $order . ') ORDER BY ' . $order;

    return $sql_query;
}