<?php
if (!defined('WEB_INDEX')){header("Location: /?page=News");}
?>
<table class="ranking" id="download">
	<tr><th>FileName</th><th>Link</th><th>Size</th></tr>
	<?php
		for ($i = 0;$i < count($link);$i++)
		{
			echo "<tr><td>".$link[$i]['File_Name']."</td><td><a href=\"".$link[$i]['Link']."\">Click</a></td><td>".$link[$i]['Size']."</td></tr>";
		}
	?>
</table>