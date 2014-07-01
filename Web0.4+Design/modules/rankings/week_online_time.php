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
    <tr><th>#</th><th>Name</th><th>Online Time</th></tr>
  </thead>
  <tbody>
    <?php
    $i = 0;
    foreach(($grizismudb->query("Select * From Character Order by WeekTime desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY")->fetchAll()) as $account){
      $i++;
      $min = $account['WeekOnlineTime']; 
      $chas = floor($min/60); 
      $days = floor($chas/24); 
      $chas = $chas % 24; 
      $min = $account['WeekOnlineTime'] % 60;
      echo"<tr><td>$i</td><td><a href=\"?page=CharacterInfo&CharacterName=".$account['Name']."\">".$account['Name']."<a/></td>";
      if($days > 0 && $chas >0){
        echo"<td>$days Days $chas Hours</td>";
      }else{
        echo"<td>$min Minutes</td>";
      }
      echo"</tr>";
    }
    ?>
  </tbody>
</table>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_Ranking&subpage=Week_Online_Time&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_Ranking&subpage=Week_Online_Time&page_count=<?=$page_count+1?>">Next >></a>