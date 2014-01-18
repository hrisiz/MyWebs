<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<?php 
print_r($_POST);?>
<form method="POST" action="">
<?php
echo"<input type=\"checkbox\" name=\"things[]\" value=\"red\"> Cat<br>
<input type=\"checkbox\" name=\"things[]\" value=\"blue\"> Mouse<br>
<input type=\"checkbox\" name=\"things[]\" value=\"green\"> Car<br>
<input type=\"checkbox\" name=\"things[]\" value=\"yellow\"> DaniWeb
<input type=\"submit\" name=\"submit\">
";
?>
</form>