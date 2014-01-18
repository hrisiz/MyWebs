<?php
if (isset($_POST['register']))
{
	if(mssql_num_rows(mssql_query("Select * From Users Where User_Name = '".$_POST['username']."'")) > 0){
		echo"<p>This UserName exist!</p>";
	}elseif($_POST['password'] != $_POST['rpassword']){
		echo"<p>Password are not equal</p>";
	}elseif(strlen($_POST['password']) > 10){
		echo"<p>Password is too long.Max 10 symbols!</p>";
	}elseif(strlen($_POST['username']) > 10){
		echo"<p>Username is too long.Max 10 symbols!</p>";
	}elseif(strlen($_POST['e-mail']) > 50){
		echo"<p>E-Mail is too long.Max 50 symbols!</p>";
	}elseif(strlen($_POST['squation']) > 50){
		echo"<p>Secret Question is too long.Max 50 symbols!</p>";
	}elseif(strlen($_POST['sanswer']) > 50){
		echo"<p>Secret Answer is too long.Max 50 symbols!</p>";
	}elseif(empty($_POST['username']) || empty($_POST['password'])){
		echo"<p>Empty fields!</p>";
	}elseif($_POST['check'] != $_SESSION['check_code']){
		echo"<p>Codes are not equal</p>";
	}else{
		mssql_query("Insert Into Users values('".$_POST['username']."',"."0x".md5($_POST['password']).",'".$_POST['e-mail']."','".$_POST['squestion']."','".$_POST['sanswer']."',0,'0','".$_SERVER['REMOTE_ADDR']."')");
		echo"<p>Successfully</p>";
	}
}
$_SESSION['check_code'] = rand(1000,9999);
?>
<form Method="POST">
	<label>User Name</label><br>
	<input type="text" name="username" maxlength="10"/><br>
	<label>Password</label><br>
	<input type="password" name="password" maxlength="10"/><br>
	<label>Repeat Password</label><br>
	<input type="password" name="rpassword" maxlength="10"/><br>
	<label>E-Mail</label><br>
	<input type="email" name="e-mail" maxlength="50"/><br>
	<label>Secret Question</label><br>
	<input type="password" name="squestion" maxlength="50"/><br>
	<label>Secret Answer</label><br>
	<input type="text" name="sanswer" maxlength="50"/><br>	
	<label>Check Code</label><br>
	<input type="text" maxlength="4" value="<?=$_SESSION['check_code']?>" size="1" disabled/><br>	
	<label>Code</label><br>
	<input type="text" name="check" maxlength="4" size="1"/><br><br>
	<input class="button" type="submit" value="Register" name="register"/><br>
</form>