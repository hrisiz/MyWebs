<?php
  $acc = $_REQUEST['acc'];
  $value_type = $_REQUEST['valueType'];
  $new_value = $_REQUEST['newValue'];
  //echo "<p>$acc,$value_type,$new_value</p>";
  switch($value_type){
    case "Account":
      echo"<p class=\"error\">Not available.</p>";
      break;
    case "Passowrd":
      echo"<p class=\"error\">Not available.</p>";
      break;
    case "Stones":
      if(count($grizismudb->query("Select * From Stones Where AccountId='$acc'")->fetchAll()) <= 0){
        $grizismudb->exec("Insert Into Stones values('$acc',$new_value)");
      }else{
        $grizismudb->exec("Update Stones Set Stones=Stones+$new_value Where AccountId='$acc'");
      }
      break;
    case "Renas":
      if(count($grizismudb->query("Select * From Renas Where AccountId='$acc'")->fetchAll()) <= 0){
        $grizismudb->exec("Insert Into Renas values('$acc',$new_value)");
      }else{
        $grizismudb->exec("Update Renas Set Renas=Renas+$new_value Where AccountId='$acc'");
      }
      break;
    case "Zen":
      if(count($grizismudb->query("Select * From Bank Where AccountId='$acc'")->fetchAll()) <= 0){
        $grizismudb->exec("Insert Into Bank values('$acc',$new_value)");
      }else{
        $grizismudb->exec("Update Bank Set Bank=Bank+$new_value Where AccountId='$acc'");
      }
      break;
    default:
      echo"<p class=\"error\">Wrong choose</p>";
  }
?>