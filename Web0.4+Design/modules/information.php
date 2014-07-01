<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<ul class="hor_nav">
  <a href="/?page=Modules_Information&subpage=Server"><li>Server</li></a>
  <a href="/?page=Modules_Information&subpage=Statistics"><li>Statistics</li></a>
  <li>Monsters
    <ul class="ver_nav">
      <a href="/?page=Modules_Information&subpage=Monsters&city=Lorencia"><li>Lorencia</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Davias"><li>Davias</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Stadium"><li>Stadium</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Noria"><li>Noria</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Icarus"><li>Icarus</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Atlans"><li>Atlans</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Tarkan"><li>Tarkan</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=LostTower"><li>LostTower</li></a>
      <a href="/?page=Modules_Information&subpage=Monsters&city=Exile"><li>Exile</li></a>
    </ul>
  </li>
  <li>Drop
    <ul class="ver_nav">
      <a href="/?page=Modules_Information&subpage=Drop&Box=1"><li>Box +1</li></a>
      <a href="/?page=Modules_Information&subpage=Drop&Box=2"><li>Box +2</li></a>
      <a href="/?page=Modules_Information&subpage=Drop&Box=3"><li>Box +3</li></a>
      <a href="/?page=Modules_Information&subpage=Drop&Box=4"><li>Box +4</li></a>
      <a href="/?page=Modules_Information&subpage=Drop&Box=5"><li>Box +5</li></a>
    </ul>
  </li>
  <a href="/?page=Modules_Information&subpage=Rules"><li>Rules</li></a>
  <a href="/?page=Modules_Information&subpage=Contacts"><li onclick='loadAjaxPage(","content")'>Contacts</li></a>
</ul>
<?php
if(isset($_GET['subpage'])){
  $page = $_GET['subpage'];
}elseif(isset($_POST['subpage'])){
  $page = $_POST['subpage'];
}
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