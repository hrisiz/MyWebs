<?php
if(isset($_SESSION['dt_username']) && isset($_SESSION['dt_password']))
{
	unset($_SESSION['dt_username']);
	unset($_SESSION['dt_password']);
	session_destroy();
	header('Location: ?p=home');
}
?>
<div class="box">
	<div class="boxTitle">USER FORM</div>
	<div class="boxBody">
		<?php
			if(isset($_POST['login']))
			{
				$store = do_login();
				show_messages($store);
			}
		?>
		<form action="?p=login" method="post">
			<ul class="form">
				<li>
					<label for="account">Account: </label>
					<input id="account" name="account" type="text" maxlength="10" />
				</li>
				<li>
					<label for="password">Password: </label>
					<input id="password" name="password" type="password" maxlength="10" />
				</li>
				<li class="buttons">
					<input name="login" type="submit" value="Login" />
					<input type="button" onclick="window.location.href='?p=register'" value="Sign UP" />
				</li>
			</ul>
		</form>
	</div>
</div>