<?php echo View::forge('global/header'); ?>


<div class="container">
  <div class="alert alert-info text-center">
    <p>Der Weltstaat wurde Ende 2016 zurückgesetzt.</p>
    Die vorherige Version des Wettbewerbs lief von 2012 bis 2016 mit über 13.000 Teilnehmern.
  </div>
  <div class="row text-center">
    <?php foreach ($data as $d): ?>
      <div class="col-sm-4">
        <h1><?php echo number_format($d['value']); ?></h1>
        <h3><?php echo html_entity_decode(strtolower($d['title'])); ?></h3>
        <p><?php echo html_entity_decode($d['description']); ?></p>
        <br/>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php echo View::forge('global/footer'); ?>
