<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo $option['title']; ?></title>
	<link rel="stylesheet" href="themes/dark/css/style.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript" src="js/easyTooltip.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){	
			$("[title]").easyTooltip();
		});
	</script>
</head>
<body>
	<div id="main_body">
		<header>
			<div class="logo">
				<img src="themes/dark/imgs/logo.jpg" alt="Logo" />
			</div>
			<nav>
				<?php include 'inc/menu.php'; ?>
			</nav>
		</header>
		<div id="container">
			<div class="clearfix">
				<div class="right col_1">
					<?php
						require 'inc/loader.php';
					?>
				</div>
				<div class="left col_2">
					<div class="box">
						<div class="boxTitle">USER PANEL</div>
						<div class="boxBody">
							<?php include 'inc/user_panel.php'; ?>
						</div>
					</div>
					<div class="box">
						<div class="boxTitle">RANKINGS</div>
						<div class="boxBody">
							<?php include 'inc/ranks.php'; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<p>Copyrights &copy; MeMoS</p>
		</footer>
	</div>
</body>
</html>