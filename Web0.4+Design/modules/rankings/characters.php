<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
  if(isset($_GET['page_count'])){
    $page_count = $_GET['page_count'];
    if($page_count < 0){
       $page_count = 0;
    }
  }else{
    $page_count = 0;
  }
  $count_per_page = 10;
?>
<table class="ranking">
  <thead>
    <tr><th>#</th><th>Name</th><th>LvL/Res</th><th>Class</th><th>Guild</th><th>Status</th></tr>
  </thead>
  <tbody>
	<?php
		$i = $page_count*$count_per_page;
		$all_races_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
		foreach($grizismudb->query("Select Name,clevel,Resets,Class,AccountId From Character Where CtlCode = 0 OR CtlCode IS NULL order by Resets desc,cLevel desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY") as $char)
		{			
			$char[0] = filter($char[0]);
			if ($guild = $grizismudb->query("Select G_Name From GuildMember Where Name='$char[0]'")->fetchAll())
			{
				$guild = $guild[0][0];
			}
			else
			{
				$guild = "-";
			}
			$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char["AccountId"]."' AND ConnectStat = 1")->fetchAll());
			$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
			$status = "<span class='error'>Offline</span>";
			if ($status >= 1 && $char_in_game >= 1)
			{
				$status = "<span class='success'>Online</span>";
			}			
      $i++;
			echo"<tr><td>$i</td><td onclick='loadAjaxPage(\"Modules_Character-Info&CharacterName=$char[0]\",\"content\")'>$char[0]</a></td><td>$char[1]/$char[2]</td><td>".$all_races_name[$char['Class']]."</td><td onclick='loadAjaxPage(\"Modules_Guild-Info&GuildName=CreativE\",\"content\")'>$guild</td><td>$status</td></tr>";
		}
	?>
</tbody>
</table>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_Ranking&subpage=Characters&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_Ranking&subpage=Characters&page_count=<?=$page_count+1?>">Next >></a>