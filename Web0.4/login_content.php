<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

if($_GET['subpage'] == "Logout"){
	unset($_SESSION['User']);
	header("Location: /?page=Modules_Home");
}

if(isset($_POST['login'])){
	$user = $_POST['user'];
	$check_acc = $grizismudb->query("Select * From MEMB_INFO Where memb___id='$user' AND memb__pwd='".$_POST['password']."'")->fetchAll();
	if(count($check_acc) <= 0){
		echo"<p class=\"error\">Wrong user or password</p>";
	}else{
		$_SESSION['User']=$user;
		$account = $_SESSION['User'];
	}
}

if(!isset($_SESSION['User'])){
?>
	<form method="POST">
		<label for="user">UserName</label>
		<input type="text" name="user" id="user"/>
		<label for="password">Password</label>
		<input type="password" name="password" id="password"/>
		<input type="Submit" name="login" value="LogIn"/>
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
	<button>User Information</button>
	<dl id="login_panel_user_information">
		<dt>Stones:</dt>
		<dd id="user_stones"><?=number_format($user['Stones'])?></dd>
		<dt>Renas:</dt>
		<dd id="user_renas"><?=number_format($user['Renas'])?></dd>
		<dt>Bank Zen:</dt>
		<dd id="user_bank_zen"><?=number_format($user['Bank_Zen'])?></dd>
		<dt>Online Time:</dt>
		<dd id="user_online_time"><?=$user['Online_Time']?></dd>
	</dl>
	<br>
	<ul id="user_panel_menu">
		<li><h3>Character Options</h3>
			<ul class="left">
				<a href="?page=Modules_User-Panel_Reset-Character"><li>Reset Char</li></a>
				<a href="?page=Modules_User-Panel_Add-Stats"><li>Add Stats</li></a>
				<a href="?page=Modules_User-Panel_Bank"><li>Bank</li></a>
			</ul>
			<ul class="right">
				<a href="?page=Modules_User-Panel_Clear-Stats"><li>Clear Stats</li></a>
				<a href="?page=Modules_User-Panel_Clear-PK"><li>Clear PK</li></a>
				<a href="?page=Modules_Home&subpage=Logout"><li>LogOut</li></a>
			</ul>
		</li>
		<li><h3>Renas Options</h3>
			<ul class="left">
				<a href="?page=Modules_User-Panel_Renas_Deposit-Renas"><li>Deposit</li></a>
				<a href="?page=Modules_User-Panel_Renas_Get-Jewels"><li>Get Jewels</li></a>
			</ul>
			<ul class="right">
				<a href="?page=Modules_User-Panel_Renas_Upgrade-Items"><li>UpItems</li></a>
			</ul>
		</li>
		<li><h3>Stones Options</h3>
			<ul class="left">
				<a href="?page=Modules_User-Panel_Stones_Deposit-Stones"><li>Deposit</li></a>
				<a href="?page=Modules_User-Panel_Stones_Change-Name"><li>ChangeName</li></a>
			</ul>
			<ul  class="right">
				<a href="?page=Modules_User-Panel_Stones_Get-Zen"><li>Get Zen</li></a>
				<a href="?page=Modules_User-Panel_Stones_Change-Race"><li>ChangeRace</li></a>
			</ul>
		</li>
		<li><h3>Other Options</h3>
			<ul class="center">
				
			</ul>
			<ul class="left">
				<a href="?page=Modules_User-Panel_Auction"><li>Auction</li></a>
				<a href="?page=Modules_User-Panel_Web-Market"><li>Web Market</li></a>
				<a href="?page=Modules_User-Panel_Web-House"><li>Web House</li>
			</ul>
			<ul class="right">
				<a href="?page=Modules_User-Panel_Vote-Reward"><li>Vote Reward</li></a>
				<a href="?page=Modules_User-Panel_Change-Password"><li>ChangePass</li></a>
				<a href="?page=Modules_User-Panel_Quest-System"><li>Quests</li></a>
			</ul>
		</li>
		
	</ul>
<?php
}
?>