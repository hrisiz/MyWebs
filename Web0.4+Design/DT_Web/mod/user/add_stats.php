<?php
if(isset($_POST['addstats']))
{
	$store = do_add_stats();
	show_messages($store);
}
$has_dl = 'class="hide"';
if($option['has_dl'] === 1)
{
	$has_dl = '';
}
?>
<form action="?p=addstats" method="post">
	<ul class="form" style="width:62%;">
		<li>
			<label for="character">Character: </label>
			<select name="character" id="character">
				<option value="">-</option>
				<?php
					$query = mssql_query("SELECT TOP 10 * FROM Character WHERE AccountID='" . $_SESSION['dt_username'] . "' ORDER BY GrandResets DESC, Resets DESC, cLevel DESC");

					while($row = mssql_fetch_array($query)):
				?>
				<option value="<?php echo $row['Name']; ?>"> <?php echo $row['Name']; ?>: [<?php echo $row['LevelUpPoint']; ?>]</option>
				<?php endwhile; ?>
			</select>
		</li>
		<li>
			<label for="str">Strength: </label>
			<input id="str" name="str" type="text" value="0" maxlength="5" />
		</li>
		<li>
			<label for="vit">Vitality: </label>
			<input id="vit" name="vit" type="text" value="0" maxlength="5" />
		</li>
		<li>
			<label for="agi">Agility: </label>
			<input id="agi" name="agi" type="text" value="0" maxlength="5" />
		</li>
		<li>
			<label for="ene">Energy: </label>
			<input id="ene" name="ene" type="text" value="0" maxlength="5" />
		</li>
		<li <?php echo $has_dl; ?>>
			<label for="com">Command: </label>
			<input id="com" name="com" type="text" value="0" maxlength="5" />
		</li>
		<li class="buttons">
			<input name="addstats" type="submit" value="Add Stats" />
			<input type="reset" value="Clear" />
		</li>
	</ul>
</form>
<br />
<table>
	<tbody>
		<tr class="title">
			<td>MAX STATS</td>
		</tr>
		<tr>
			<td><?php echo $option['as_max_stats']; ?></td>
		</tr>
	</tbody>
</table>