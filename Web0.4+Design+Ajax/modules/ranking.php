<?php
// if (!defined('TEST')) {header("Location: /?page=Modules_News");}
?>
<ul class="hor_nav">
  <li onclick='loadAjaxPage("Modules_Ranking&subpage=Character","content")'>Characters</li>
  <li onclick='loadAjaxPage("Modules_Ranking&subpage=Guilds","content")'>Guilds</li>
  <li onclick='loadAjaxPage("Modules_Ranking&subpage=Week_Online_Time","content")'>WeekTime</li>
  <li>Races
    <ul class="ver_nav">
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>DK</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>DW</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>Elf</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>BK</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>SM</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>ME</li>
      <li onclick='loadAjaxPage("Modules_Ranking&subpage=Races&race=","content")'>MG</li>
    </ul>
  </li>
  <li onclick='loadAjaxPage("Modules_Ranking&subpage=Auction","content")'>Auction</li>
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