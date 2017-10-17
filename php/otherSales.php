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
            $pageBuilder = new SalesPage();
            $pageBuilder->getHeader();
        ?>
		</header>
		<div class="container">
			<h1>Sales</h1>
		</div>
		<div class="container">
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
									<img src="http://lorempixel.com/g/100/100/" />
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
									<img src="http://lorempixel.com/g/100/100/" />
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
									<img src="http://lorempixel.com/g/100/100/" />
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
									<img src="http://lorempixel.com/g/100/100/" />
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
