<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bootstrap Website Tutorial</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>

<body>
	<header>
		<?php
			include 'getNavBar.php';
			getNavBar();
		?>
	</header>

	<!--TODO: fill in info paragraph with details-->
	<div class="container">
		<div class="col-sm-8 text-left">
			<h1>Welcome</h1>
			<p>Paragraph about us!</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			<hr>
		</div>
		<div class="col-sm-4 sidenav">
			<div class="well text-center">
				<h3>Login</h3>
				<form action="#" method="post">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="username" type="text" class="form-control" name="username" placeholder="Username">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" type="password" class="form-control" name="password" placeholder="Password">
					</div>
					<button class="btn btn-default btn-login pull-right" type="submit">Login</button>
					<span class="clearfix"></span>
				</form>
			</div>
			<!--FUTURE: dynamic list of sales near your or searched for items?-->
		</div>
	</div>
	<div class="container">
		<div class="well">
			<h3>Sales Near You</h3>
			<ul class="list-group">
				<li data-toggle="collapse" href="#collapse1" class="list-group-item">
					<h5 class="collapse-header">Location:</h5>
					<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
					<span class="caret dropdown-caret pull-right"></span>
					<p id="collapse1" class="collapse">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</li>
				<li data-toggle="collapse" href="#collapse2" class="list-group-item">
					<h5 class="collapse-header">Location:</h5>
					<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
					<span class="caret dropdown-caret pull-right"></span>
					<p id="collapse2" class="collapse">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</li>
				<li data-toggle="collapse" href="#collapse3" class="list-group-item">
					<h5 class="collapse-header">Location:</h5>
					<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
					<span class="caret dropdown-caret pull-right"></span>
					<p id="collapse3" class="collapse">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</li>
				<li data-toggle="collapse" href="#collapse4" class="list-group-item">
					<h5 class="collapse-header">Location:</h5>
					<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
					<span class="caret dropdown-caret pull-right"></span>
					<p id="collapse4" class="collapse">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</li>
			</ul>
		</div>
	</div>
	<!--TODO: fill in contact info-->
	<footer>
		<div class="container text-center">
			<h4>Contact Us</h4>
			<div>
				<div class="contact-info">Phone Number: <span class="glyphicon glyphicon-earphone"></span></div>
				<div class="contact-info">Email Address: <span class="glyphicon glyphicon-envelope"></span></div>
			</div>
		</div>

	</footer>

</body>

</html>
