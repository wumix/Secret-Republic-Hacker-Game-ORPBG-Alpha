<?php echo View::forge('emails/email-header'); ?>
<div style="text-align:center">
<p>Rufe den folgenden Link auf, um Deine E-Mail zu bestätigen und Deine Berechtigungen zu erhöhen:</p>
<p><strong><a href="<?php echo $CONFIRM_URL; ?>"><?php echo $CONFIRM_URL; ?></a></strong></p>
</div>
<?php echo View::forge('emails/email-footer'); ?>
