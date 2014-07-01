<?php
// if (defined('WEB_INDEX')) {header("Location: /?page=Modules_News");}
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
	<li class="without_type">Reset Points:</li>
	<li class="without_type">DK/BK:<?=$server['Points'][17]?>/<?=$server['Points'][18]?></</li>
	<li class="without_type">ELF/ME:<?=$server['Points'][33]?>/<?=$server['Points'][34]?></</li>
	<li class="without_type">DW/SM:<?=$server['Points'][0]?>/<?=$server['Points'][1]?></li>
	<li class="without_type">MG:<?=$server['Points'][48]?></li>
</ul>