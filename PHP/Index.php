<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Starter Template for Bootstrap 3.3.7</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
  <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
  <style>


  </style>

  <!--[if IE]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
  <!--FUTURE: We will need to have a dynamic navigation bar that will react when the user logins in eg. display your sales, logout tabs-->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">G.Sale</a>
      </div>

      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="sales.php">Sales</a></li>
          <li><a href="items.php">Items</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <!-- NOTE: should we have login page or login fields?-->
          <li>
            <form class="navbar-form" role="search">
              <div class="input-group">
                <input id="search" type="text" class="form-control" placeholder="Search" name="search">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </div>
            </form>
          </li>
          <!--TODO: link My Account and Login to pages?-->
          <!--NOTE: My Account if loged in else create user?-->
          <li><a href="#">My Account</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
      </div>
      <!--.nav-collapse -->
    </div>
  </nav>

  <!--TODO: fill in info paragraph with details-->
  <div class="container-fluid">
    <div class="col-sm-8 text-left">
      <h1>Welcome</h1>
      <p>Paragraph about us!</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>
    </div>
    <div class="col-sm-4 sidenav">
      <div class="well text-center">
        <p>Login
          <p>
            <form action="#" method="post">
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="username" type="text" class="form-control" name="username" placeholder="Username">
              </div>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="password" type="password" class="form-control" name="password" placeholder="Password">
              </div>
            </form>
      </div>
      <!--FUTURE: dynamic list of sales near your or searched for items?-->
      <div class="well text-center">
        <p>Newsfeed</p>
        <ul>
          <li><a>link</a></li>
          <li><a>link</a></li>
          <li><a>link</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!--TODO: fill in contact info-->
  <footer class="container-fluid text-center">
    <h4>Contact Us</h4>
    <div>
      <div class="contact-info">Phone Number: <span class="glyphicon glyphicon-earphone"></span></div>
      <div class="contact-info">Email Address: <span class="glyphicon glyphicon-envelope"></span></div>
    </div>
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
