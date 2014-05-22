<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
if(isset($_REQUEST['race'])){
	$all_races = Array(0,1,16,17,32,33,48);
	$race = $_REQUEST['race'];
  if(!in_array($race,$all_races)){
    echo"Wrong race";
    return "";
  }
	echo"<table class=\"ranking\">
  <thead>
    <tr><th>ID</th><th>Name</th><th>LvL/Res</th><th>Class</th><th>Guild</th><th>Status</th></tr>
  </thead>
  <tbody>
  ";
	if(in_array($race ,$all_races)){
		$chars = $grizismudb->query("Select Top 100  * From Character Where Class=$race order by Resets desc,cLevel desc,Name")->fetchAll();
		$i = 1;
		$all_races_name = Array(1=>"SM",17=>"BK",33=>"ME",48=>"MG",0=>"DW",16=>"DK",32=>"Elf");
		foreach($chars as $char){
			$guild = $grizismudb->query("Select G_Name From GuildMember Where Name='".$char['Name']."'")->fetchAll();
			$status = Count($grizismudb->query("Select ConnectStat From MEMB_STAT Where memb___id='".$char["Name"]."' AND ConnectStat = 1")->fetchAll());
			$char_in_game = Count($grizismudb->query("Select * From AccountCharacter Where GameIDC='$char[0]'")->fetchAll());
			$status = "<span class='error'>Offline</span>";
			if ($status >= 1 && $char_in_game >= 1)
			{
				$status = "<span class='success'>Online</span>";
			}
			echo"<tr><td>$i</td><td><a href=\"?page=CharacterInfo&CharacterName=".$char['Name']."\">".$char['Name']."</a></td><td>".$char['cLevel']."/".$char['Resets']."</td><td>".$all_races_name[$char['Class']]."</td><td>".$guild[0]['G_Name']."</td><td>$status</td></tr>";
			$i++;
		}
	}
	echo"
  </tbody>
  </table>";
}
?>