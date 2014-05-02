<?php
if(isset($_POST['resetchar']))
{
	$store = do_reset_character();
	show_messages($store);
}

$zen_type = '';
if($option['rc_zen_type'] === 1)
{
	$zen_type = 'Resets * ';
}

$ppr = $option['rc_stats_per_reset'];
if($option['rc_bonus_points'] === 1)
{
	$ppr = 'SM: '. $option['rc_stats_for_sm'];
	$ppr .= ', BK: '. $option['rc_stats_for_bk'];
	$ppr .= ', ME: '. $option['rc_stats_for_me'];
	$ppr .= ', MG: '. $option['rc_stats_for_mg'];
	$ppr .= ', DL: '. $option['rc_stats_for_dl'];
}

$ppr_type = 'POINTS EVERY RESET';
if($option['rc_stats_type'] === 1)
{
	 $ppr_type = 'POINTS PER RESET';
}
?>
<form action="?p=resetcharacter" method="post">
	<ul class="form" style="width:62%;">
		<li>
			<span>Character: </span>
			<select name="character" id="character">
				<option value="">-</option>
				<?php
					$query = mssql_query("SELECT TOP 10 * FROM Character WHERE AccountID='" . $_SESSION['dt_username'] . "' ORDER BY GrandResets DESC, Resets DESC, cLevel DESC");

					while($row = mssql_fetch_array($query)):
				?>
				<option value="<?php echo $row['Name']; ?>"> <?php echo $row['Name']; ?>: [<?php echo $row['cLevel']; ?>]</option>
				<?php endwhile; ?>
			</select>
			<input  class="button" name="resetchar" type="submit" value="Reset Character" />
		</li>
	</ul>
</form>
<br />
<table>
	<tbody>
		<tr>
			<td class="tdTitle">COST</td>
			<td><?php echo $zen_type .' ' . number_format($option['rc_zen']); ?> Zen</td>
		</tr>
		<tr>
			<td class="tdTitle">LEVEL</td>
			<td><?php echo $option['rc_level']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle">MAX RESETS</td>
			<td><?php echo $option['rc_max_resets']; ?></td>
		</tr>
		<tr>
			<td class="tdTitle"><?php echo $ppr_type; ?></td>
			<td><?php echo $ppr; ?></td>
		</tr>
	</tbody>
</table>