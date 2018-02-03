<?php echo View::forge('global/header'); ?>

<form method="post">
  <div class="row">

  </div>
</form>
<div class="container">
  <?php foreach($nodes as $n): ?>
    <div>
      <a href="<?php echo Uri::create('grid/main/' . $n['node_id']); ?>"><?php echo $n['name']; ?> - Z<?php echo $n['zone']; ?> - C<?php echo $n['cluster']; ?></a>
    </div><br/>
  <?php endforeach; ?>
</div>

<?php echo View::forge('global/footer'); ?>
