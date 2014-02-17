<?php
	if (isset($_POST['add_question']))
	{
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
		elseif(Count($questions->query("Select * From Questions Where Question='".$_POST['Question']."'")->fetchAll()) > 0)
		{
			echo"<p>This Question already exist.</p>";
		}
		elseif(($_FILES["file"]["size"] > 0) && (!in_array($_FILES["file"]["type"], $allowedExts) || !in_array($extension, $allowedExts1) || $_FILES["file"]["size"] / 1024 > 500))
		{
			echo"<p>This is not a good file!!xaxa:$extension<br>xaxa:".$_FILES["file"]["type"]."</p>";
		}
		elseif ($_FILES["file"]["size"] > 0 && file_exists("upload/" . $_FILES["file"]["name"]))
		{
			echo $_FILES["file"]["name"] . " already exists. ";
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
				move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
				$_POST['Question'] = $_POST['Question'] . "<br><img src=upload/".$_FILES["file"]["name"]." alt=picture id=choose />";
			}
			elseif (!empty($_POST['Link']) && isset($_POST['Link']))
			{
				$_POST['Question'] = $_POST['Question'] . "<br><img src=".$_POST['Link']." alt=picture id=choose />";
			}
			if (strlen($_POST['Question']) > 500)
			{
				echo"<p>Link is too long</p>";
				
			}
			else
			
			{
				$questions->exec("Insert Into Questions values('".$_POST['Question']."','".$_POST['Answer_1']."','".$_POST['Answer_2']."','".$_POST['Answer_3']."','".$_POST['Answer_4']."','".$_POST['Answer_1']."',".$_POST['Points'].",'$account')");
				echo"<p>Successfully Added</p>";
			}
			
		}
	}
	
?>

<form Method="POST" enctype="multipart/form-data">
	<label>Question</label>
	<input type="text" onKeyPress="check(event)" name="Question" maxlength="250" size="100"/><br>
	<label>Correct Answer</label>
	<input type="text" onKeyPress="check(event)"  name="Answer_1" maxlength="100" size="50"/><br>
	<label>Answer 2</label>
	<input type="text" onKeyPress="check(event)"  name="Answer_2" maxlength="100" size="50"/><br>
	<label>Answer 3</label>
	<input type="text" onKeyPress="check(event)"  name="Answer_3" maxlength="100" size="50"/><br>
	<label>Answer 4</label>
	<input type="text" onKeyPress="check(event)"  name="Answer_4" maxlength="100" size="50"/><br>
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file"><br>
	<label>OR<br>Link:</label>
	<input type="text" name="Link" size="50"/><br>
	<input type="hidden" name="Points" value="1"/>
	<!--<label>Points:</label>
	<select name="Points">
	<?
	for ($i = 1;$i <= 6; $i++)
	{
		echo"<option value='$i'>$i</option>";
	}	
	?>
	</select>
	<br>-->
	<input class="button" type="submit" name="add_question" value="Add This Question"/>
</form>