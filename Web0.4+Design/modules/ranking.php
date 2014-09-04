<?php
// if (!defined('TEST')) {header("Location: /?page=Modules_News");}
?>
<ul class="hor_nav">
  <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Characters&amp;page_count=0"><li>Characters</li></a>
  <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Guilds&amp;page_count=0"><li>Guilds</li></a>
  <li>Races
    <ul class="ver_nav">
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=16&amp;page_count=0"><li>DK</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=0&amp;page_count=0"><li>DW</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=32&amp;page_count=0"><li>Elf</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=17&amp;page_count=0"><li>BK</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=1&amp;page_count=0"><li>SM</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=33&amp;page_count=0"><li>ME</li></a>
      <a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Races&race=48&amp;page_count=0"><li>MG</li></a>
    </ul>
  </li>
  <!--</a onclick="startLoading()" href="/?page=Modules_Ranking&subpage=Auction"><li>Auction</li></a>-->
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