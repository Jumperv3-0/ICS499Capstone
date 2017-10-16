<?php
    require_once 'init.php';
	include_once 'Objects.php';
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>
			<?php PageBuilder::getTitle() ?>
		</title>
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
                $pageBuilder = new IndexPage();
                $pageBuilder->getHeader();
            ?>
		</header>
        <?php
            if (Session::exists('success')) {
                echo '<div class="container">' . Session::flash('success') . '</div>';
            }
        ?>
		<div class="container">
			<div class="col-sm-8 text-left">
				<h1>Welcome</h1>
				<p>Paragraph about us!</p>
				<p>We At G=Sale have a simple goal. That goal is to help connect those wishing to sell their unneeded possessions to those who are looking for deals cutting out the middleman. A trade between neighbors. You might be hard on for cash. Or your looking to unburden yourself with unnecessary things you have gathered over the years. Regardless of your sepenstance you can create an account and set up your garage sale for free! Or maybe you are looking for a old, no longer sold in stores item. or you just want to save some cash picking up a hand me down dresser. You don't need an account just simply check out our Sales page to find garage that are live near you. Or you can search by specific keyword if you already know what you're looking for.</p>
				<hr>
			</div>
			<div class="col-sm-4 sidenav">
			    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['login'])) {
                            if (Token::check(sanitizeInput($_POST['token']))) {
                                $validator = new Validation();
                                $validation = $validator->check($_POST, array(
                                    'username' => array('required' => true),
                                    'password' => array('required' => true)));
                                if ($validation->passed()) {  // input is valid
                                    $user = new User();
                                    $login = $user->login(sanitizeInput($_POST['username']), sanitizeInput($_POST['password']));
                                    if ($login) {
                                        Redirect::page('yourSales.php');
                                    } else {
                                        echo "Login failed.";
                                    }
                                } else {
                                    foreach($validation->getErrors() as $error) {
                                        echo $error . '<br>';
                                    }
                                }
                            }
                        }
                    }
                ?>
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
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<button name="login" class="btn btn-default btn-login pull-right" type="submit">Login</button>
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

		<footer>
		    <?php
                PageBuilder::getFooter();
            ?>
		</footer>
	</body>

	</html>
