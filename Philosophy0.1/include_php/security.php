<?php
$path_parts = pathinfo(__FILE__);
if (eregi($path_parts['basename'], $_SERVER['SCRIPT_NAME'])) { header("Location: /?page=News"); }

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
//BAD Symbols
$queryString = strtolower($_SERVER['QUERY_STRING']);

if (strstr($queryString,"<") OR strstr($queryString,">") OR strstr($queryString,"(") OR strstr($queryString,")") OR
strstr($queryString,"..") OR
strstr($queryString,"*") OR
strstr($queryString,"+") OR
strstr($queryString,"!") OR
strstr($queryString,"@")) {
$loc = $_SERVER['PHP_SELF'];
$ip = $_SERVER['REMOTE_ADDR'];
$date = date ("d-m-Y @ h:i:s");
$lfh = "Injection.txt";
$log = fopen ( $lfh,"a+" );
fputs ($log, "Attack Date: $date | Attacker IP: $ip | QueryString: $loc?=$queryString\n\n");
fclose($log);
header("Location: index.php");
}
  require_once ( 'class.floodblocker.php' );
  $flb = new FloodBlocker ( 'floods/' );
  $floodfile = "floods/floodlog.txt";
  $ipaddress = $_SERVER['REMOTE_ADDR'];
  $addedtime = date("D dS M Y h:i a");

  $flb->rules = array (
    5=>10,    // Правило 1 - максимум 10 заявки за 10 секунди
    30=>30,    // Правило 2 - максимум 30 заявки за 60 секунди
    150=>50,   // Правило 3 - максимум 50 заявки за 300 секунди
    1900=>200  // Правило 4 - максимум 200 заявки за 3600 секунди
  );

  if ( ! $flb->CheckFlood ( ) ) {
$floodfp = fopen($floodfile, "a+");
fputs($floodfp, "Date and Time: $addedtime | IP Address: $ipaddress\n");
fclose($floodfp);
    include("413.php"); exit;
}
?>