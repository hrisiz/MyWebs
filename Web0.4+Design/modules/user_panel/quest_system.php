<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
if(isset($_POST['NextQuest'])){
	$character = $_POST['character'];
	$char_info = $grizismudb->query("Select * From Character Where Name='$character'")->fetchAll();
	$quest = $grizismudb->query("Select * From Quests Where QuestID=".$char_info[0]['QuestNumber']."")->fetchAll();
	if(count($char_info) <= 0){
		echo"<p class=\"error\">This is not your character</p>";
	}elseif($char_info[0]['QuestMonsters'] < $quest[0]['MonstersCount']){
		echo"<p class=\"error\">You don't have enough killed monsters</p>";
	}else{
		if(count($grizismudb->query("Select * from Quests where QuestId=".($char_info[0]['QuestNumber']+1)."")->fetchAll()) <= 0){
			echo"<p class=\"success\">You successfully ended last quest.</p>";
		}else{
			$grizismudb->exec("Update Character Set QuestNumber=QuestNumber+1,QuestMonsters=0,QuestInCurse=0 Where Name='$character'");
			echo"<p class=\"success\">You successfully get the new quest.</p>";
		}
		GiveQuestPrize($char_info[0]['QuestNumber'],$character);
	}
}
?>
<form method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars("QuestNumber","QuestNumber");?>
	</select><br>
	<input type="submit" name="NextQuest" value="NextQuest"/>
</form>
