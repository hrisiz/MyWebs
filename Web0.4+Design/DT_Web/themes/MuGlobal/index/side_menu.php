<ul>
	<li class="nav_text">MU ONLINE</li>
	<li><a href="?p=files">Download Client</a></li>
	<li><a href="?p=halloffame">Hall Of Fame</a></li>
	<li><a href="?p=information">Information</a></li>
	<li><a href="?p=statistics">Statistics</a></li>

	<li class="nav_text">Account</li>
	<li><a href="<?php echo (isset($_SESSION['dt_username'])) ? '?p=characters' : '?p=login' ; ?>">My Account</a></li>
	<li><a href="?p=register">Register</a></li>
	
	<li class="nav_text">News</li>
	<li><a href="?p=home">Game Notices</a></li>
	
	<li class="nav_text">Rankings</li>
	<li><a href="?p=topchars">Top Characters</a></li>
	<li><a href="?p=topguilds">Top Guilds</a></li>
	<li><a href="?p=topkillers">Top Killers</a></li>
	<li><a href="?p=gamemasters">Game Masters</a></li>
</ul>