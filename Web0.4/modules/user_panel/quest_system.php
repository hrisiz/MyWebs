<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<form method="POST">
	<select>
		<?php
			
		?>
	</select>
</form>
<p><?php print_r(Synch_Quests())?></p>