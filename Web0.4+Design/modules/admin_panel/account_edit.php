<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
	$acc = $_GET['Account'];
  
	$acc_info = $grizismudb->query("Select * From MEMB_INFO Where memb___id='$acc'")->fetchAll();
  if(count($acc_info)<= 0){
    echo "<p class=\"error\">Wrong account name</p>";
    return "";
  }
	$acc_info = $acc_info[0];
  $character = $grizismudb->query("Select GameID1,GameID2,GameID3,GameID4,GameID5 From AccountCharacter Where Id='$acc'")->fetchAll();
  if(empty($character)){
    $character = array_fill(0,5,"Empty");
  }else{
    $character = $character[0];
    for($i=0;$i < 5;$i++){
      if(empty($character[$i])){
        $character[$i] = "Empty";
      }
    }
  }
	$renas = $grizismudb->query("Select * From Renas Where AccountID='$acc'")->fetchAll();
	$renas = $renas[0];
  if(empty($renas['Renas'])){
    $renas['Renas'] = 0;
  }
	$stones = $grizismudb->query("Select * From Stones Where AccountID='$acc'")->fetchAll();
	$stones = $stones[0];
  if(empty($stones['Stones'])){
    $stones['Stones'] = 0;
  }
	$zen = $grizismudb->query("Select * From Bank Where AccountID='$acc'")->fetchAll();
	$zen = $zen[0];
  if(empty($zen['Bank'])){
    $zen['Bank'] = 0;
  }
?>
<div id="success_edit"></div>
<div id="character_info">
  <table>
    <thead>
      <tr><th>Character</th><th>Ban</th></tr>
    </thead>
    <tbody>
      <?php 
      for($i=0;$i<5;$i++){
      ?>
      <tr><td><?=$character[$i]?></td><td><?php if($character[$i] != "Empty"){ ?><a href=""><button>Ban</button></a><?php }else{ ?><?php } ?></td></tr>
      <?php 
      }?>
    </tbody>
  </table>
  <dl>
    <dt onclick="make_to_button(this,'Modules_Admin-Panel_Edit-Acc')">Account</dt>
      <dd><?=$acc_info['memb___id']?></dd>
    <dt onclick="make_to_button(this,'Modules_Admin-Panel_Edit-Acc')">Password</dt>
      <dd>**********</dd>
    <dt onclick="make_to_button(this,'Modules_Admin-Panel_Edit-Acc')">Stones</dt>
      <dd><?=$stones['Stones']?></dd>
    <dt onclick="make_to_button(this,'Modules_Admin-Panel_Edit-Acc')">Renas</dt>
      <dd><?=$renas['Renas'] ?></dd>
    <dt onclick="make_to_button(this,'Modules_Admin-Panel_Edit-Acc')">Zen</dt>
      <dd><?=$zen['Bank'] ?></dd> 
  </dl>
</div>