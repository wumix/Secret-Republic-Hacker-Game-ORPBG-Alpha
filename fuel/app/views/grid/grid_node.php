<?php echo View::forge('global/header'); ?>

<form method="post">
  <div class="row">

  </div>
</form>
<div class="container">
  <?php echo View::forge('components/modal', array('id' => 'rename', 'title' => 'Rename', 'content' => View::forge('grid/grid_rename', array('name' => $node['name'])))); ?>

  <a data-toggle="modal" data-target="#rename"><?php echo $node['name']; ?></a>

  <?php print_R($node); ?>
</div>

<?php echo View::forge('global/footer'); ?>
