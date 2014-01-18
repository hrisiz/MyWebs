<?
	$is_there_someting_new = mssql_num_rows(mssql_query("Select * From Test Where User_Name='$account'"));
	if ($is_there_someting_new > 0 && !empty($is_there_someting_new))
	{
		$player_questions = mssql_query("Select Question_ID,Answer From Test Where User_Name='$account'");
		$points = 0;
		echo"<table border=1>
		<tr><th>Question</th><!--<th>Correct_Answer</th>--><th>Points</th><th>Answer</th></tr>";
		for ($i = 0; $i < mssql_num_rows($player_questions); $i++)
		{
			$question_count = mssql_fetch_row($player_questions);
			$question_number = $question_count[0];
			$question_array = mssql_fetch_row(mssql_query("Select * From Questions Where ID=$question_number"));
			$question['Image'] = explode("<img",$question_array[1]);
			if (count($question['Image']) > 1)
			{
				$question['Image'] = "<img".end($question['Image']);
				$question['Image'] = "style=\"background-position:center;background-repeat:no-repeat;\" onmouseover=\"return overlib('".$question['Image']."');\" onmouseout=\"return nd()\"";
				$question['Text'] = explode("<img",$question_array[1]);
				$question['Text'] = $question['Text'][0];
			}
			else
			{
				$question['Text'] = $question_array[1];
				$question['Image'] = "";
			}
			$question['Correct'] = $question_array[6];
			$question['Points'] = $question_array[7];
			$question['Answer'] = $question_count[1];
			echo"<tr><td ".$question['Image'].">".$question['Text']."</td><!--<td>".$question['Correct']."</td>--><td>".$question['Points']."</td><td>".$question['Answer']."</td></tr>";
		}
		$points = mssql_fetch_row(mssql_query("Select MaxPoints From Users Where User_Name='$account'"));
		$points = $points[0];
		echo"</table>";
		$max_your_questions = mssql_num_rows(mssql_query("Select * From Test Where User_Name='$account'"));
		$k = $points*100/$max_your_questions;
		if ($k >= 0 && $k <= 20)
		{
			$mark = "Ти си много тъп!!!";
		}elseif($k >= 21 && $k <= 34){
			$mark = "Вашият резултат е Слаб ;(";
		}elseif($k >= 35 && $k <= 49){
			$mark = "Вашият резултат е Среден :S";
		}elseif($k >= 50 && $k <= 74){
			$mark = "Вашият резултат е Добър";
		}elseif($k >= 75 && $k <= 90){
			$mark = "Вашият резултат е Мн.Добър :)";
		}elseif($k >= 91 && $k <= 100){
			$mark = "Вашият резултат е Отличен ^_^";
		}
		echo"<p>$mark</p>";
	}
	else
	{
		echo"<p>There no more Questions!</p>";
	}
?>