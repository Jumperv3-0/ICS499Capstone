<?php
  require_once 'init.php';
	require_once 'Objects.php';
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
      } else if (Session::exists('logout')) {
          echo '<div class="container">' . Session::flash('logout') . '</div>';
      }
    ?>
			<div class="container top-container">
				<div class="row">
					<div class="col-sm-<?php $user = new User(); echo ($user->isLoggedIn())? 12 : 8; ?> text-left">
						<h1>Welcome</h1>
						<p>Paragraph about us!</p>
						<p>We At G=Sale have a simple goal. That goal is to help connect those wishing to sell their unneeded possessions to those who are looking for deals cutting out the middleman. A trade between neighbors. You might be hard on for cash. Or your looking to unburden yourself with unnecessary things you have gathered over the years. Regardless of your sepenstance you can create an account and set up your garage sale for free! Or maybe you are looking for a old, no longer sold in stores item. or you just want to save some cash picking up a hand me down dresser. You don't need an account just simply check out our Sales page to find garage that are live near you. Or you can search by specific keyword if you already know what you're looking for.</p>
						<hr>
					</div>
					<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['token'])) {
                if (Token::check(sanitizeInput($_POST['token']))) {
                    $validator = new Validation();
                    $validation = $validator->check($_POST, array(
                        'username' => array('required' => true),
                        'password' => array('required' => true)));
                    if ($validation->passed()) {  // input is valid
                        var_dump($_POST);
                        $user = new User();
                        $remember = (isset($_POST['remember'])) ? true : false;
                        $login = $user->login(sanitizeInput($_POST['username']), sanitizeInput($_POST['password']), $remember);
                        var_dump($login);
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
					if (!$user->isLoggedIn()) {
						include 'login.php';
					}
        ?>
				</div>
			</div>
			<div class="container">
				<h3>Near You</h3>
				<div class="panel-group">
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse1">
							<h4 class="panel-title">
								<h5 class="collapse-header">Location:</h5>
								<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
								<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
							</h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row text-center">
									<a class="" href="#">Name: Bob's Bouncy House</a>
								</div>
								<div class="row">
									<div class="col-sm-2">
										<img src="http://lorempixel.com/100/100/nightlife">
									</div>
									<div class="col-sm-4">
										<h5 class="collapse-header">Date:</h5>
										<p>Mon, Oct 16 - Sun, Oct 19</p>
									</div>
									<div class="col-sm-5">
										<h5 class="collapse-header">Description:</h5>
										<p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse2">
							<h4 class="panel-title">
								<h5 class="collapse-header">Location:</h5>
								<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
								<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
							</h4>
						</div>
						<div id="collapse2" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row text-center">
									<a class="" href="#">Name: Bob's Bouncy House</a>
								</div>
								<div class="row">
									<div class="col-sm-2">
										<img src="http://lorempixel.com/100/100/nightlife">
									</div>
									<div class="col-sm-4">
										<h5 class="collapse-header">Date:</h5>
										<p>Mon, Oct 16 - Sun, Oct 19</p>
									</div>
									<div class="col-sm-5">
										<h5 class="collapse-header">Description:</h5>
										<p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse3">
							<h4 class="panel-title">
								<h5 class="collapse-header">Location:</h5>
								<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
								<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
							</h4>
						</div>
						<div id="collapse3" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row text-center">
									<a class="" href="#">Name: Bob's Bouncy House</a>
								</div>
								<div class="row">
									<div class="col-sm-2">
										<img src="http://lorempixel.com/100/100/nightlife">
									</div>
									<div class="col-sm-4">
										<h5 class="collapse-header">Date:</h5>
										<p>Mon, Oct 16 - Sun, Oct 19</p>
									</div>
									<div class="col-sm-5">
										<h5 class="collapse-header">Description:</h5>
										<p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse4">
							<h4 class="panel-title">
								<h5 class="collapse-header">Location:</h5>
								<p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
								<span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
							</h4>
						</div>
						<div id="collapse4" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row text-center">
									<a class="" href="#">Name: Bob's Bouncy House</a>
								</div>
								<div class="row">
									<div class="col-sm-2">
										<img src="http://lorempixel.com/100/100/nightlife">
									</div>
									<div class="col-sm-4">
										<h5 class="collapse-header">Date:</h5>
										<p>Mon, Oct 16 - Sun, Oct 19</p>
									</div>
									<div class="col-sm-5">
										<h5 class="collapse-header">Description:</h5>
										<p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<footer>
				<?php
      PageBuilder::getFooter();
      ?>
			</footer>
	</body>

	</html>
	<?php
  ob_start();
?>
