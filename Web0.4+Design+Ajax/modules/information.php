<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<ul class="hor_nav">
  <li onclick='loadAjaxPage("Modules_Information&subpage=Server","content")'>Server</li>
  <li onclick='loadAjaxPage("Modules_Information&subpage=Statistics","content")'>Statistics</li>
  <li>Monsters
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Lorencia","content")'>Lorencia</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Davias","content")'>Davias</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Stadium","content")'>Stadium</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Noria","content")'>Noria</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Icarus","content")'>Icarus</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Icarus","content")'>Atlans</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Tarkan","content")'>Tarkan</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=LostTower","content")'>LostTower</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&city=Exile","content")'>Exile</li>
    </ul>
  </li>
  <li>Drop
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&Box=1","content")'>Box +1</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&Box=2","content")'>Box +2</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&Box=3","content")'>Box +3</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&Box=4","content")'>Box +4</li>
      <li onclick='loadAjaxPage("Modules_Information&subpage=Drop&Box=5","content")'>Box +5</li>
    </ul>
  </li>
  <li onclick='loadAjaxPage("Modules_Information&subpage=Quests","content")'>Quests</li>
  <li onclick='loadAjaxPage("Modules_Information&subpage=Rules","content")'>Rules</li>
  <li onclick='loadAjaxPage("Modules_Information&subpage=Contacts","content")'>Contacts</li>
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