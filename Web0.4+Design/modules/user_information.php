<?php
// // // // // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(isset($_POST['login'])){
	$user = $_POST['user'];
	$check_acc = $grizismudb->query("Select * From MEMB_INFO Where memb___id='$user' AND memb__pwd='".$_POST['password']."'")->fetchAll();
	if(count($check_acc) <= 0){
		echo"<p class=\"error\">Wrong user or password</p>";
	}else{
		$_SESSION['User']=$user;
		$account = $_SESSION['User'];
	}
  header("Location: ?page=Modules_User-Information"); 
}
if(!isset($_SESSION['User'])){
?>
<form method="POST" action="?page=Modules_User-Information">
  <label for="user">UserName</label>
  <input type="text" name="user" id="user"/><br>
  <label for="password">Password</label>
  <input type="password" name="password" id="password"/><br>
  <input onclick="startLoading();" type="Submit" name="login" value="LogIn"/>
</form>
<?php
}else{
  $user['Online_Time'] = "2 Days 10 Hours"; 
  $stones = $grizismudb->query("Select Stones From Stones Where AccountId='$account'")->fetchAll();
  $user['Stones'] = $stones[0][0];
  $renas = $grizismudb->query("Select Renas From Renas Where AccountId='$account'")->fetchAll();
  $user['Renas'] = $renas[0][0];
  $bank_zen = $grizismudb->query("Select Bank From Bank Where AccountId='$account'")->fetchAll();
  $user['Bank_Zen'] = $bank_zen[0][0];
?>
  <p>Welcome <?=$account?></p> 
	<dl>
		<dt>Stones</dt>
		<dd id="user_stones"><?=number_format($user['Stones'])?></dd>
		<dt>Renas</dt>
		<dd id="user_renas"><?=number_format($user['Renas'])?></dd>
		<dt>Bank Zen</dt>
		<dd id="user_bank_zen"><?=number_format($user['Bank_Zen'])?></dd>
		<dt>Online Time</dt>
		<dd id="user_online_time"><?=$user['Online_Time']?></dd>
	</dl>
  <table>
    <thead>
      <tr><th>Name</th><th>LvL/Res<th>Class</th><th>Status</th></tr>
    </thead>
    <tbody>
      <?php
      $all_races_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
      foreach($grizismudb->query("Select * From Character Where AccountId='$account' Order by Resets desc,cLevel desc")->fetchAll() as $char){
        $status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char["AccountId"]."' AND ConnectStat = 1")->fetchAll());
        $char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
        $status = "<span class='error'>Offline</span>";
        if ($status >= 1 && $char_in_game >= 1)
        {
          $status = "<span class='success'>Online</span>";
        }
        echo"<tr><td onclick='loadAjaxPage(\"Modules_Character-Info&CharacterName=".$char['Name']."\",\"content\")'>".$char['Name']."</td><td>".$char['cLevel']."/".$char['Resets']."</td><td>".$all_races_name[$char['Class']]."</td><td> $status</td></tr>";
      }
      ?>
    </tbody>
  </table>
<?php
}
?>