<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<a href="?page=Modules_Information&subpage=Server"><button>Server</button></a>
<a href="?page=Modules_Information&subpage=Monsters"><button>Monsters</button></a>
<a href="?page=Modules_Information&subpage=Quests"><button>Quests</button></a>
<a href="?page=Modules_Information&subpage=Drop"><button>Drop</button></a>
<a href="?page=Modules_Information&subpage=Statistics"><button>Statistics</button></a>
<a href="?page=Modules_Information&subpage=Rules"><button>Rules</button></a>
<a href="?page=Modules_Information&subpage=Contacts"><button>Constacts</button></a>
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