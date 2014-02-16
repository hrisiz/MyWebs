
<?php
$path_parts = pathinfo(__FILE__);
preg_match("/".$path_parts['basename']."/", $_SERVER['SCRIPT_NAME'], $matches);
if (!empty($matches[0])){header("Location: /?page=News");}
?>
<ul class="information">
	<li class="without_type">Name:<?=$server['Name']?></li>
	<li class="without_type">Version:<?=$server['Version']?></li>
	<li class="without_type">Experience:<?=$server['Experience']?></li>
	<li class="without_type">Drop:<?=$server['Drop']?></li>
	<li class="without_type">Max Level:<?=$server['MaxLevel']?></li>
	<li class="without_type">Max Resets:<?=$server['MaxResets']?></li>
	<li class="without_type">Bonus points for every bigger level than 340 : <?=$server['BonusPointsPerLevel']?> Points</li>
	<li class="without_type">Reset Zen:<?=number_format($server['ZenForReset'])?>Zen</li>
	<li class="without_type">Reset Level:<?=$server['ResetLevel']?></li>
	
	<li class="without_type"><h3>Reset Points</h3></li>
	<li class="without_type">DK AND BK Points:<?=$server['BKPoints']?></li>
	<li class="without_type">ELF AND ME Points:<?=$server['MEPoints']?></li>
	<li class="without_type">DW AND SM Points:<?=$server['SMPoints']?></li>
	<li class="without_type">MG Points:<?=$server['MGPoints']?></li>
</ul>