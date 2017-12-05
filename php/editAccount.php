<?php
require_once 'init.php';
require_once 'Objects.php';
$user = new User();
if (!$user->isLoggedIn()) {
  Redirect::page('404.php');
}
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
  // TODO: change to correct page
  $pageBuilder = new IndexPage();
      $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <h1>Edit Account</h1>
    </div>
    <br>
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
                //'unique' => 'users',     // username must be unique in users table
                'name' => 'Username'
              ),
              'password' => array(
                'required' => true,
                'min' => 6,
                'max' => 22,
                'name' => 'Password'
              ),
              'password_again' => array(
                'name' => "Password Again",
                'required' => true,
                'min' => 6,
                'max' => 22,
                'matches' => 'password', // password_again must match password
              ),
              'fname' => array(
                'name' => "First name",
                'required' => true,
                'min' => 2,
                'max' => 30,
              ),
              'lname' => array(
                'name' => "Last name",
                'required' => true,
                'min' => 2,
                'max' => 30
              ),
              'email' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
                'email' => true,         // must be an email
                'name' => 'Email'
              )
            ));

            if ($validation->passed()) {  // all inputs valid
              $user = new User();       // get current user
              try {
                $user->edit(array(
                  sanitizeInput($_POST['username']),
                  password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT),
                  sanitizeInput($_POST['fname']),
                  sanitizeInput($_POST['lname']),
                  sanitizeInput($_POST['email'])
                ), $user->Data()->user_id);
              } catch(Exception $e) {
                die ($e->getMessage());
              }
              Session::flash('success', 'You changed your account successfully!');
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
      <div class="container">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="fname">First Name:</label>
                <input class="form-control" type="text" id="fname" name="fname" value="<?php echo $user->Data()->fname ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="lname">Last Name:</label>
                <input class="form-control" type="text" id="lname" name="lname" value="<?php echo $user->Data()->lname ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" id="username" name="username" value="<?php echo $user->Data()->username ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" id="email" name="email" value="<?php echo $user->Data()->email ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="text" id="password" name="password">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="password_again">Password again:</label>
                <input class="form-control" type="text" id="password_again" name="password_again">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3 pull-right">
              <div class="form-group">
                <button class="btn btn-green form-control" name="submit" id="submit">Submit</button>
              </div>
            </div>
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        </form>
      </div>
  </body>

  </html>
