<?php
if(isset($_SESSION['dt_username']))
{
	echo '<p class="error">Already login!</p>';
	return false;
}
?>

<div class="box">
	<div class="boxTitle">REGISTRATION FORM</div>
	<div class="boxBody">
		<?php
			if(isset($_POST['reg']))
			{
				$store = do_registration();
				show_messages($store);
			}
		?>
		<form action="?p=register" method="post">
			<ul class="form">
				<li>
					<label for="account">Account: </label>
					<input id="account" name="account" type="text" value="" maxlength="10" />
				</li>
				<li>
					<label for="password">Password: </label>
					<input id="password" name="password" type="password" value="" maxlength="10" />
				</li>
				<li>
					<label for="repassword">Re-Password: </label>
					<input id="repassword" name="repassword" type="password" value="" maxlength="10" />
				</li>
				<li>
					<label for="email">Email Address: </label>
					<input id="email" name="email" type="email" value="" maxlength="60" />
				</li>
				<li>
					<label for="question">Secret Question: </label>
					<input id="question" name="question" type="text" value="" maxlength="20" />
				</li>
				<li>
					<label for="answer">Secret Answer: </label>
					<input id="answer" name="answer" type="text" value="" maxlength="20" />
				</li>
				<li class="buttons">
					<input name="reg" type="submit" value="Create New Account" />
				</li>
			</ul>
		</form>
	</div>
</div>