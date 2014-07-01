<?php
  ob_start();
	session_start();
	// include "inc/security.php";
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
		<link  rel="stylesheet" type="text/css" href="CSS/style.css"/>
		<link  rel="stylesheet" type="text/css" href="CSS/typography.css"/>
		<link  rel="stylesheet" type="text/css" href="CSS/positions.css"/>
		<link  rel="stylesheet" type="text/css" href="CSS/modules.css"/>		
		<link  rel="stylesheet" type="text/css" href="CSS/screens.css"/>
    <script type="text/javascript" src="JavaScripts/topLogo.js"></script>
    <script type="text/javascript" src="JavaScripts/overlib/overlib.js"></script>
    <script type="text/javascript" src="JavaScripts/Ajax.js"></script>
    <script type="text/javascript" src="JavaScripts/myJS_codes.js"></script>
    <script type="text/javascript" src="JavaScripts/Timer.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  </head>
	<body onload='startLogo("<p>The New World</p><h1>GrizisMu</h1><p>Online</p><p>Welcome to GrizisMu</p>","black,grey,black")'>
    <div class="body">
      <header>
        <nav>
          <a id="news" onclick="startLoading()" href="/?page=Modules_News">News</a>
          <a onclick="startLoading()" href="/?page=Modules_Register">Register</a>	
          <a onclick="startLoading()" href="/?page=Modules_Download">Download</a>
          <a onclick="startLoading()" href="/?page=Modules_Ranking&amp;subpage=Characters&amp;page_count=0">Rankings</a>
          <a onclick="startLoading()" href="/?page=Modules_Information&amp;subpage=Server">Information</a>	
        </nav>
        <div id="background-logo">
          <img src="images/bg_elf.png" alt="Logo MuseElf image"/>
          <div id="loading">
            <p>The New World</p>
            <h1>GrizisMu</h1>
            <p>Online</p>
            <p>Welcome to GrizisMu</p>
          </div>
          <img src="images/bg_sm.png" alt="Logo SoulMaster image"/>
        </div>
      </header>
      <section>
        <div id="left_menu">
          <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Information"><p>User Info</p></a></div>
          <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Panel_Web-Market&amp;subpage=Buy"><p>Market</p></a></div>
          <div class="leftSpear"><a onclick="startLoading()" href="/?page=Modules_User-Panel_Auction"><p>Auction</p></a></div>
          <div class="leftSpear"></div>
          <div class="leftSpear"></div>
        </div>
        <div id="content">
          <?php include "inc/switch.php"?>
        </div>
        <div id="right_menu">
          <div class="rightSpear"><a onclick="startLoading()" href="/?page=Modules_Top-Characters"><p>Top 10 Characters</p></a></div>
          <div class="rightSpear"><a onclick="startLoading()" href="/?page=Modules_Top-Guilds"><p>Top 10 Guilds</p></a></div>
          <div class="rightSpear"><a onclick="startLoading()" href="/?page=Modules_Information&amp;subpage=Statistics"><p>Statistics</p></a></div>
          <div class="rightSpear"></div>
          <div class="rightSpear"></div>
        </div>
      </section>
      <footer>
        <p>GrizisMu &copy; All Rights Reserved</p>
      </footer>
    </div>
	</body>
</html>
