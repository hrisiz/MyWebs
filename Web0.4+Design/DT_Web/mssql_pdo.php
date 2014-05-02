<?php
set_exception_handler('error_show');

function error_show(Exception $err)
{
	echo ($err->getMessage());
}
function ms_connect()
{
	$host = MSSQL_HST;
	$username = MSSQL_USR;
	$password = MSSQL_PWD;
	$database = MSSQL_SDB;
	try {
		$con= new PDO('odbc:Driver={SQL Server};Server='.$host.';Database='.$database.';Uid='.$username.';Pwd='.$password.';');
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$con->setAttribute(PDO::ATTR_PERSISTENT, true);
	}catch(PDOException $err){
		die('ERROR: ' . $err->getMessage());
	}
	return $con;
}

function mssql_connect($host,$user,$pass)
{
	if(!defined('MSSQL_HST'))
	{
		define('MSSQL_HST', $host);
		define('MSSQL_USR', $user);
		define('MSSQL_PWD', $pass);
	}
	return true;
}

function mssql_select_db($db,$mssql=null)
{
	if(!defined('MSSQL_SDB'))
	{
		define('MSSQL_SDB', $db);
	}
	return ms_connect();
}

function mssql_query($sql)
{
	try {
		$cms = ms_connect();
		$query = $cms->prepare($sql);
		$query->execute();
		return $query; 
	}catch(PDOException $err){
		throw new Exception($err->getMessage());
	}
	// pravi problemi samo kogato pr: $query = mssql_query('SELECT * FROM Character WHERE Name="'.$char.'"'); tuk vadi gre6ka no
	//$query = mssql_query("SELECT * FROM Character WHERE Name='".$char."'");  tuk si4ko e ok hmm mi nz kakuv be6e problema ne go pomnq :S
}
function mssql_fetch_assoc($sql)
{
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$fetch = $sql->fetch();
	return $fetch;
}

function mssql_fetch_array($sql)
{
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$fetch = $sql->fetch();
	return $fetch;
}
function mssql_result($sql,$param1,$param2)
{
	$sql->setFetchMode(PDO::FETCH_NUM);
	$fetch = $sql->fetch();
	return $fetch[$param1][$param2];
}


function mssql_fetch_row($sql)
{
	$sql->setFetchMode(PDO::FETCH_NUM);
	$fetch = $sql->fetch();
	return $fetch;
}

function mssql_num_rows($query)
{
	$count=0;
	while($query->fetch())
	{
		$count++;
	}
	$query->closeCursor();
	$query->execute();
	return $count;
}

function mssql_close()
{
	$cms = ms_connect();
	$cms = null;
	return $cms;
}


