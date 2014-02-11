<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

if (isset($_POST['Vote'])){
	$_SESSION['Voted_time'] = time();
	$_SESSION['Voted_link_id'] = $_POST['id'];
	$link = $grizismudb->query("Select Link From VoteLinks Where ID=".$_SESSION['Voted_link_id']."")->fetchAll();
	echo"<script>redirect('".$link[0][0]."')</script>";
}
else
{
	if(isset($_SESSION['Voted_time']))
	{

		$check_vote = count($grizismudb->query("Select * From Voted_Players Where Link_Id=".$_SESSION['Voted_link_id']." AND AccountId='$account'")->fetchAll());
		if(time() - $_SESSION['Voted_time'] < 10){
			echo"<p class=\"error\">Please vote correctly!</p>";
		}elseif($check_vote > 0){
			echo"<p class=\"error\">You already voted for this link!</p>";
		}else{
			$vote_link = $grizismudb->query("Select Link,Prize From VoteLinks Where ID=".$_SESSION['Voted_link_id']."")->fetchAll();
			$prize = explode(" ",$vote_link[0][1]);
			print $prize[0].",".$prize[1];
			$check_is_exist = count($grizismudb->query("Select * From $prize[1] Where AccountId='$account'")->fetchAll());
			print "<br>xaxa:".$check_is_exist;
			if($check_is_exist > 0)
			{
				$add_prize_code = "Update $prize[1] Set $prize[1]=$prize[1]+$prize[0] Where AccountId='$account'";
			}
			else
			{
				$add_prize_code = "Insert Into $prize[1] values('$account',$prize[0])";
			}
			$grizismudb->exec($add_prize_code);
			$grizismudb->exec("Insert Into Voted_Players values('$account',".$_SESSION['Voted_link_id'].",".time().")");
			echo"<p class=\"success\">Voted Successfully</p>";
		}
		unset($_SESSION['Voted_time']);
		unset($_SESSION['Voted_link_id']);
	}
}
echo"<table class=\"content_table\">";
foreach($grizismudb->query("Select * From VoteLinks") as $link){
	$check_is_time_end = $grizismudb->query("Select * From Voted_Players Where AccountId='$account' AND Link_Id=$link[0]")->fetchAll();
	if (time() - $check_is_time_end[0][2] >= ($link[3]*60*60)){
		$grizismudb->exec("Delete From Voted_Players Where AccountId='$account' AND Link_Id=$link[0]");
	}
	echo"<tr><td><img src=\"$link[4]\" alt=\"image\" width=\"60\" height=\"40\"/></td><td>
	<form Method=\"POST\">
		<input type=\"hidden\" name=\"id\" value=\"$link[0]\"/>";
	$check_vote = count($grizismudb->query("Select * From Voted_Players Where Link_Id=$link[0] AND AccountId='$account'")->fetchAll());
	if ($check_vote > 0){
		$time_to_end = ($link[3]*60*60)-(time() - $check_is_time_end[0][2]);
		$end_time_h = floor($time_to_end/60/60);
		$end_time_m = floor($time_to_end/60 - $end_time_h*60);
		$end_time_s = floor($time_to_end - $end_time_m*60 - $end_time_h*60*60);		
		echo"$end_time_h Hours $end_time_m minutes";//:$end_time_s";
	}
	else
	{
		echo"<input type=\"submit\" name=\"Vote\" value=\"Vote\"/>";
	}
	echo"</form></td></tr>";
}
echo"</table>";
?>
