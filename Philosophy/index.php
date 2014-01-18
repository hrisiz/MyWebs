<?php
	session_start();
	include_once "include_php/security.php";
	include_once "config.php";
?>
<!DOCTYPE HTML>
<html>
		<head>
			<link rel="stylesheet" type="text/css" href="css.css"/>
			<title>Questions</title>
			<script type="text/JavaScript" src="js/jquery 1.9.0.js"></script> 
			<script type="text/JavaScript" src="js/overlib/overlib.js"></script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta charset=utf-8/>
			<script type="text/JavaScript">
				function redirect(url)
				{
					setTimeout(function(){window.location = url},1000);
				}
			</script>
		</head>
		<body>
			<header>
				<img src="images/header.png" alt="header_picture" id="header_image"/>
				<div id="top_menu">
					<a href="?value=home"><img src="images/Home.png" class="top_menu"/></a>
					<a href="?value=Register"><img src="images/Register.png" class="top_menu"/></a>
					<a href="?value=Rankings"><img src="images/Rankings.png" class="top_menu"/></a>
				</div>
			</header>
			<section>
			<?php
				if (isset($_SESSION['user']))
				{
					$account = $_SESSION['user'];
				}
				else
				{
					$account = "";
				}
				if (!isset($_SESSION['user']))
				{
					switch ($_GET['value'])
					{
						case "Register":
							include_once "modules/register.php";
							break;
						case "Rankings":
							include_once "modules/rankings.php";
							break;
						default:
							include_once "modules/login.php";
					};
				}
				elseif($_GET['value'] == "LogOut")
				{
					include_once "modules/logout.php";
				}
				else
				{
					switch ($_GET['value'])
					{
						case "Register":
							include_once "modules/register.php";
							break;
						case "Rankings":
							include_once "modules/Rankings.php";
							break;
						//case "MyQuestions":
							//include_once "modules/my_questions.php";
							//break;
						case "EditQuestion":
							include_once "modules/edit_question.php";
							break;
						case "AddQuestion":
							include_once "modules/add_question.php";
							break;
						case "Test":
							include_once "modules/questions.php";
							break;
						case "END":
							include_once "modules/end.php";
							break;
						default:
							include_once "modules/home.php";
					};
				}
			?>
			</section>
			<footer>
				<p>Created by GrizisMu</p>
			</footer>
		</body>
</html>