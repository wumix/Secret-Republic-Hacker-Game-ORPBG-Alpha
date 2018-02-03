<?php echo View::forge('emails/email-header'); ?>
<div style="text-align:center">
<p>Access the following link in order to verify your email and escalate your privileges:</p>
<p><strong><a href="<?php echo $CONFIRM_URL; ?>"><?php echo $CONFIRM_URL; ?></a></strong></p>
</div>
<?php echo View::forge('emails/email-footer'); ?>
