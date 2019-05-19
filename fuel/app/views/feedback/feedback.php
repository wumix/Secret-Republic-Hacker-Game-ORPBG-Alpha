<?php echo View::forge('global/header'); ?>


<div class="container text-center">
  <div class="well">
    Wir führen derzeit eine Alpha-Testphase durch. Bitte teile uns deine Probleme oder Vorschläge mit!
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
  <form method="post">
    <textarea class="form-control" name="message" placeholder="Feedback"></textarea>
    <button class="btn btn-default btn-block" type="submit">feedback Senden</button>
  </form>
</div>
</div>
</div>

<?php echo View::forge('global/footer'); ?>
