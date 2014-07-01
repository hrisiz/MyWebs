<?php
  $all_news = $grizismudb->query("Select Top 5 * From News order by LastUpdate desc");
   $i = 0;
?>
<div id="accordion" >
<?php
  foreach($all_news as $news){
  $i++;
?>
<h3><?=$news['Title']?></h3>
<div>
  <pre>
    <?=$news['News']?>
  </pre>
  <p class="POSTED">Posted By:<?=$news['PostedBy']?></p>
  <p>Last Update: <?= date("H:i d/m/Y",$news['LastUpdate'])?></p>
</div>
<?php
  }
?>
</div>
<script>
$("#accordion").accordion();
</script>