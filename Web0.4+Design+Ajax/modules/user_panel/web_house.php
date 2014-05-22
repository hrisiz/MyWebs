<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo"You should be logged in for this page.";
  exit;
}
if(isset($_POST['GetItem'])){
  $item_id = $_POST['item_id'];
  $item = $grizismudb->query("Select * From Web_House Where ID=$item_id")->fetchAll();
  if(count($item) <= 0){
    echo"<p class=\"error\">Invalide request.</p>";
  }elseif(trim($item[0]['AccountId']) != trim($account)){
    echo"<p class=\"error\">This is not your item.</p>";
  }elseif(count($grizismudb->query("Select * From MEMB_STAT Where memb___id='$account' AND ConnectStat=1")->fetchAll())>0){
    echo"<p class=\"error\">You must be offline to use this option.</p>";
  }else{
    $grizismudb->beginTransaction();
    if(add_item($item[0]['Item'])){
      $grizismudb->query("Delete From Web_House Where ID=$item_id");
      $grizismudb->commit();
      echo"<p>Successfully added</p>";
    }else{
      $grizismudb->rollBack();
      echo"<p class=\"error\">Unknown problem. Please contact with admins.</p>";
    }
  }
}
?>
<table id="market_buy">
  <thead>
     <tr><th>Add</th><th>Item</th><th>Get</th></tr>
  </thead>
  <tbody>
  <?php 
  foreach($grizismudb->query("Select * From Web_House Where AccountId='$account'")->fetchAll() as $item){
    if(empty($item['From'])){
      $item['From'] = "Unknown";
    }
    $item_info = get_item_info($item['Item']);
		$item_options = "";
		foreach($item_info['excellent_options'] as $item_option){
			$item_options .= "<br>".$item_option;
		}
		$onmouseover = "<div class=show_item_info><p class=".$item_info['name_color'].">".$item_info['name']." +".$item_info['level']."</p><p>".$item_info['dur']." Durability</p><p class=show_item_excellent_options>".$item_info['skill']."".$item_info['luck']."".$item_options."</p></div>";
  ?>
  <tr>
    <td>
      From:<?=$item['From']?><br>
      On: <?=date("d.m.Y",$item['Date'])?><br>
      At: <?=date("h:i:s",$item['Date'])?></td>
    </td>
    <td onmouseover="return overlib('<?=$onmouseover?>');" onmouseout="return nd()">
      <img src="images/items/<?=$item_info['image']?>"/>
    </td>
    <td>
      <form method="POST">
						<input type="hidden" value="<?=$item['ID']?>" name="item_id"/>
						<input onclick="startLoading()" type="submit" name="GetItem" value="Get Item"/>
					</form>
    </td>
  </tr>
  <?php } ?>
  </tbody>
</table>