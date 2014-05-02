<?php
	$error = 0;
	$current_page = (isset($_GET['p'])) ? $_GET['p'] : 'home';
	
	$active_pages['home'] = 'home.php';
	$active_pages['register'] = 'register.php';
	$active_pages['topchars'] = 'rank-characters.php';
	$active_pages['topguilds'] = 'rank-guilds.php';
	$active_pages['topkillers'] = 'rank-killers.php';
	$active_pages['gamemasters'] = 'rank-game_masters.php';
	$active_pages['login'] = 'user_panel.php';
	$active_pages['logout'] = 'user_panel.php';
	$active_pages['files'] = 'downloads.php';
	$active_pages['information'] = 'information.php';
	$active_pages['halloffame'] = 'hall_of_fame.php';
	$active_pages['statistics'] = 'statistics.php';
	
	if(isset($_SESSION['dt_username']) && isset($_SESSION['dt_password']))
	{
		$active_pages['characters'] = 'user/characters.php';
		$active_pages['resetcharacter'] = 'user/reset_character.php';
		$active_pages['addstats'] = 'user/add_stats.php';
		$active_pages['pkclear'] = 'user/pk_clear.php';
		$active_pages['resetstats'] = 'user/reset_stats.php';
		$active_pages['grandreset'] = 'user/grand_reset.php';
		$active_pages['market'] = 'user/market.php';
	}

	if(@$active_pages[$current_page] && file_exists('mod/' . $active_pages[$current_page]))
	{
		include('mod/' . $active_pages[$current_page]);
	}
	else
	{
		echo '<p class="error">Page not found or you don&#39;t have the permission to access this page.</p>';
	}