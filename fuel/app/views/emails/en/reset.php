<?php echo View::forge('emails/email-header'); ?>
<div style="text-align:center">
<p>Access the following link in order to reset your password:</p>
<p><strong><a href="<?php echo $RESET_URL; ?>"><?php echo $RESET_URL; ?></a></strong></p>
</div>
<?php echo View::forge('emails/email-footer'); ?>
