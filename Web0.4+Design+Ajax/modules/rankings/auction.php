<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="ranking">
  <thead>
    <tr><th>#</th><th>Acc[Char]</th><th>Bet Zen</th><th>Last Bet</th></tr>
  </thead>
  <tbody>
  <?php
  $i = 0;
  foreach(($grizismudb->query("Select Top 10 * From AuctionBets Order by Zen desc")->fetchAll()) as $account){
    $i++;
    $end_time = get_time(time()-$account['Posted_Date']);
    $character = $grizismudb->query("Select Top 1 Name From Character Where AccountId='".$account['AccountId']."' order by WeekTime desc")->fetchAll();
    $character = $character[0][0];
  ?>	
    <tr>
      <td><?=$i?></td>
      <td><?=$account['AccountId']?>[<a href=\"?page=CharacterInfo&CharacterName=<?=$character?>\"><?=$character?><a/>]</td>
      <td><?=number_format($account['Zen'])?></td>
      <td><?=($end_time['Minutes']+($end_time['Hours']*60))?> Minutes Ago</td>
    </tr>
  <?php
    }
  ?>
  </tbody>
</table>