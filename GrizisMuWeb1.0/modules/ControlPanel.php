
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
read_files_from_folder("modules/UserPanel");
if(!isset($_GET['subpage'])){
echo "<table class=\"content_table\">
<tr><th>Name</th><th>Level/Reset</th><th>Guild</th><th>Status</th></tr>";
foreach($grizismudb->query("Select Name,cLevel,Resets,GrandResets From Character Where AccountID='".$_SESSION['LoggedUser']."'") as $char)
{
	$guild = $grizismudb->query("Select * From GuildMember Where Name='$char[0]'")->fetchAll();
	if(empty($guild[0][0])) $guild = "-";
	else $guild = $guild[0][0];
	$status = count($grizismudb->query("Select * From MEMB_STAT Where memb___id='".$_SESSION['LoggedUser']."' AND ConnectStat=1")->fetchAll());
	$last_char = count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]' AND Id='".$_SESSION['LoggedUser']."'")->fetchAll());
	if ($status > 0 && $last_char > 0){$status = "<span class='success'>On-line</span>";}
	else {$status = "<span class='error'>Off-line</span>";}
	echo "<tr><td>$char[0]</td><td>$char[1]/$char[2]</td><td>$guild</td><td>$status</td></tr>";
}
echo"</table>";
}
?>