<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}

if (isset($_POST['Vote'])){
	$_SESSION['Voted_time'] = time();
	$_SESSION['Voted_link_id'] = $_POST['id'];
	$link = $grizismudb->query("Select Link From VoteLinks Where ID=".$_SESSION['Voted_link_id']."")->fetchAll();
	header("Location:".$link[0][0]);
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
			$vote_link = $grizismudb->query("Select Link,Prize,PrizeType From VoteLinks Where ID=".$_SESSION['Voted_link_id'])->fetchAll();
			$vote_link = $vote_link[0];
			$check_is_exist = count($grizismudb->query("Select * From $vote_link[2] Where AccountId='$account'")->fetchAll());
			if($check_is_exist > 0)
			{
				$add_prize_code = "Update $vote_link[2] Set $vote_link[2]=$vote_link[2]+$vote_link[1] Where AccountId='$account'";
			}
			else
			{
				$add_prize_code = "Insert Into $vote_link[2] values('$account',$vote_link[1])";
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
	if (time() - $check_is_time_end[0][2] >= ($link['Time'])){
		$grizismudb->exec("Delete From Voted_Players Where AccountId='$account' AND Link_Id=$link[0]");
	}
	echo"<tr><td><img src=\"".$link['img']."\" alt=\"image\" width=\"60\" height=\"40\"/></td><td id=\"vote_timer\">
	<form Method=\"POST\">
		<input type=\"hidden\" name=\"id\" value=\"$link[0]\"/>";
	$check_vote = count($grizismudb->query("Select * From Voted_Players Where Link_Id=$link[0] AND AccountId='$account'")->fetchAll());
	if ($check_vote > 0){
		$time_to_end = $link['Time']-(time() - $check_is_time_end[0][2]);//3700
		$end_time_h = floor($time_to_end/60/60); //1
		$end_time_m = floor($time_to_end/60 - ($end_time_h*60));
		$end_time_s = floor($time_to_end - $end_time_m*60 - $end_time_h*60*60);		
		echo"$end_time_h Hours $end_time_m Minutes $end_time_s Seconds";//:$end_time_s";
		echo"<script>timer_start($time_to_end,'vote_timer')</script>";
	}
	else
	{
		echo"<input type=\"submit\" name=\"Vote\" value=\"Vote\"/>";
	}
	echo"</form></td></tr>";
}
echo"</table>";
?>
