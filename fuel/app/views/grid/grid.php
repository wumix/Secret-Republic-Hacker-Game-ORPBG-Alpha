<?php echo View::forge('global/header'); ?>

<form method="post">
  <div class="row">

  </div>
</form>
<div class="container">
  <?php foreach($nodes as $k => $n): ?>
    <div class="">
      Node <?php echo $k; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php echo View::forge('global/footer'); ?>
