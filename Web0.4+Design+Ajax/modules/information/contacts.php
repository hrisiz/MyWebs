<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="information">
<tr><th>Name</th><th>Title</th><th>Skype</th></tr>
<?php
foreach($grizismudb->query("Select Name,Skype From Character Where CtlCode = 8") as $admin)
{
	if ($admin[0] == "Admin")
	{
		$class = "Owner";
	}
	else
	{
		$class = "Game Master";
	}
	print "<tr><td>$admin[0]</td><td>$class</td><td><a href=\"skype:$admin[1]?add\">$admin[1]</a></td></tr>";
}
?>
</table><br><br><br>
<p>E-Mail:grizismu@abv.bg</p>
