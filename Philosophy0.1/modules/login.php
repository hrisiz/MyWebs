<?php
if (isset($_POST['login']))
{
	if(Count($questions->query("Select * From Users Where User_Name = '".$_POST['username']."' AND Password = "."0x".md5($_POST['password'])."")->fetchAll()) <= 0)
	{
		echo"<p>Not exist!</p>";
	}
	elseif(strlen($_POST['password']) > 10)
	{
		echo"<p>Password is too long.Max 10 symbols!</p>";
	}
	elseif(strlen($_POST['username']) > 10)
	{
		echo"<p>Username is too long.Max 10 symbols!</p>";
	}
	elseif(empty($_POST['username']) || empty($_POST['password']))
	{
		echo"<p>Empty fields!</p>";
	}
	else
	{
		$_SESSION['user'] = $_POST['username'];
		echo"Loading...";
		echo"<script>redirect(\"?value=questions\")</script>";
		exit;
	}
}
?>
<form Method="POST">
	<label>User Name</label>
	<input type="text" name="username" maxlength="10"/><br>
	<label>Password</label>
	<input type="password" name="password" maxlength="10"/><br>
	<input class="button" type="submit" value="Login" name="login"/><br>
</form>