<table>
<tr><th>#</th><th>User</th><th>Points</th></tr>
<?php
	foreach($questions->query("Select Top 20 User_Name,MaxPoints From Users order by MaxPoints desc,EndedTime desc")->fetchAll() as $user)
	{
		$max_your_questions = Count($questions->query("Select * From Test Where User_Name='$user[0]'")->fetchAll());
		$k = $user['MaxPoints']*100/$max_your_questions;
		if ($k >= 0 && $k <= 20)
		{
			$mark = "Много тъп!!!";
		}elseif($k >= 21 && $k <= 34){
			$mark = "Слаб ;(";
		}elseif($k >= 35 && $k <= 49){
			$mark = "Среден";
		}elseif($k >= 50 && $k <= 74){
			$mark = "Добър.";
		}elseif($k >= 75 && $k <= 90){
			$mark = "Мн.Добър";
		}elseif($k >= 91 && $k <= 100){
			$mark = "Отличен ";
		}
		if ($i == 0){
			$is_first = " ^_^";
		}else{
			$is_first = "";
		}
		if ($user[1] == 0)
		{
			$mark = "-";
		}
		print "<tr><td>".($i+1)."</td><td>".$user['User_Name']."</td><td>$mark $is_first</td></tr>";
	}
?>
</table>