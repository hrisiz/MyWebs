<?php
mssql_query("Delete From Test Where User_Name='$account'");
mssql_query("Update Users Set MaxPoints = 0 Where User_Name = '$account'");
if (isset($_GET['answer']) && !empty($_GET['answer']) && isset($_GET['number']) && !empty($_GET['number']))
{
	$question_info = mssql_fetch_row(mssql_query("Select Correct_Answer,Question_Points From Questions Where ID=".$_GET['number'].""));
	if ($_GET['answer'] == $question_info[0])
	{
		$is_true = "True";
		$points = $question_info[1];
	}else{
		$is_true = "False";
		$points = 0;
	}
	$check_question_id_in_test = mssql_num_rows(mssql_query("Select * From Test Where Question_ID=".$_GET['number']." AND User_Name='$account'"));
	if ($check_question_id_in_test > 0)
	{
		$was_true = $questions->query("Select Answer From Test Where User_Name='$account' AND Question_ID=".$_GET['number']."")->fetchAll();
		$was_true = $was_true[0];
		if ($was_true[0] == "True")
		{
			mssql_query("Update Users Set EndedTime=".time().",MaxPoints = MaxPoints-$question_info[1]+$points Where User_Name='$account'");
		}
		else
		{
			mssql_query("Update Users Set EndedTime=".time().",MaxPoints = MaxPoints+$points Where User_Name='$account'");
		}
		mssql_query("Update Test Set Answer='$is_true' Where User_Name='$account' AND Question_ID=".$_GET['number']."");
	}else{
		mssql_query("Update Users Set EndedTime=".time().",MaxPoints = MaxPoints+$points Where User_Name='$account'");
		mssql_query("Insert Into Test values('$account',$question_info[1],".$_GET['number'].",'$is_true')");
	}
}
$all_questions = mssql_num_rows(mssql_query("Select * From Questions"));
$all_user_questions = mssql_num_rows(mssql_query("Select * From Test Where User_Name='$account'"));
if ($all_user_questions >= $max_questions || $all_user_questions >= $all_questions)
{
	echo"<p>Loading...</p>";
	echo"<script>redirect(\"?value=END\")</script>";
	exit;
}
if ($_GET['is_back'] == "True")
{
	$question = mssql_fetch_row(mssql_query("Select TOP 1 * From Questions Where ID=".$_GET['number'].""));
}else{
	do{
		$question = mssql_fetch_row(mssql_query("Select TOP 1 * From Questions order by NEWID()"));
		$check_question_id = mssql_fetch_row(mssql_query("Select count(*) From Test Where User_Name='$account' AND Question_ID=$question[0]"));
	}while ($check_question_id[0] > 0);
}
$next = $question[0];
echo"<p>$question[1]</p>";
$numbers = array(2,3,4,5);
for ($i = 0; $i < 4; $i++)
{
	if ($i == 2)
	{
		echo"<br>";
	}
	$number = array_rand($numbers);
	$text = $question[$numbers[$number]];
	$answer = $question[$numbers[$number]];
	if ($numbers[$number] == 2)
	{
		echo"<!-- --><a href=\"?value=Test&answer=$answer&number=$next\"><button>$text</button></a>";
	}
	else{
		echo"<a href=\"?value=Test&answer=$answer&number=$next\"><button>$text</button></a>";
	}
	unset($numbers[$number]);
}
echo"<br>";
foreach (mssql_fetch_row(mssql_query("Select Question_ID From Test Where User_Name='$account'")) as $number)
{
	$number = $number[0];
	echo"<a href=\"?value=Test&number=$number&is_back=True\">".($i+1)." </a>";
}

?>