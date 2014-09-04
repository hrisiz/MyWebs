<?php
  // if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
?>
<table class="ranking" id="download">
  <thead>
    <tr><th>FileName</th><th>Link</th><th>Size</th></tr>
  </thead>
	<?php
		for ($i = 0;$i < count($link);$i++)
		{
			echo "<tr><td>".$link[$i]['File_Name']."</td><td><a href=\"".$link[$i]['Link']."\">".$link[$i]['Link_Name']."</a></td><td>".$link[$i]['Size']."</td></tr>";
		}
	?>
</table>