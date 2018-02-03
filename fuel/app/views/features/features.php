<?php echo View::forge('global/header'); ?>

<div class="container">
  <?php print_r($node_features); ?>
  <?php foreach($features as $f_id => $f): $nf = $node_features[$f_id]; ?>
    <div class="well">
      <?php echo $f['name']; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php echo View::forge('global/footer'); ?>
