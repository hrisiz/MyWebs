
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['login']))
{
	if(strlen($_POST['User']) > 10 || strlen($_POST['Password']) > 10)
	{
		echo"<p class='error'>Some fields are with more symbols then permitted.</p>";
	}
	else
	{
		$check_acc = $grizismudb->query("Select * From MEMB_INFO Where memb___id = '".$_POST['User']."' AND memb__pwd = '".$_POST['Password']."'")->fetchAll();
	}
	if (empty($check_acc) || !isset($check_acc) || $check_acc < 0)
	{
		echo"<p class='error'>This Account doesn't exist!</p>";
	}
	else
	{
		$_SESSION['LoggedUser'] = $_POST['User'];
		echo"<p class='success'>Loading...</p>";
		echo"<script>setTimeout(function(){redirect('?page=UserPanel');},2000)</script>";
	}
}
?>
<form action="?page=Register&subpage=Login" method="POST">
	<label for="User">UserName:</label>
	<input id="User" name="User" type="text" size="11" maxlength="10"/><br>
	<label for="User">Password:</label>
	<input id="Password" name="Password" type="password" size="11" maxlength="10"/><br>
	<input name="login" type="submit" value="LogIn"/>
</form>