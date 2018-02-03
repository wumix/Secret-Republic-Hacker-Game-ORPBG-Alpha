<?php use \Model\Train; ?>
<?php echo View::forge('global/header'); ?>
<?php
$shapes = array(0 => 'Square', 1 => 'Circle', 2 => 'Triangle');
?>
<div class="container">

	<div class="row text-center">
		<?php foreach(Train::types() as $train_id => $t): ?>
			<div class="col-md-12">
				<h3><?php echo $t['name']; ?> training</h3><br/>
				<?php echo View::forge('components/progress-bar', array('type' => $shapes[$train_id % 3], 'current' => $train[$train_id]['exp'] / ($train[$train_id]['exp_next'] / 100), 'max_width' => '150px', 'id' => $train_id, 'text' => 'L' . $train[$train_id]['level'])); ?>
				<br/>
				<p>
				 <?php echo $train[$train_id]['exp']; ?>/<?php echo $train[$train_id]['exp_next']; ?>
				</p>
				<?php if ($train[$train_id]['wait']): ?>
wait <?php echo number_format($train[$train_id]['wait']);?> seconds
				<?php else: ?>
					<form method="post">
						<button type="submit" class="btn btn-default" name="train_type" value="<?php echo $train_id; ?>">
							train
						</button>
					</form>
				<?php endif; ?>
			</div>

		<?php endforeach; ?>

	</div>
</div>

<?php echo View::forge('global/footer'); ?>
