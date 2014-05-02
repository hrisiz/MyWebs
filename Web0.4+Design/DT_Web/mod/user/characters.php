<?php
	$query = mssql_query("SELECT TOP 10 * FROM Character WHERE AccountID='" . $_SESSION['dt_username'] . "' ORDER BY GrandResets DESC, Resets DESC, cLevel DESC");

	while($row = mssql_fetch_array($query)):
		$char_class = char_class($row['Class']);
		$pk_level = pk_level($row['PkLevel']);
?>
<table>
	<tbody>
		<tr class="title">
			<td>NAME</td>
			<td>CLASS</td>
			<td>LEVEL</td>
			<td>RESETS</td>
			<td>GRESETS</td>
			<td>PK</td>
		</tr>
		<tr>
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
			<td>
				<?php echo $row['GrandResets']; ?>
			</td>
			<td>
				<?php echo $pk_level; ?>
			</td>
		</tr>
		<tr class="title">
			<td>STRENGTH</td>
			<td>VITALITY</td>
			<td>AGILITY</td>
			<td>ENERGY</td>
			<td>POINTS</td>
			<td>ZEN</td>
		</tr>
		<tr>
			<td>
				<?php echo $row['Strength']; ?>
			</td>
			<td>
				<?php echo $row['Vitality']; ?>
			</td>
			<td>
				<?php echo $row['Dexterity']; ?>
			</td>
			<td>
				<?php echo $row['Energy']; ?>
			</td>
			<td>
				<?php echo $row['LevelUpPoint']; ?>
			</td>
			<td>
				<?php echo number_format($row['Money']); ?>
			</td>
		</tr>
	</tbody>
</table>
<?php endwhile; ?>