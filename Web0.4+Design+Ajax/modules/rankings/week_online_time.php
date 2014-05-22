<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="ranking">
  <thead>
    <tr><th>#</th><th>Name</th><th>Online Time</th></tr>
  </thead>
  <tbody>
    <?php
    $i = 0;
    foreach(($grizismudb->query("Select Top 50 * From Character Order by WeekTime desc")->fetchAll()) as $account){
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