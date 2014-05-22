<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="ranking" id="TopCharacters">
  <thead>
    <tr><th>Name</th><th>Level/Res</th></tr>
  </thead>
  <tbody>
    <?php
    foreach($grizismudb->query('Select Top 10 Name,cLevel,Resets From Character where CtlCode=0 OR CtlCode IS NULL order by Resets desc,cLevel desc') as $char_info) {
      echo"<tr><td><a href=\"?page=Modules_Character-Info&CharacterName=$char_info[0]\">$char_info[0]</a></td><td>$char_info[1]/<span id='resets'>$char_info[2]</span></td></tr>";
    }
    ?>
  </tbody>
</table>