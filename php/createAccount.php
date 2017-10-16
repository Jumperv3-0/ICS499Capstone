<?php
	require_once 'init.php';
    require_once 'Objects.php';
    require_once 'functions.php';
    $user = new User();
    if ($user->isLoggedIn()) {
        Redirect::page('404.php');
    }
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title><?php PageBuilder::getTitle() ?></title>
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
                $pageBuilder = new RegisterPage();
                $pageBuilder->getHeader();
            ?>
		</header>
		<div class="container">
			<?php

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					if (isset($_POST['submit'])) {
                        if (Token::check(sanitizeInput($_POST['token']))) {
                            $validator = new Validation();
                            $validation = $validator->check($_POST, array(
                                'username' => array(
                                    'required' => true,
                                    'min' => 4,
                                    'max' => 22,
                                    'unique' => 'users'
                                ),
                                'password' => array(
                                    'required' => true,
                                    'min' => 6,
                                    'max' => 22
                                ),
                                'password_again' => array(
                                    'required' => true,
                                    'min' => 6,
                                    'max' => 22,
                                    'matches' => 'password'
                                ),
                                'fname' => array(
                                    'required' => true,
                                    'min' => 2,
                                    'max' => 30
                                ),
                                'lname' => array(
                                    'required' => true,
                                    'min' => 2,
                                    'max' => 30
                                ),
                                'phone' => array(
                                    'required' => true,
                                    'min' => 10,
                                    'max' => 13,
                                    'phone' => true
                                ),
                                'email' => array(
                                    'required' => true,
                                    'min' => 2,
                                    'max' => 50,
                                    'email' => true
                                ),
                                'address' => array(
                                    'required' => true,
                                    'min' => 2,
                                    'max' => 120,
                                    'address' => true
                                ),
                            ));

                            if ($validation->passed()) { // create account for user
                                $user = new User();
                                $place = new Place();
                                try {
                                     /*
                                    // TODO: Break $_POST['address'] into address, city, state, zip, country
                                    $place->create(array(

                                    ));
                                     $location_fk = '' // TODO: get place_id from query above

                                    // TODO: implement create place before uncommenting
                                    $user->create(array(
                                        sanitizeInput($_POST['username']),
                                        password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT),
                                        sanitizeInput($_POST['fname']),
                                        sanitizeInput($_POST['lname']),
                                        sanitizeInput($_POST['email']),
                                        sanitizeInput($_POST['phone']),
                                        $location_fk));
                                        */
                                } catch(Exception $e) {
                                    die ($e->getMessage());
                                }
                                Session::flash('success', 'You registered successfully!');
                                Redirect::page('index.php');
                            } else { // Display errors
                               foreach($validation->getErrors() as $error) {
                                   echo $error . "<br>";
                               }
                            }
                        }

					}
				}
			?>
			<form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post">
				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php echo (isset($_POST['username']) ? sanitizeInput($_POST['username']) : ""); ?>">
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" >
				</div>
				<div class="form-group">
					<label for="password_again">Reenter Password:</label>
					<input type="password" class="form-control" id="password_again" name="password_again">
				</div>
				<div class="form-group">
					<label for="fname">First Name:</label>
					<input type="text" class="form-control" id="fname" name="fname" value="<?php echo (isset($_POST['fname']) ? sanitizeInput($_POST['fname']) : ""); ?>">
				</div>
				<div class="form-group">
					<label for="lname">Last Name:</label>
					<input type="text" class="form-control" id="lname" name="lname" value="<?php echo (isset($_POST['lname']) ? sanitizeInput($_POST['lname']) : ""); ?>">
				</div>
				<div class="form-group">
					<label for="phone">Phone:</label>
					<input type="tel" class="form-control" id="phone" name="phone" value="<?php echo (isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : ""); ?>">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo (isset($_POST['email']) ? sanitizeInput($_POST['email']) : ""); ?>">
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<input type="text" class="form-control" id="address" name="address" value="<?php echo (isset($_POST['address']) ? sanitizeInput($_POST['address']) : ""); ?>">
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<button type="submit" class="btn btn-default" name="submit">Submit</button>
			</form>
		</div>
		<footer>
		    <?php
                PageBuilder::getFooter();
            ?>
		</footer>
	</body>

	</html>
