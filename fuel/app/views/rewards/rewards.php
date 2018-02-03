<?php echo View::forge('global/header'); ?>

<div class="container">
	<?php if (!$rewards): ?>
		<div class="alert alert-info text-center">
			You have not earned any rewards yet. Get to it already!
		</div>
	<?php endif; ?>
<?php foreach($rewards as $reward): ?>
	<div class="well">
		<a href="<?php echo Uri::create('rewards/reward/' . $reward['reward_id']); ?>">
				<strong><i class="fa fa-gift" aria-hidden="true"></i> <?php echo $reward['title']; ?> <?php echo $reward['claimed'] ? '' : '[CLAIM NOW] ';?></strong><br/>
				<small>
					received <?php echo $reward['created_at']; ?>
				</small>
		</a>
	</div>
<?php endforeach; ?>
			<?php echo View::forge('components/pagination')->set_safe('pagination', $pagination); ?>
</div>
<?php echo View::forge('global/footer'); ?>
