<?php
$question_info = mssql_fetch_assoc(mssql_query("Select * From Questions Where ID=".$_POST['question_id'].""));
$question_info['Question'] = explode("<br>",$question_info['Question']);
if(!empty($question_info['Question'][1])){
	$image = explode("src=",$question_info['Question'][1]);
	$image = explode("alt",$image[1]);
	$image = $image[0];
	echo $image;
	$what_is = preg_match("/http/", $image, $matches);
	if(empty($what_is)){
		$image = $image;
	}else{
		$link = $image;
	}
}
?>
<form action="?value=MyQuestions" Method="POST" enctype="multipart/form-data">
	<input type="hidden" value="<?=$_POST['question_id']?>" name="question_id"/>
	<label>Question</label>
	<input value="<?=$question_info['Question'][0]?>" type="text" onKeyPress="check(event)" name="Question" maxlength="250" size="100"/><br>
	<label>Correct Answer</label>
	<input value="<?=$question_info['Answer_1']?>" type="text" onKeyPress="check(event)"  name="Answer_1" maxlength="100" size="50"/><br>
	<label>Answer 2</label>
	<input value="<?=$question_info['Answer_2']?>" type="text" onKeyPress="check(event)"  name="Answer_2" maxlength="100" size="50"/><br>
	<label>Answer 3</label>
	<input value="<?=$question_info['Answer_3']?>" type="text" onKeyPress="check(event)"  name="Answer_3" maxlength="100" size="50"/><br>
	<label>Answer 4</label>
	<input value="<?=$question_info['Answer_4']?>" type="text" onKeyPress="check(event)"  name="Answer_4" maxlength="100" size="50"/><br>
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file"><br>
	<input type="hidden" value="<?=$image?>" name="file_image"/>
	<label>OR<br>Link:</label>
	<input value="<?=$link?>" type="text" name="Link" size="50"/><br>
	<input type="hidden" name="Points" value="1"/>
	<input class="button" type="submit" name="edit_question" value="Add This Question"/>
</form>