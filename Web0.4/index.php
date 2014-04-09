<?php
	ob_start();
	session_start();
	include "inc/sql_connect.php";
	include "inc/server_settings.php";
	include "inc/security.php";
	include "inc/modules_functions.php";
	include "inc/get_item_info.php";
	include "inc/auction_item.php";
	include "inc/quest_system.php";
	if(isset($_SESSION['User'])){
		$account = $_SESSION['User'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GrizisMu</title>
		<meta charset="UTF-8"/>
		<link  rel="stylesheet" type="text/css" href="CSS/style.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/typography.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/positions.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/modules.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/user_panel.css"></link>
		<script type="text/JavaScript" src="JS/overlib/overlib.js"></script>
		<script type="text/JavaScript" src="JS/MyJS_Codes.js"></script>
	</head>
	<body>
		<header>
			<img src="images/header.png" alt="header" width="100%" height="200px"/>
			<nav>
				<a href="?page=Modules_Home">Home</a>
				<a href="?page=Modules_Register">Register</a>	
				<a href="?page=Modules_Download">Download</a>
				<a href="?page=Modules_Rankings&subpage=Characters">Rankings</a>
				<a href="?page=Modules_Information&subpage=Server">Information</a>	
			</nav>
		</header>
		<section>
			<div id="right">
				<h2>Top 10 Characters</h2>
				<div>
					<?php
						include "top_characters.php";
					?>
				</div>
				<h2>Top 10 Guilds</h2>
				<div>
					<?php
						include "top_guilds.php";
					?>
				</div>
			</div>
			<div id="left">
				<h2 id="h2">User Panel</h2>
				<div>
					<?php
						include "login_content.php";
					?>
				</div>
				<h2>Information</h2>
				<div>
					<?php
						include "info.php";
					?>
				</div>
			<div style="margin-top:10px; margin-bottom:10px; height:70px; width:80%; background-color:white; margin-left:auto; margin-right:auto;"></div>
			</div>
			<div id="center">
				<?php
					include "switch.php";
				?>
			</div>
		</section>
		<footer>
			<p>GrizisMu &#64; All Rights Reserved</p>
		</footer>
	</body>
</html>
