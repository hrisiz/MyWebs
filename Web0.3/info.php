
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<ol>
	<li class="info">Server:<span class="info"><?=$server['Stats']; ?></span></li>
	<li class="info">Version:<span class="info"><?=$server['Version']; ?></span></li>
	<li class="info">Experience:<span class="info"><?=$server['Experience']; ?></span></li>
	<li class="info">Drop:<span class="info"><?=$server['Drop']; ?></span></li>
	<li class="info">Accounts:<span class="info"><?=$server['Accounts']; ?></span></li>
	<li class="info">Characters:<span class="info"><?=$server['Characters']; ?></span></li>
	<li class="info">Guilds:<span class="info"><?=$server['Guilds']; ?></span></li>
	<li class="info">Online:<span class="info"><?=$server['Online_Players']; ?></span></li>
</ol>