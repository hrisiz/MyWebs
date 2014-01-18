<table>
<tr><th>#</th><th>User</th><th>Points</th></tr>
<?
	$all_users = mssql_query("Select Top 20 User_Name,MaxPoints From Users order by MaxPoints desc,EndedTime desc");
	for($i = 0; $i < mssql_num_rows($all_users);$i++)
	{
		$user = mssql_fetch_row($all_users);
		$max_your_questions = mssql_num_rows(mssql_query("Select * From Test Where User_Name='$user[0]'"));
		$k = $user[1]*100/$max_your_questions;
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
		print "<tr><td>".($i+1)."</td><td>$user[0]</td><td>$mark $is_first</td></tr>";
	}
?>
</table>