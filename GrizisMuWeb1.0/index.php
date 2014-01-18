<?php
	session_start();
	include ("include_php/sql_connect.php");
	include "include_php/security.php";
	include "include_php/security_functions.php";
	include "include_php/server_settings.php";
	include "include_php/web_settings.php";
	include_once "include_php/modules_functions.php";
	include_once "include_php/server_functions.php";
	include_once "include_php/get_item_info.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<script language="JavaScript">
			//document.onkeydown = function (event) {
			//	event = (event || window.event);
			//	if (event.keyCode == 123 || event.keyCode == 116) {
			//		return false;
			//	}
			//}
			//document.oncontextmenu = function (event) {
			//	return false;
			//}
			var images=new Array("images/header.png","images/reklama.gif");
			i=0;
			window.setInterval(function(){image(-1);},15500);
			function image(index){
				if (index > -1 && index > 0 && index < images.lenght){
					i = index;
				}
				else if(index == -2){
					i++;
				}
				else if(index == -3){
					i--;
					if(i < 0){
						i = images.length-1;
					}
				}
				else{
					i++;
				}
				if (i >= images.length ){
					i = 0;
				}
				document.getElementById("slider").src=images[i];
			}
		</script>
		<title><?=$server['Name']?></title>
		<link rel="stylesheet" type="text/css" href="css/ids.css"/>
		<link rel="stylesheet" type="text/css" href="css/classes.css"/>
		<link rel="stylesheet" type="text/css" href="css/tags.css"/>
		<script type="text/JavaScript" src="JavaScripts/overlib/overlib.js"></script>
		<script type="text/JavaScript">
			//setTimeout(window.history.pushState('MuNewWeb/', 'Title', '/MuNewWeb/'), 5000);
			function redirect(url)
			{
				window.location = url;
			}
		</script>
	</head>
	<body>
	<header>		
			<img id="slider" src="images/header.png" alt="header" width="995px" height="200px"/>
			<div id="Header_MENU">
				<a href="?page=News"><p class = "top_menu_elements" id="Home_menu"><img class = "top_menu_elements" src="images/Home.png"/></p></a>
				<a href="?page=Register"><p class = "top_menu_elements" id="Register_menu"><img class = "top_menu_elements" src="images/Register.png"/></p></a>
				<a href="?page=Download"><p class = "top_menu_elements" id="Download_menu"><img class = "top_menu_elements" src="images/Download.png"/></p></a>
				<a href="?page=Rankings"><p class = "top_menu_elements" id="Rankings_menu"><img class = "top_menu_elements" src="images/Rankings.png"/></p></a>
				<a href="?page=Information"><p class = "top_menu_elements" id="Information_menu"><img class = "top_menu_elements" src="images/Information.png"/></p></a>
			</div>

		</header>
		<section>
		
			<div id="Left_Menu">
		
				<div id="UserPanel_BIG">
					<img src="images/Top_User.png" alt="Top of content" width="350px"/>
					<div id="UserPanel">
					<?php 
					if(!isset($_SESSION['LoggedUser']))
					{
						$account= NULL;
					echo"
						<form action=\"?page=Register&subpage=Login\" method=\"POST\">
							<label for=\"User\">UserName:</label>
							<input id=\"User\" name=\"User\" type=\"text\" size=\"11\" maxlength=\"10\"/><br>
							<label for=\"User\">Password:</label>
							<input id=\"Password\" name=\"Password\" type=\"password\" size=\"11\" maxlength=\"10\"/><br>
							<input name=\"login\" type=\"submit\" value=\"LogIn\"/>
						</form>";
					}else{
						$account = $_SESSION['LoggedUser'];
						$user['Stones'] = $grizismudb->query("Select Stones From Stones Where AccountId='".$_SESSION['LoggedUser']."'")->fetchAll();
						$user['Stones'] = $user['Stones'][0][0];
						if (empty($user['Stones'])){$user['Stones'] = 0;}
						$user['Renas'] = $grizismudb->query("Select Renas From Renas Where AccountId='".$_SESSION['LoggedUser']."'")->fetchAll();
						$user['Renas'] = $user['Renas'][0][0];
						if (empty($user['Renas'])){$user['Renas'] = 0;}
						$user['BankZen'] = $grizismudb->query("Select Bank From Bank Where AccountId='".$_SESSION['LoggedUser']."'")->fetchAll();
						$user['BankZen'] = $user['BankZen'][0][0];
						if (empty($user['BankZen'])){$user['BankZen'] = 0;}
						echo"<p class=\"logged_panel\">Welcome ".$_SESSION['LoggedUser']."</p>
						<p id=\"Stones\" class=\"logged_panel\">Stones:".$user['Stones']."</p>
						<p id=\"Renas\" class=\"logged_panel\">Renas:".$user['Renas']."</p>
						<p id=\"BankZen\" class=\"logged_panel\">Bank Zen:".number_format($user['BankZen'])."</p>
						<a href=\"?page=UserPanel\"><button>ControlPanel</button></a>
						<a href=\"?page=UserPanel&subpage=LogOut\"><button>LogOut</button></a>";
					}?>
					</div>
					<img class="bottom_image" src="images/User_Bot.png" alt="Top of content" width="350px"/>
				</div>
				
				<div id="TopCharacters_BIG">
					<img src="images/Top10C_Top.png" alt="Top of content" width="400px"/>
					<div id="TopCharacters">
						<?php
							include "top_chars.php";
						?>
					</div>
					<img class="bottom_image" src="images/Top10C_bot.png" alt="Top of content" width="400px"/>
				</div>
				
				
			</div>
			
			<div id="Right_Menu">
			
				<div id="RightMenu_BIG">
					<img src="images/menu_Top.png" alt="Top of content" width="300px"/>
					<div id="RightMenu">
						<?php
							include "right_menu.php";
						?>
					</div>
					<img class="bottom_image" src="images/menu_Bot.png" alt="Top of content" width="301px"/>
				</div>
				
				
				<div id="Information_BIG">
					<img src="images/Info_top.png" alt="Top of content" width="400px"/>
					<div id="Information">
						<?php
							include "info.php";
						?>
					</div>
					<img class="bottom_image" src="images/Info_Bot.png" alt="Top of content" width="401px"/>
				</div>
				
				
			</div>
			
			<div id="Content_Big">
				<img src="images/Content_Top.png" alt="Top of content" width="498px"/>
				<div id="Content">
					<?php
						include "switch.php";
					?>
				</div>
				<img id="Bottom_Content_image" src="images/Content_Bot.png" alt="Top of content" width="498px"/>
				<p> GrizisMu &copy; All Rights Reserved</p>
			</div>
			
		</section>
</html>
<?php
$grizismudb = NULL;
?>