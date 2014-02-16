<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<a href="?page=Rankings&subpage=Races&race=1"><button>Soul Master</button></a>
<a href="?page=Rankings&subpage=Races&race=17"><button>Blade Knight</button></a>
<a href="?page=Rankings&subpage=Races&race=33"><button>Muse Elf</button></a>
<a href="?page=Rankings&subpage=Races&race=48"><button>Magic Gladiator</button></a><br>
<a href="?page=Rankings&subpage=Races&race=0"><button>Dark Wizard</button></a>
<a href="?page=Rankings&subpage=Races&race=16"><button>Dark Knight</button></a>
<a href="?page=Rankings&subpage=Races&race=32"><button>Elf</button></a>
<?php
if(isset($_GET['race'])){
	$all_races = Array(0,1,16,17,32,33,48);
	$race = $_GET['race'];
	echo"<table class=\"ranking\">
	<tr><th>ID</th><th>Name</th><th>LvL/Res</th><th>Class</th><th>Guild</th><th>Status</th></tr>";
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
	echo"</table>";
}
?>