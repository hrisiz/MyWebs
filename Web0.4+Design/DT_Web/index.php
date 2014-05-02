<?php
	session_start();
	ob_start();
	require 'mssql_pdo.php';
	require 'configs/config.php';
	require 'inc/sqlcfg.php';
	require 'inc/modules_funcs.php';
	require 'inc/main_funcs.php';

	require 'themes/' . $option['theme'] . '/theme.php';