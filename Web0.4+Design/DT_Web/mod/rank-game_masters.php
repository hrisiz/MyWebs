<?php
	include 'configs/game_masters.php';
?>
<table>
	<tbody>
	<tr class="title">
		<td>NAME</td>
		<td>RANK</td>
		<td>SKYPE</td>
		<td>STATUS</td>
	</tr>
	<?php
		foreach($option['game_masters'] as $gm):
			$is_online = @is_online($gm['name']);
			$status = 'Offline';
			if($is_online === 1)
			{
				$status = 'Online';
			}
	?>
	<tr>
		<td>
			<?php echo $gm['name']; ?>
		</td>
		<td>
			<?php echo $gm['rank']; ?>
		</td>
		<td>
			<?php if(!empty($gm['skype'])): ?>
				<a href="skype:<?php echo $gm['skype']; ?>?chat"><?php echo $gm['skype']; ?></a>
			<?php else: ?>
			 - - - - -
			<?php endif; ?>
		</td>
		<td>
			<?php echo $status; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>