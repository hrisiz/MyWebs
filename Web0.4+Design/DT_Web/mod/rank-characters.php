<table>
	<tbody>
	<tr class="title">
		<td>ID</td>
		<td>NAME</td>
		<td>CLASS</td>
		<td>LEVEL</td>
		<td>RESETS</td>
	</tr>
	<?php
		$query = mssql_query('SELECT TOP 100 * FROM Character ORDER BY Resets DESC, cLevel DESC');
		$i = 0;
		while($row = mssql_fetch_array($query)):
			$char_class = char_class($row['Class']);
			$i++;
	?>
	<tr>
		<td>
			<?php echo $i; ?>
		</td>
		<td>
			<?php echo $row['Name']; ?>
		</td>
		<td>
			<?php echo $char_class; ?>
		</td>
		<td>
			<?php echo $row['cLevel']; ?>
		</td>
		<td>
			<?php echo $row['Resets']; ?>
		</td>
	</tr>
	<?php endwhile; ?>
	</tbody>
</table>