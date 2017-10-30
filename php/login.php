<div class="col-sm-4 sidenav pull-right">
  <div class="well text-center">
    <h3>Login</h3>
    <form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input id="username" type="text" class="form-control" name="username" placeholder="Username">
      </div>
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <div class="row" style="margin:auto;padding-top:1em;">
        <div class="pull-left"><label for="remember"><input type='checkbox' name="remember" id="remember">Remember me</label></div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button name="login" class="btn btn-default btn-green pull-right" type="submit">Login</button>
      </div>

    </form>
    <!--  FUTURE:implement create account and forgot password options for login -->
    <!--<div class="row" style="margin:auto;padding-top:1em;">
      <div class="pull-left">
        <a style="">Create Account</a>
      </div>
      <div class="pull-right">
        <a>forgot password</a>
      </div>

    </div>-->
  </div>
</div>
