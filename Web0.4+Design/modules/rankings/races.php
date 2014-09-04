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
if(isset($_REQUEST['race'])){
	$all_races = Array(0,1,16,17,32,33,48);
	$race = !empty($_GET['race']) ? $_GET['race']:$all_races[array_rand($all_races)];
  if(!in_array($race,$all_races))
		$race = !empty($_GET['race']) ? $_GET['race']:$all_races[array_rand($all_races)];
	echo"<table class=\"ranking\">
  <thead>
    <tr><th>ID</th><th>Name</th><th>LvL/Res</th><th>Class</th><th>Guild</th><th>Status</th></tr>
  </thead>
  <tbody>
  ";
	if(in_array($race ,$all_races)){
		
		$chars = $grizismudb->query("Select  * From Character Where Class=$race order by Resets desc,cLevel desc,Name OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY")->fetchAll();
		$i = 1;
		$all_races_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
		foreach($chars as $char){
			$guild = $grizismudb->query("Select G_Name From GuildMember Where Name='".$char['Name']."'")->fetchAll();
			$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char["Name"]."' AND ConnectStat = 1")->fetchAll());
			$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
			$status = "<span class='error'>Offline</span>";
			if ($status >= 1 && $char_in_game >= 1)
			{
				$status = "<span class='success'>Online</span>";
			}
			echo"<tr><td>$i</td><td><a href=\"?page=CharacterInfo&CharacterName=".$char['Name']."\">".$char['Name']."</a></td><td>".$char['cLevel']."/".$char['Resets']."</td><td>".$all_races_name[$char['Class']]."</td><td>".$guild[0]['G_Name']."</td><td>$status</td></tr>";
			$i++;
		}
	}
	echo"
  </tbody>
  </table>";
}
?>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_Ranking&subpage=Races&race=<?=$_GET['race']?>&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_Ranking&subpage=Races&race=<?=$_GET['race']?>&page_count=<?=$page_count+1?>">Next >></a>