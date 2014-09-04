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
    <tr><th>#</th><th>Acc[Char]</th><th>Bet Zen</th><th>Last Bet</th></tr>
  </thead>
  <tbody>
  <?php
  $i = 0;
  foreach(($grizismudb->query("Select * From AuctionBets Order by Zen desc OFFSET ".$page_count*$count_per_page." ROWS FETCH NEXT $count_per_page ROWS ONLY")->fetchAll()) as $account){
    $i++;
    $end_time = get_time(time()-$account['Posted_Date']);
    $character = $grizismudb->query("Select Top 1 Name From Character Where AccountId='".$account['AccountId']."' order by Resets desc")->fetchAll();
    $character = $character[0][0];
  ?>	
    <tr>
      <td><?=$i?></td>
      <td><?=$account['AccountId']?>[<a href="?page=Modules_Character-Info&CharacterName=<?=$character?>"><?=$character?><a/>]</td>
      <td><?=number_format($account['Zen'])?></td>
      <td><?=($end_time['Minutes']+($end_time['Hours']*60))?> Minutes Ago</td>
    </tr>
  <?php
    }
  ?>
  </tbody>
</table>
<?php
  if($page_count > 0 ){
?>
<a href="/?page=Modules_User-Panel_Auction&page_count=<?=$page_count-1?>"><< Previous</a>
<?php
  }
?>
<a href="/?page=Modules_User-Panel_Auction&page_count=<?=$page_count+1?>">Next >></a>