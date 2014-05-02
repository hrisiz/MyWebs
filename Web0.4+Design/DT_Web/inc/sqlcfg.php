<?php

function secure($string)
{
	if (preg_match('/[^a-zA-Z0-9\_\.\-\.@\s]/', $string) && !empty($string))
	{
		die('Invalid symbols!');
	}
	$string = trim($string);
	$string = addslashes($string);
	$string = htmlspecialchars($string, ENT_NOQUOTES);
	return $string;
}

if(@isset($_POST))
{
	foreach($_POST as $pkay => $pval)
	{
		$_POST[$pkay]= secure($pval);
	}
}

if(@isset($_GET))
{
	foreach($_GET as $gkay => $gval)
	{
		$_GET[$gkay]= secure($gval);
	}
}

if(@isset($_REQUEST))
{
	foreach($_REQUEST as $rkay => $rval)
	{
		$_REQUEST[$rkay]= secure($rval);
	}
}