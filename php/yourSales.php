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
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<style>
	body {
	padding-top: 8em;
}

.separator {
	border-bottom: #526747 5px solid;
}

.btn-login {
	color: #fff;
	background-color: #526747;
	border-color: #ccc;
	padding: .5em 3em;
}

.btn-login:hover {
	color: #fff;
	background-color: #234214;
	border-color: #ccc;
}

.navbar {
	margin-bottom: 0;
	border-radius: 0;
	background-color: #234214;
	color: #fff;
	padding: .5% 0;
	font-size: 1.1em;
	border-left: none;
	border-right: none;
	border-bottom: #526747 5px solid;
}

.navbar-inverse .navbar-collapse {
	border-color: #526747;
}

.navbar-brand {
	float: left;
	/*min-height: 55px;*/
	padding: 0 15px 5px;
}

.navbar-inverse .navbar-nav .active a,
.navbar-inverse .navbar-nav .active a:focus,
.navbar-inverse .navbar-nav .active a:hover {
	color: #fff;
	background-color: #234214;
}

.navbar-brand img {
	width: 5.8em;
}

.navbar-inverse .navbar-nav>.open>a,
.navbar-inverse .navbar-nav>.open>a:focus,
.navbar-inverse .navbar-nav>.open>a:hover {
	color: #fff;
	background-color: #234214;
}

.nav {
	margin-bottom: 0;
	border-radius: 0;
	background-color: #234214;
	color: #fff;
	padding: .5% 0;
	font-size: 1.1em;
	border: none;
}

.navbar-header {
	min-height: 3.8em;
}

.navbar-inverse .navbar-toggle:focus,
.navbar-inverse .navbar-toggle:hover {
	background-color: #526747;
}

.navbar-inverse .navbar-toggle {
	border-color: #fff;
}

.navbar-form {
	padding: 0;
	margin-top: -.4em;
}

.container-flex {
	max-width: 1200px !important;
	margin: auto;
}

footer {
	color: #fff;
	background-color: #234214;
	border-color: #ccc;
}

.collapse-header {
	display: inline;
	font-weight: bold;
	color: #234214;
}

.collapse-header-text {
	display: inline
}

.dropdown-caret {
	color: #234214;
	margin-top: .5em;
}
</style>
</head>

<body>
	<header>
		<?php
			include 'getNavBar.php';
			getNavBar();
		?>
	</header>
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
					<form id="collapse2" class="collapse">
  <div class="form-group">
  <input type="text" class="form-control" id="address" placeholder="Address">
  <button type="button" class="btn btn-default">edit</button>
    <input type="text" class="form-control" id="search" placeholder="Items"><span>Sold: true</span><span> Price: $$.$$</span>
	<button type="button" class="btn btn-default">edit item</button>
	<button type="button" class="btn btn-default">add item</button>

  </div>
  </form>
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
<div class="container">
<form>
  <div class="form-group">
  <input type="text" class="form-control" id="address" placeholder="Address">
  <button type="button" class="btn btn-default">edit</button>
    <input type="text" class="form-control" id="search" placeholder="Items"><span>Sold: true</span><span> Price: $$.$$</span>
	<button type="button" class="btn btn-default">edit item</button>
	<button type="button" class="btn btn-default">add item</button>

  </div>
  </form>
  </div>
	<footer>
		<?php
			include 'getFooter.php';
			getFooter();
		?>
	</footer>
  </body>
  </html>
