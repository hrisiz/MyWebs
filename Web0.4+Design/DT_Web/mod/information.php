<?php
	include 'configs/information.php';
?>

<div class="box">
	<div class="boxTitle">INFORMATION</div>
	<div class="boxBody" style="padding: 2px;">
		<table style="margin: 0;">
			<tbody>
			<?php
				foreach($option['information'] as $info):
			?>
			<tr>
				<td class="tdTitle">
					<?php echo $info['name']; ?>
				</td>
				<td>
					<?php echo $info['description']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>