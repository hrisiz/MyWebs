<table>
	<tbody>
	<tr class="title">
		<td>ID</td>
		<td>NAME</td>
		<td>MASTER</td>
		<td>SCORE</td>
		<td>MEMBERS</td>
	</tr>
	<?php
		$query = mssql_query('SELECT TOP 100 * FROM Guild ORDER BY G_Score DESC');
		$i = 0;
		while($row = mssql_fetch_array($query)):
		$total_members = mssql_num_rows(
			mssql_query("SELECT G_Name FROM GuildMember WHERE G_Name='". $row['G_Name'] ."'")
		);
		$i++;
	?>
	<tr>
		<td>
			<?php echo $i; ?>
		</td>
		<td>
			<?php echo $row['G_Name']; ?>
		</td>
		<td>
			<?php echo $row['G_Master']; ?>
		</td>
		<td>
			<?php echo $row['G_Score']; ?>
		</td>
		<td>
			<?php echo $total_members; ?>
		</td>
	</tr>
	<?php endwhile; ?>
	</tbody>
</table>