<?php
	session_start();
	include "inc/sql_connect.php";
	include "inc/server_settings.php";
	include "inc/security.php";
	include "inc/modules_functions.php";
	if(isset($_SESSION['User'])){
		$account = $_SESSION['User'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GrizisMu</title>
		<meta charset="UTF-8"/>
		<link  rel="stylesheet" type="text/css" href="CSS/basic.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/typography.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/positions.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/modules.css"></link>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script>
			$(document).ready(function(){
			  $( "#right,#left > h2+div>div" ).accordion();
			});
		</script>
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
