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
    <script type="text/javascript">
      window.onpopstate= function(){ 
        load_page=(document.URL).split("?page=")[1];
        loadAjaxPage(load_page,"content");
      }
    </script>
  </head>
	<body>
    <h1 id="check_JS">Your JavaScript is disabled and our website can't work without it.Please enable JavaScript from your browser settings.<br>Skype:grizismu</h1>
		<script>
      document.getElementById('check_JS').innerHTML="";
    </script>
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
				<a onclick='loadAjaxPage("Modules_News","content");'>News</a>
				<a onclick='loadAjaxPage("Modules_Register","content");'>Register</a>	
				<a onclick='loadAjaxPage("Modules_Download","content");'>Download</a>
				<a onclick='loadAjaxPage("Modules_Ranking&subpage=Characters","content");'>Rankings</a>
				<a onclick='loadAjaxPage("Modules_Information","content");'>Information</a>	
			</nav>
		</header>
		<section>
      <div id="content">
        <?php include "inc/switch.php"?>
      </div>
      <div id="left_menu">
        <div onclick='loadAjaxPage("Modules_User-Information","content");' class="leftSpear"><p>User Info</p></div>
        <div onclick='loadAjaxPage("Modules_User-Panel_Web-Market&subpage=Buy","content")' class="leftSpear"><p>Market</p></div>
        <div onclick='loadAjaxPage("Modules_User-Panel_Auction","content");' class="leftSpear"><p>Auction</p></div>
        <div id="emptyleftSpears">
          <div class="leftSpear"></div>
          <div class="leftSpear"></div>
        </div>
      </div>
      <div id="right_menu">
        <div onclick='loadAjaxPage("Modules_Top-Characters","content");' class="rightSpear"><p>Top 10 Characters</p></div>
        <div onclick='loadAjaxPage("Modules_Top-Guilds","content");' class="rightSpear"><p>Top 10 Guilds</p></div>
        <div onclick='loadAjaxPage("Modules_Winners","content");' class="rightSpear"><p>Winners</p></div>
        <div id="emptyrightSpears">
          <div class="rightSpear"><p>xaxa</p></div>
          <div class="rightSpear"></div>
        </div>
      </div>
		</section>
		<!--footer>
			<p>GrizisMu &#64; All Rights Reserved</p>
		</footer>-->
	</body>
</html>
