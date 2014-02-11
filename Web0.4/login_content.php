<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

if($_GET['subpage'] == "Logout"){
	unset($_SESSION['User']);
}

if(isset($_POST['login'])){
	$user = $_POST['user'];
	$check_acc = $grizismudb->query("Select * From MEMB_INFO Where memb___id='$user' AND memb__pwd='".$_POST['password']."'")->fetchAll();
	if(count($check_acc) <= 0){
		echo"<p class=\"error\">Wrong user or password</p>";
	}else{
		$_SESSION['User']=$user;
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
		<button>Register</button>
	</form>
<?php
}else{
?>
	<div>
		<h3>Character Options</h3>
		<div>
			<div class="left">
				<ul>
					<a href="?page=Modules_User-Panel_Reset-Character"><li>Reset Character</li></a>
					<a href="?page=Modules_User-Panel_Add-Stats"><li>Add Stats</li></a>
					<a href="?page=Modules_User-Panel_Bank"><li>Bank</li></a>
				</ul>
			</div>
			<div class="right">
				<ul>
					<a href="?page=Modules_User-Panel_Clear-Stats"><li>Clear Stats</li></a>
					<a href="?page=Modules_User-Panel_Clear-PK"><li>Clear PK</li></a>
					<a href="?page=Modules_Home&subpage=Logout"><li>LogOut</li></a>
				</ul>
			</div>
		</div>
		<h3>Renas Options</h3>
		<div>
			<div class="left">
				<ul>
					<a href="?page=Modules_User-Panel_Renas_Deposit-Renas"><li>Deposit</li></a>
					<a href="?page=Modules_User-Panel_Renas_Get-Jewels"><li>Get Jewels</li></a>
				</ul>
			</div>
			<div class="right">
				<ul>
					<a href="?page=Modules_User-Panel_Renas_Add-Option"><li>Add Option</li></a>
					<a href="?page=Modules_User-Panel_Renas_Up-Item-Level"><li>Up Item Level</li></a>
				</ul>
			</div>
		</div>
		<h3>Stones Options</h3>
		<div>
			<div class="left">
				<ul>
					<a href="?page=Modules_User-Panel_Stones_Deposit-Stones"><li>Deposit</li></a>
					<a href="?page=Modules_User-Panel_Stones_Get-Zen"><li>Get Zen</li></a>
				</ul>
			</div>
			<div class="right">
				<ul>
					<a href="?page=Modules_User-Panel_Stones_Change-Race"><li>Change Race</li></a>
					<a href="?page=Modules_User-Panel_Stones_Change-Name"><li>Change Name</li></a>
				</ul>
			</div>
		</div>
		<h3>Other Options</h3>
		<div>
			<div class="left">
				<ul>
					<a href="?page=Modules_User-Panel_Auction"><li>Auction</li></a>
					<a href="?page=Modules_User-Panel_Web-Market"><li>Web Market</li></a>
				</ul>
			</div>
			<div class="right">
				<ul>
					<a href="?page=Modules_User-Panel_Vote-Reward"><li>Vote Reward</li></a>
					<a href="?page=Modules_User-Panel_Change-Password"><li>Change Password</li></a>
				</ul>
			</div>
		</div>
	</div>
<?php
}
?>