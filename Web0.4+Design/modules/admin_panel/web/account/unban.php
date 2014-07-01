<?php
  
  $acc_info = $grizismudb->query("Select * From MEMB_INFO Where memb_guid=".$_GET['accid']."")->fetchAll();
  if(count($acc_info) > 0){
    $acc_info = $acc_info[0];
  }else{
    echo"<p class=\"error\">Wrong Account ID.</p>";
    return "";
  }
  $grizismudb->exec("Update MEMB_INFo Set bloc_code=0 Where memb_guid=".$_GET['accid']."");
  $grizismudb->exec("Update Character Set CtlCode=0 Where AccountId='".$acc_info['memb___id']."'");
  sleep(1);
  header("Location: /?page=Modules_Admin-Panel_Web_Account");
?>