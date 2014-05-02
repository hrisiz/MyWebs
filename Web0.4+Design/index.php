<?php
	session_start();
	include "inc/sql_connect.php";
	include "inc/server_settings.php";
	include "inc/security.php";
	include "inc/modules_functions.php";
	include "inc/get_item_info.php";
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
		<link  rel="stylesheet" type="text/css" href="CSS/background.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/typography.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/positions.css"></link>
		<link  rel="stylesheet" type="text/css" href="CSS/modules.css"></link>		
    <script type="text/javascript" src="JavaScripts/topLogo.js"></script>
    <script type="text/javascript" src="JavaScripts/Ajax.js"></script>
  </head>
	<body>
		<header>
      <div id="background-logo">
        <div onclick="if(confirm('Are you sure that you want to download ?')){ startLoading(); window.location.assign('?page=Modules_Download')}" id="logo">
          <p>The New World</p>
          <h1>GrizisMu</h1>
          <p>Online</p>
          <p>Click To Download</p>
        </div>
        <div id="loading">
          
        </div>
        <img src="images/bg_elf.png" alt="Logo MuseElf image"/>
        <img src="images/bg_sm.png" alt="Logo SoulMaster image"/>
      </div>
			<nav>
				<a onclick='loadAjexPage("Modules_News","content");'>News</a>
				<a onclick='loadAjexPage("Modules_Register","content");'>Register</a>	
				<a onclick='loadAjexPage("Modules_Download","content");'>Download</a>
				<a onclick='loadAjexPage("Modules_Rankings&subpage=Characters","content");'>Rankings</a>
				<a onclick='loadAjexPage("Modules_Information","content");'>Information</a>	
			</nav>
		</header>
		<section>
      <div id="content">
        <?php include "switch.php"?>
      </div>
      <div id="left_menu">
        <h3 onclick="startLoading();">User Panel</h3>
        <div class="leftSpear"></div>
        <h3 onclick="loadAjexPage(page,place)">Market</h3>
        <div class="leftSpear"></div>
        <h3 onclick="loadAjexPage(page,place)">Auction</h3>
        <div class="leftSpear"></div>
      </div>
      <div id="right_menu">
        <h3 onclick="loadAjexPage(page,place)">Top 10 Chars</h3>
        <div class="rightSpear"></div>
        <h3 onclick="loadAjexPage(page,place)">Top 10 Guilds</h3>
        <div class="rightSpear"></div>
        <h3 onclick="loadAjexPage(page,place)">Winners</h3>
        <div class="rightSpear"></div>
      </div>
		</section>
		<!--footer>
			<p>GrizisMu &#64; All Rights Reserved</p>
		</footer>-->
	</body>
</html>
