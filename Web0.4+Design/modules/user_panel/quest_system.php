<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(!isset($_SESSION['User'])){
  echo "<p>You should be logged in for this page.</p>";
  return "";  
}
if(isset($_POST['checkQuest'])){
  
  $monster = explode("\r\n",file_get_contents($server['Server_Files_Folder']."/Data/Monster.txt"));
  for ($i = 0; $i <= count($monster); $i++)
  {
    $monstera = explode("\"",$monster[$i]);
    $id = explode("\t",$monster[$i]);
    $monsters[$id[0]] = $monstera[1];
  }
  $char = $_POST['character'];
  $quest = $grizismudb->query("Select Quests.* From Character,Quests Where Character.Name='$char' AND Quests.QuestID=Character.QuestNumber")->fetchAll();
  if($quest[0]['RequiredItemGroup'] != NULL){
    $item = $grizismudb->query("Select * From Items Where ID=".$quest[0]['RequiredItemID']." AND Type=".$quest[0]['RequiredItemGroup']."")->fetchAll();
  }
?>
  <dl>
    <dt>Quest ID</dt>
      <dd><?=$quest[0]['QuestID']?></dd>
    <dt>Monsters[Count]</dt>
      <dd><?=$monster[$quest['MonsterID']]?>[<?=$quest[0]['MonstersCount']?>]</dd>
    <dt>Require Item[Count]</dt>
      <dd><p class="withhiddenelem"><?=$item[0]['Name']?>[<?=$quest[0]['RequiredItemCount']?>]</p><div><img src="images/<?=$quest[0]['RequiredItemGroup']?>00<?=$quest[0]['RequiredItemID']?>.gif"/></div></dd>
  </dl>
<?php
}
?>
<form method="POST">
	<label>Character:</label>
	<select name="character">
		<?php echo get_chars(-1,"QuestNumber");?>
	</select><br>
	<input onclick="startLoading()" type="submit" name="checkQuest" value="Check Quest"/>
</form>
