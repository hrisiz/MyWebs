<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

	function make_log($file_name, $text)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$text = date("[".$ip."]".'m/d/Y H:i:s', time())." ".$text."\r\n";
		$file = file_put_contents ('logs/'.$file_name . date('d_m_y', time()) . '.log', $text, FILE_APPEND);
	}
	
	function filter($value)
	{
		$arr_filter = array("'",'"',';',':','%');
		foreach($arr_filter as $filter)
		{
			if (strpos($value, $filter))
			{
				make_log('sys_security', 'value: ' . $value);
			}
		}
		$value = trim($value);
		$value = htmlspecialchars($value);
		return $value;
	}
	
	if(isset($_GET))
	{
		foreach($_GET as $key => $value)
		{
			$_GET[$key] = filter($value);
		}
	}
	
	if(isset($_POST))
	{
		foreach($_POST as $key => $value)
		{
			$_POST[$key] = filter($value);
		}
	}
	
	if(isset($_SESSION))
	{
		foreach($_SESSION as $key => $value)
		{
			$_SESSION[$key] = filter($value);
		}
	}
?>