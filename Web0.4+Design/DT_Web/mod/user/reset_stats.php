<?php
if(isset($_POST['resetst']))
{
	$store = do_reset_stats();
	show_messages($store);
}
?>
<form action="?p=resetstats" method="post">
	<ul class="form" style="width:67%;">
		<li>
			<span>Character: </span>
			<select name="character" id="character">
				<option value="">-</option>
				<?php
					$query = mssql_query("SELECT TOP 10 * FROM Character WHERE AccountID='" . $_SESSION['dt_username'] . "' ORDER BY GrandResets DESC, Resets DESC, cLevel DESC");

					while($row = mssql_fetch_array($query)):
				?>
				<option value="<?php echo $row['Name']; ?>"> <?php echo $row['Name']; ?>: [<?php echo $row['cLevel']; ?>][<?php echo $row['Resets']; ?>]</option>
				<?php endwhile; ?>
			</select>
			<input  class="button" name="resetst" type="submit" value="Reset Character" />
		</li>
	</ul>
</form>
<br />
<table>
	<tbody>
		<tr>
			<td class="tdTitle">COST</td>
			<td><?php echo number_format($option['rs_zen']); ?> Zen</td>
		</tr>
		<tr>
			<td class="tdTitle">LEVEL</td>
			<td><?php echo $option['rs_level']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle">RESETS</td>
			<td><?php echo $option['rs_resets']; ?></td>
		</tr>
	</tbody>
</table>