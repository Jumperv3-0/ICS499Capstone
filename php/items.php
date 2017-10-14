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
<form>
  <div class="form-group">
    <label for="search">search items</label>
	<select>
  <option value="clothes">Clothes</option>
  <option value="cars">Cars</option>
  <option value="furnture">Furnture</option>
  <option value="toys">Toys</option>
</select>
    <input type="text" class="form-control" id="search">
	<button type="button" class="btn btn-default">Search</button>
  </div>
  </form>

<ul class="list-group">
  <li class="list-group-item">First item</li>
  <li class="list-group-item">Second item</li>
  <li class="list-group-item">Third item</li> </ul>
</div>



	<footer>
		<?php
			include 'getFooter.php';
			getFooter();
		?>
	</footer>
	</body>
</html>
