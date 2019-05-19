<?php echo View::forge('global/header'); ?>


<div class="container text-center">
  <Br/><Br/>
    <div class="row">
      <div class="col-sm-6">
        <div style="font-size:30px;padding-top:15px; padding-bottom:15px;">K.I. Stimme</div>
      </div>
      <div class="col-sm-6">
        <form method="post">
          <button type="submit" class="btn btn-default btn-block" name="voice" value="true">
            <?php echo Hacker::get('voice_enabled') ? 'enabled' : 'disabled'; ?>
          </button>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-6"><br/>
        <h3>Passwort Ändern</h3><br/>
        <form method="post">
          <?php if (!$skipCurrentPassword): ?>
            <input type="password" class="form-control text-center" placeholder="Aktuelles Passwort" name="password"  required  maxlength="30" />
          <?php endif; ?>
          <div class="row">
            <div class="col-xs-6">
              <input type="password" class="form-control text-center" placeholder="Neues Passwort" name="new_password"  required  maxlength="30" />
            </div>
            <div class="col-xs-6">
              <input type="password" class="form-control text-center" placeholder="Bestätige das neue Passwort" name="new_password_confirm"  required  maxlength="30" />
            </div>
          </div>
          <button type="submit" class="btn btn-default btn-block" name="reset" value="true">
            Passwort Ändern
          </button>
        </form>
      </div>
    </div>
    <br/><br/>
    <h4>
      <a href="<?php echo Uri::create('welcome/logout'); ?>" class="btn btn-block">
        <i class="fa fa-power-off" aria-hidden="true"></i> Abmelden
      </a>
    </h4>
</div>

<?php echo View::forge('global/footer'); ?>
