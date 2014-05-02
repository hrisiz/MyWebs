<?php
	include 'configs/hall_of_fame.php';
	$id = 0;
	foreach($option['halloffame'] as $hof):
	$id++;
?>
<div class="box inline_box">
	<div class="boxTitle pointer normal_caps" onclick="show_id(<?php echo $id; ?>);">
		<b class="pointer"><?php echo $hof['name']; ?></b> <i class="pointer"><?php echo $hof['class']; ?></i>
	</div>
	<div class="hide" id="show_id-<?php echo $id; ?>">
		<div class="boxBody">
			<img style="border:1px solid #000;" src="imgs/hof/<?php echo $hof['image']; ?>" alt=""/>
		</div>
		<div class="boxFooter">
			<?php echo $hof['information']; ?>
		</div>
	</div>
</div>
<?php endforeach; ?>