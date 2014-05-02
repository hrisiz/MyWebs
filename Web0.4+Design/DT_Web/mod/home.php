<?php
	include 'configs/news.php';
	$id = 0;
	foreach($option['news'] as $news):
	$id++;
?>
<div class="box">
	<div class="boxTitle pointer" onclick="show_id(<?php echo $id; ?>);"><?php echo $news['name']; ?></div>
	<div class="boxBody hide" id="show_id-<?php echo $id; ?>">
		<?php echo $news['description']; ?>
	</div>
</div>
<?php endforeach; ?>