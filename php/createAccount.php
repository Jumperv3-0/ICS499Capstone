<?php
require_once 'init.php';
require_once 'Objects.php';
require_once 'functions.php';
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
      $pageBuilder = new RegisterPage();
      $pageBuilder->getHeader();
    ?>
		</header>

		<div class="container">
			<h1>Create Account</h1>
			<?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {                // check to see a form was submited by $_POST
        if (isset($_POST['submit'])) {                         // check to see if data was submitted
          if (Token::check(sanitizeInput($_POST['token']))) {// protects agains resumitting form multiple times
            $validator = new Validation();                  // creates new validation object
            $validation = $validator->check($_POST, array(  // calles check function giving it submit type and an array of rules
              'username' => array(        // rules for username
                'required' => true,     // cant be empty
                'min' => 4,             // min length is 4 char
                'max' => 22,            // max length is 22 char
                'unique' => 'users'     // username must be unique in users table
              ),
              'password' => array(
                'required' => true,
                'min' => 6,
                'max' => 22
              ),
              'password_again' => array(
		'name' => "Password Again",
                'required' => true,
                'min' => 6,
                'max' => 22,
                'matches' => 'password' // password_again must match password
              ),
              'fname' => array(
		'fname' => "First Name",
                'required' => true,
                'min' => 2,
                'max' => 30
              ),
              'lname' => array(
		'fname' => "Last Name",
                'required' => true,
                'min' => 2,
                'max' => 30
              ),
              'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'email' => true         // must be an email
              )
            ));

            if ($validation->passed()) {  // all inputs valid
              $user = new User();       // get current user
              try {
                $user->create(array(
                  sanitizeInput($_POST['username']),
                  password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT),
                  sanitizeInput($_POST['fname']),
                  sanitizeInput($_POST['lname']),
                  sanitizeInput($_POST['email'])
                ));
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
						<input type="text" class="form-control" id="username" name="username" value="<?php echo (isset($_POST['username']) ? sanitizeInput($_POST['username']) : ''); ?>" placeholder="Enter your username you will use it to login">
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
					</div>
					<div class="form-group">
						<label for="password_again">Reenter Password:</label>
						<input type="password" class="form-control" id="password_again" name="password_again" placeholder="Enter your password again">
					</div>
					<div class="form-group">
						<label for="fname">First Name:</label>
						<input type="text" class="form-control" id="fname" name="fname" value="<?php echo (isset($_POST['fname']) ? sanitizeInput($_POST['fname']) : ''); ?>" placeholder="Enter your first name">
					</div>
					<div class="form-group">
						<label for="lname">Last Name:</label>
						<input type="text" class="form-control" id="lname" name="lname" value="<?php echo (isset($_POST['lname']) ? sanitizeInput($_POST['lname']) : ''); ?>" placeholder="Enter your last name">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" value="<?php echo (isset($_POST['email']) ? sanitizeInput($_POST['email']) : ''); ?>" placeholder="Enter your email address">
					</div>
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<button type="submit" class="btn btn-default btn-green pull-right" name="submit">Submit</button>
				</form>
		</div>
		<footer>
			<?php
      PageBuilder::getFooter();
      ?>
		</footer>
	</body>

	</html>
