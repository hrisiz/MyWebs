<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<ul id="information_menu">
	<li><a href="?page=Modules_Information&subpage=Server">Server</a></li>
	<li><a>Monsters</a>
		<ul class="information">
			<?php
				for ($i = 0; $i < count($server['Citys']); $i++)
				{
					echo"<li><a href=\"?page=Modules_Information&subpage=Monsters&city=".$server['Citys'][$i]."\">".$server['Citys'][$i]."</a></li>";
				}
			?>
		</ul>
	</li>
	<li><a href="?page=Modules_Information&subpage=Quests">Quests</a></li>
	<li><a>Drop</a>
		<ul>
			<li><a href="?page=Modules_Information&subpage=Drop&Box=1">Box +1</a></li>
			<li><a href="?page=Modules_Information&subpage=Drop&Box=2">Box +2</a></li></a>
			<li><a href="?page=Modules_Information&subpage=Drop&Box=3">Box +3</a></li></a>
			<li><a href="?page=Modules_Information&subpage=Drop&Box=4">Box +4</a></li></a>
			<li><a href="?page=Modules_Information&subpage=Drop&Box=5">Box +5</a></li></a>
		</ul>
	</li>
	<li><a href="?page=Modules_Information&subpage=Statistics">Statistics</a></li>
	<li><a href="?page=Modules_Information&subpage=Rules">Rules</a></li>
	<li><a href="?page=Modules_Information&subpage=Contacts">Constacts</a></li>
</ul>
<?php
$page = $_GET['subpage'];
if(!empty($page) && isset($page)){
	$page = strtolower($page);
	$page = "modules/information/".$page.".php";
	if (file_exists($page)) {
		include $page;
	}else{
		echo"
			<h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
		";
	}
}
?>