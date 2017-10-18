<div class="col-sm-4 sidenav">
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
			<label for="remember">
                <input type='checkbox' name="remember" id="remember">Remember me
              </label>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<button name="login" class="btn btn-default btn-login pull-right" type="submit">Login</button>
			<span class="clearfix"></span>
		</form>
	</div>
</div>
