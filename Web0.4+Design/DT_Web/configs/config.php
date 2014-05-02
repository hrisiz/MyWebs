<?php
	$sql_host = 'WIN-QCJ6LL1IJDS'; // Sql server host: 127.0.0.1,localhost,Your Computer Name
	$sql_user = 'sa'; // Sql server user: sa
	$sql_pass = 'Psihopat1'; // Sql server password
	$database = 'MuOnline'; // Mu online database: default = MuOnline

	$sql_connect = mssql_connect($sql_host, $sql_user, $sql_pass) or die('Couldn&#39;t connect to SQL Server!');
	$db_connect = mssql_select_db($database, $sql_connect) or die('Couldn&#39;t open database: ' . $database);
	
	$option['title'] = 'DT Web 0.1'; // Website title
	$option['theme'] = 'MuGlobal'; // The website theme / template / design
	$option['server_name'] = 'MuDT'; // Server name
	$option['server_ip'] = '127.0.0.1'; // Game Server ip
	$option['server_port'] = 55901; // Game Server port
	$option['server_version'] = '0.1';  // Server version
	$option['server_hosted'] = 'Bulgaria / Stamboliyski';  // Server hosted in: Country / City
	$option['server_exp'] = '50x'; // Server xp
	$option['server_drop'] = '30%'; // Server drop
	
	$option['has_dl'] = 0; // (IMPORTANT) Dark Lord: 1 = enable, 0 =  disable
	
	// rc = Reset Character
	$option['rc_level'] = 1; // Level required to reset a character
	$option['rc_zen'] = 20000000; // Zen required to reset a character
	$option['rc_zen_type'] = 0; // Increase required zen for every reset: 1 = enable, 0 =  disable 
	$option['rc_stats_type'] = 1; // Increase stats for every reset(1r=500,2r=1000,...): 1 = enable, 0 =  disable 
	$option['rc_max_resets'] = 200; // Max resets
	$option['rc_stats_per_reset'] = 500; // Bonus stats per reset
	$option['rc_clear_stats'] = 1; // Clear stats after reset: 1 = enable, 0 =  disable

	// Bonus points for every class
	$option['rc_bonus_points'] = 0; // Bonus points for every class: 1 = enable, 0 =  disable 
	$option['rc_stats_for_sm'] = 300; // Points for dw,sm and grm 
	$option['rc_stats_for_bk'] = 400; // Points for dk,bk and  bm
	$option['rc_stats_for_me'] = 500; // Points for elf,me and he
	$option['rc_stats_for_mg'] = 600; // Points for mg and dum 
	$option['rc_stats_for_dl'] = 700; // Points for dl and le
	
	// as = Add Stats
	$option['as_max_stats'] = 32767; // The maximum stats a character have
	
	// pkc = PK Clear
	$option['pkc_zen'] = 15000000; // Zen required to clear pk level
	$option['pkc_zen_type'] = 1; // Increase required zen for every pk level: 1 = enable, 0 =  disable 

	// rs = Reset Stats
	$option['rs_level'] = 400; // Level required to reset stats
	$option['rs_resets'] = 10; // Resets required to reset stats
	$option['rs_zen'] = 20000000; // Zen required to reset stats
	
	// gr = Grand Reset
	$option['gr_level'] = 400; // Level required to grand reset
	$option['gr_resets'] = 10; // Resets required to grand reset
	$option['gr_zen'] = 20000000; // Zen required to grand reset
	$option['gr_reward'] = 1000; // Reward for a grand reset - this is also the after gr start points
	$option['gr_max_resets'] = 10; // Max grand resets
	
	$option['rc_gr_bonus'] = 1; // Reward points for grand reset: 1 = enable, 0 =  disable
	// for credits in savoy webshop
	$option['gr_credits'] = 1; // Reward credits: 1 = enable, 0 = disable
	$option['gr_reward_name'] = 'Credits & Points'; // Reward name: Points,Credits,Coins, etc... This is only text
	$option['cr_db_table'] = 'MEMB_CREDITS'; // DB table name for the reward: if reward savoy credits table = MEMB_CREDITS
	$option['cr_db_column'] = 'credits'; // DB column name for the reward: if reward savoy credits column = credits
	$option['cr_db_check_by'] = 'memb___id'; // What column is checked: if reward savoy credits column = memb___id 
	// if account = memos
	// final query string: SELECT credits FROM MEMB_CREDITS WHERE memb___id="memos"
