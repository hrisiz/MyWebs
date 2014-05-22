<?php
// if (!defined('TEST')) {header("Location: /?page=Modules_News");}
?>
<ul class="hor_nav">
  <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Character"><li>Characters</li></a>
  <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Guilds"><li>Guilds</li></a>
  <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Week_Online_Time"><li>WeekTime</li></a>
  <li>Races
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>DK</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>DW</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>Elf</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>BK</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>SM</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>ME</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race="><li>MG</li></a>
    </ul>
  </li>
  </a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Auction"><li>Auction</li></a>
</ul>
<?php
$page = $_REQUEST['subpage'];
if(!empty($page) && isset($page)){
	$page = strtolower($page);
	$page = "modules/rankings/".$page.".php";
	if (file_exists($page)) {
		include $page;
	}else{
		echo"
			<h1 style=\"text-align:center;\">Error 404 <br>Object not found!</h1>
		";
	}
}
?>