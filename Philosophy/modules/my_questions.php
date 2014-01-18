<?php
/*if(isset($_POST['Delete'])){
	$question_info = mssql_fetch_assoc(mssql_query("Select * From Questions Where ID=".$_POST['question_id']));
	$question_info['Question'] = explode("<br>",$question_info['Question']);
	if(!empty($question_info['Question'][1])){
		$image = explode("src=",$question_info['Question'][1]);
		$image = explode("alt",$image[1]);
		$image = $image[0];
		$what_is = preg_match("/http/", $image, $matches);
		if(empty($what_is)){
			unlink($image);
		}
	}
	mssql_query("Delete From Questions Where ID=".$_POST['question_id']);
}*/
if(isset($_POST['edit_question'])){
	$allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/png");
	$allowedExts1 = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if (strlen($_POST['Question']) > 300)
	{
		echo"<p>Max Question length is 300</p>";
	}
	elseif(strlen($_POST['Answer_1']) > 100 || strlen($_POST['Answer_2']) > 100 || strlen($_POST['Answer_3']) > 100 || strlen($_POST['Answer_4']) > 100)
	{
		echo"<p>Max Answer length is 100</p>";
	}
	elseif(!isset($account))
	{
		echo"<p>Login first!</p>";
	}
	elseif(empty($_POST['Question']) || empty($_POST['Answer_4']) || empty($_POST['Answer_3']) || empty($_POST['Answer_2']) || empty($_POST['Answer_1']))
	{
		echo"<p>There have empty fields !!!</p>";
	}
	elseif(mssql_num_rows(mssql_query("Select * From Questions Where Question='".$_POST['Question']."'")) > 0)
	{
		echo"<p>This Question already exist.</p>";
	}
	elseif(($_FILES["file"]["size"] > 0) && (!in_array($_FILES["file"]["type"], $allowedExts) || !in_array($extension, $allowedExts1) || $_FILES["file"]["size"] / 1024 > 500))
	{
		echo"<p>This isn't image.</p>";
	}
	elseif ($_FILES["file"]["size"] > 0 && file_exists("upload/" . $_FILES["file"]["name"]) && ("upload/" . $_FILES["file"]["name"]) != $_POST['file_image'])
	{
		echo $_FILES["file"]["name"] . " already exists.Please change the file name and try again.";
	}
	elseif ($_FILES["file"]["size"] > 0 && $_FILES["file"]["error"] < 0)
	{
		echo "<p>Error: " . $_FILES["file"]["error"]."</p>";
	}
	elseif ($_POST['Answer_1'] == $_POST['Answer_2']
	|| $_POST['Answer_1'] == $_POST['Answer_2']
	|| $_POST['Answer_1'] == $_POST['Answer_3']
	|| $_POST['Answer_1'] == $_POST['Answer_4']
	|| $_POST['Answer_2'] == $_POST['Answer_3']
	|| $_POST['Answer_2'] == $_POST['Answer_4']
	|| $_POST['Answer_3'] == $_POST['Answer_4'])
	{
		echo "<p>There have two or more same answers</p>";
	}
	else
	{
		if ($_FILES["file"]["size"] > 0)
		{
			if(!empty($_POST['file_image'])){
				unlink($_POST['file_image']);
			}
			move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
			$_POST['Question'] = $_POST['Question'] . "<br><img src=upload/".$_FILES["file"]["name"]." alt=picture id=choose />";
		}
		elseif (!empty($_POST['Link']) && isset($_POST['Link']))
		{
			$_POST['Question'] = $_POST['Question'] . "<br><img src=".$_POST['Link']." alt=picture id=choose />";
		}elseif(!empty($_POST['file_image'])){
			$_POST['Question'] = $_POST['Question'] . "<br><img src=".$_POST['file_image']." alt=picture id=choose />";
		}
		if (strlen($_POST['Question']) > 500)
		{
			echo"<p>Image Name or Question is too long.</p>";
			
		}
		else
		{
			$query_code1 = "Update Questions Set Question='".$_POST['Question']."',Answer_1='".$_POST['Answer_1']."',Answer_2='".$_POST['Answer_2']."',Answer_3='".$_POST['Answer_3']."',Answer_4='".$_POST['Answer_4']."',Correct_Answer='".$_POST['Answer_1']."' Where ID=".$_POST['question_id']."";
			file_put_contents("Update.txt",$query_code1."\r\n",FILE_APPEND);
			mssql_query($query_code1);
			
			echo"<p>Successfully Added</p>";
		}
		
	}
}
?>

<table border="1">
<tr><th>#</th><th>Question</th><th>Correct Answer</th><th>Answer 2</th><th>Answer 3</th><th>Answer 4</th><th>Edit</th><!--<th>Delete</th>--></tr>
<?php 
	$my_questions = mssql_query("Select * From Questions Where User_Name='$account'");
	for($i = 0;$i < mssql_num_rows($my_questions);$i++){
		$my_question = mssql_fetch_assoc($my_questions);
		echo"<tr>
			<td>$i</td>
			<td>".$my_question['Question']."</td>
			<td>".$my_question['Answer_1']."</td>
			<td>".$my_question['Answer_2']."</td>
			<td>".$my_question['Answer_3']."</td>
			<td>".$my_question['Answer_4']."</td>
			<td>
				<form action=\"?value=EditQuestion\" Method=\"POST\">
					<input type=\"hidden\" value=\"".$my_question['ID']."\" name=\"question_id\"/>  
					<input type=\"submit\" name=\"Edit\" value=\"Edit\"/>
				</form>
			</td>
			<!--<td>
				<form method=\"POST\">
					<input type=\"hidden\" value=\"".$my_question['ID']."\" name=\"question_id\"/>  
					<input type=\"submit\" name=\"Delete\" value=\"Delete\"/>
				</form>
			</td>-->
		</tr>";
	}
?>
</table>