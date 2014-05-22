<?php
  ob_start();
	session_start();
	include "inc/security.php";
	include "inc/sql_connect.php";
	include "inc/server_settings.php";
	include "inc/modules_functions.php";
	include "inc/get_item_info.php";
	include "inc/auction_item.php";
	include "inc/quest_system.php";
	if(isset($_SESSION['User'])){
		$account = $_SESSION['User'];
	}
	// define('WEB_INDEX', TRUE);
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
		<link  rel="stylesheet" type="text/css" href="CSS/screens.css"></link>		
    <script type="text/javascript" src="JavaScripts/topLogo.js"></script>
    <script type="text/javascript" src="JavaScripts/overlib/overlib.js"></script>
    <script type="text/javascript" src="JavaScripts/Ajax.js"></script>
    <script type="text/javascript" src="JavaScripts/myJS_codes.js"></script>
  </head>
	<body>
    <header>
      <div id="background-logo">
        <div onclick="if(confirm('Are you sure?')){ startLoading(); window.location.assign('?page=Modules_Download')}" id="logo">
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
				<a id="news" onclick="startLoading()" href="/?page=Modules_News">News</a>
				<a onclick="startLoading()" href="/?page=Modules_Register">Register</a>	
				<a onclick="startLoading()" href="/?page=Modules_Download">Download</a>
				<a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Characters">Rankings</a>
				<a onclick="startLoading()" href="/?page=Modules_Information">Information</a>	
			</nav>
		</header>
		<section>
      <div id="content">
        <?php include "inc/switch.php"?>
      </div>
      <div id="left_menu">
        <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Information"><p>User Info</p></a></div>
        <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Panel_Web-Market&subpage=Buy"><p>Market</p></a></div>
        <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Panel_Auction"><p>Auction</p></a></div>
        <div class="leftSpear"></div>
        <div class="leftSpear"></div>
      </div>
      <div id="right_menu">
      <div class="rightSpear">  <a onclick="startLoading()" href="/?page=Modules_Top-Characters"><p>Top 10 Characters</p></a></div>
        <div class="rightSpear"><a onclick="startLoading()" href="/?page=Modules_Top-Guilds"><p>Top 10 Guilds</p></a></div>
        <div class="rightSpear"><a onclick="startLoading()" href="/?page=Modules_Winners"><p>Winners</p></a></div>
        <div class="rightSpear"></div>
        <div class="rightSpear"></div>
      </div>
		</section>
		<!--footer>
			<p>GrizisMu &#64; All Rights Reserved</p>
		</footer>-->
	</body>
</html>
