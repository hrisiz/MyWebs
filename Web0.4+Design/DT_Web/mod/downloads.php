<?php
	include 'configs/downlods.php';
?>
<table>
	<tbody>
	<tr class="title">
		<td>NAME</td>
		<td>HOST</td>
		<td>SIZE</td>
		<td>DATE</td>
		<td>LINK</td>
	</tr>
	<?php
		foreach($option['downloads'] as $file):
	?>
	<tr>
		<td>
			<?php echo $file['name']; ?>
		</td>
		<td>
			<?php echo $file['hosted']; ?>
		</td>
		<td>
			<?php echo $file['size']; ?> MB
		</td>
		<td>
			<?php echo $file['date']; ?>
		</td>
		<td>
			<a href="<?php echo $file['link']; ?>" target="_blank"> Download</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>