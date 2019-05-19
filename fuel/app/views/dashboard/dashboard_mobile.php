<?php echo View::forge('global/header'); ?>

  <div class="row">
    <div class="col-md-3"></div>
      <div class="col-md-6">
	<div class="text-center">
    <h1><a href="<?php echo Uri::create('hacker/access/' . Hacker::get('username')); ?>"><?php echo Hacker::get('username'); ?></a></h1>
	<h4>LEVEL <?php echo Hacker::get('level'); ?></h4>
  <h5>Platzierung #<?php echo number_format(Hacker::get('ranking')); ?></h5><br/><br/>
  <div style="max-width:200px; display:inline-block">
	<?php echo View::forge('components/progress-bar', array(
		'current' => Hacker::get('experience') / (Hacker::experience(Hacker::get('level') + 1) / 100),
		'type' => 'SemiCircle',
		'text' => Hacker::get('experience') . ' / ' . Hacker::experience(Hacker::get('level') + 1),
		'id' => 'exp_container'
		)); ?>

</div>
</div>
<br/><br/>
<?php if (Hacker::check() && !Hacker::email_confirmed()): ?>
  <div class="alert alert-warning">
   Bitte bestätige deine Anmeldung und klicke auf den Link, den wir dir per E-MAIL gesendet haben. <a href="<?php echo Uri::create('welcome/resend'); ?>">Resend</a>?
  </div>
<?php endif; ?>
<?php /*if (!Hacker::get('q_answer')): ?>
<div class="alert alert-info text-center">
  Bist du daran interessiert, dem Team als Missionsdesigner beizutreten? <a href="<?php echo Uri::create('dashboard/answer/1'); ?>">yes</a> / <a href="<?php echo Uri::create('dashboard/answer/2'); ?>">no</a><br/>
  <small>Es werden keine Programmierkentnisse benötigt - Du musst alle CS Missionen beendet haben. <br/> Benutze den Feedback Abschnitt und erzähle uns mehr über dich und deine Idee für deine Mission.</small>
</div>
<?php endif;*/ ?>
<br/>
<blockquote>
  <?php echo $quote['content']; ?>
  <?php if ($quote['author']): ?>
    <small><?php echo $quote['author']; ?></small>
  <?php endif; ?>
</blockquote>
<div class="text-center">
<a href="<?php echo Uri::create('feedback'); ?>" class="btn btn-default"><i class="fa fa-smile-o" aria-hidden="true"></i> feedback</a>
<a href="<?php echo Uri::create('world'); ?>" class="btn btn-default">Welt <i class="fa fa-globe" aria-hidden="true"></i></a>
</div><br/>
<div class="alert alert-info text-center">
  Aktueller Alfa<strong>test</strong>. Sende uns so oft du möchtest konstruktives <strong>feedback</strong>!
</div>
<br/>
<h1 class="text-center">
<a href="https://www.facebook.com/theSecretRepublic" target=""><i class="fa fa-facebook"></i></a>&nbsp;&nbsp;&nbsp;
<a href="https://twitter.com/iSecretRepublic" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp;&nbsp;&nbsp;
<a href="https://www.youtube.com/user/TheSecretRepublicCom/" target="_blank"><i class="fa fa-youtube"></i></a>
<!--
<Br/>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1605215473026750";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="https://www.facebook.com/theSecretRepublic" data-layout="button_count" data-action="like"  data-show-faces="true" data-share="true"></div>
--></h1>
<!--
<br/>
<div class="row">
  <div class="col-xs-3"></div><div class="col-xs-6">
<div class="videoWrapper">
<iframe width="560" height="315" src="https://www.youtube.com/embed/CGRYzLb7FEw?list=PLHxmav9PZJKaiBGqv_2gOxpGhKmtY3j7V" frameborder="0" allowfullscreen></iframe>
</div>
</div>
</div>-->
</div>
</div>
<?php echo View::forge('global/footer'); ?>
