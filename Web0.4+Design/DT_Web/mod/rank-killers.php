<table>
	<tbody>
	<tr class="title">
		<td>ID</td>
		<td>NAME</td>
		<td>CLASS</td>
		<td>KILLS</td>
		<td>PK LEVEL</td>
	</tr>
	<?php
		$query = mssql_query('SELECT TOP 100 * FROM Character WHERE PkCount > 0 ORDER BY PkCount DESC, PkLevel DESC');
		$i = 0;
		while($row = mssql_fetch_array($query)):
			$char_class = char_class($row['Class']);
			$pk_level = pk_level($row['PkLevel']);
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
			<?php echo $row['PkCount']; ?>
		</td>
		<td>
			<?php echo $pk_level; ?>
		</td>
	</tr>
	<?php endwhile; ?>
	</tbody>
</table>