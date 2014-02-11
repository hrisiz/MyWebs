<?php
if (eregi("config.php", $_SERVER['SCRIPT_NAME'])) { header("Location: index.php"); }

//Sql server detailes
error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
$web['connection'] = 'mssql';

$web['dbhost'] = 'MyFavoriteComputer';

$web['database'] = 'MuOnline';

$web['dbuser'] = 'sa';

$web['dbpassword'] = 'mypowerfullpassword';

$dbc = mssql_connect($web['dbhost'], $web['dbuser'], $web['dbpassword']) or die("Couldn't connect to SQL Server!"); 
$selected = mssql_select_db($web['database'],$dbc) or die("Couldn't open database"); 
?>