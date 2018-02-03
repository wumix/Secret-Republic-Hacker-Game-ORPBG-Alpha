<?php echo View::forge('global/header', array('messages_handled' => true)); ?>

<div class="container">
  <div class="row">
  	<div class="col-md-3"></div>
  	<div class="col-md-6 text-center">
      <br/><br/>
  		<form method="post">
  			<input type="email" class="form-control text-center" placeholder="email" name="email" autocapitalize="off" autocorrect="off" required />
  			<button class="btn btn-block btn-default" type="submit"name="connect" value="true">process</button>
  		</form>
    </div>
  </div>
</div>


<?php echo View::forge('global/footer'); ?>
