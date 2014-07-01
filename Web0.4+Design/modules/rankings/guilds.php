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
    <tr><th>#</th><th>Name</th><th>GuildMaster</th><th>Resets</th></tr>
  </thead>
  <tbody>
	<?php
    $i =$page_count*$count_per_page;
    foreach($grizismudb->query("Select Guild.G_Name,SUM(Character.Resets),Guild.G_Master From Guild,GuildMember,Character Where Guild.G_Name = GuildMember.G_Name AND Character.Name = GuildMember.Name GROUP BY Guild.G_Name,Guild.G_Master order by SUM(Character.Resets) desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY") as $guild_info) {
      $i++;
      echo"<tr><td>$i</td><td><a href=\"?page=Modules_Guild-Info&GuildName=$guild_info[0]\">$guild_info[0]</a></td><td>".$guild_info['G_Master']."</td><td>$guild_info[1]</td></tr>";
    }
	?>
  </tbody>
</table>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_Ranking&subpage=Guilds&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_Ranking&subpage=Guilds&page_count=<?=$page_count+1?>">Next >></a>