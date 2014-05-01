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
	define('WEB_INDEX', TRUE);
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
			<?php include"header.php";?>
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
			<p>GrizisMu &copy; All Rights Reserved</p>
		</footer>
	</body>
</html>
