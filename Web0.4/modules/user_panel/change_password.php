<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['change'])){
	$old = $_POST['old_password'];
	$new = $_POST['new_password'];
	$check_password = $grizismudb->query("Select memb__pwd from MEMB_INFO Where memb___id='$account'")->fetchAll();
	if(empty($old) || empty($new)){
		echo"<p class=\"error\">You leave some empty fields.</p>";
	}elseif($new != $_POST['new_repeated_password']){
		echo"<p class=\"error\">Repeat new password field is wrong.</p>";
	}elseif($old != $check_password[0][0]){
		echo"<p class=\"error\">Wrong old password.</p>";
	}else{
		$grizismudb->exec("Update MEMB_INFO Set memb__pwd='$new' Where memb___id='$account'");
		print"<p class=\"success\">Successfully Changed.</p>";
	}
}
?>
<form Method="POST">
	<label>Old password</label>
	<input type="password" name="old_password"/><br>
	<label>New passowrd</label>
	<input type="password" name="new_password"/><br>
	<label>Repeat new password</label>
	<input type="password" name="new_repeated_password"/><br>
	<input type="submit" name="change" value="Change"/>
</form>