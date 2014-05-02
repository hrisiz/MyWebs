<?php
if(isset($_POST['greset']))
{
	$store = do_grand_reset();
	show_messages($store);
}
?>
<form action="?p=grandreset" method="post">
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
			<input  class="button" name="greset" type="submit" value="Reset Character" />
		</li>
	</ul>
</form>
<br />
<table>
	<tbody>
		<tr>
			<td class="tdTitle">COST</td>
			<td><?php echo number_format($option['gr_zen']); ?> Zen</td>
		</tr>
		<tr>
			<td class="tdTitle">LEVEL</td>
			<td><?php echo $option['gr_level']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle">RESETS</td>
			<td><?php echo $option['gr_resets']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle">MAX GRAND RESETS</td>
			<td><?php echo $option['gr_max_resets']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle">REWARD</td>
			<td><?php echo $option['gr_reward']; ?> <?php echo $option['gr_reward_name']; ?></td>
		</tr>
	</tbody>
</table>