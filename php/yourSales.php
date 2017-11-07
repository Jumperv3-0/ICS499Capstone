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
			<?php PageBuilder::getTitle(); ?>
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
		<style>
			#well-title {
				margin: 0;
			}

		</style>
	</head>

	<body>
		<header>
			<?php
			$page = new SalesPage();
			$page->getHeader();
			?>
		</header>
		<?php
		if (Session::exists('createSale')) { 
			echo '<div class="container">' . Session::flash('createSale') . '</div>'; 
		}
		?>

			<div class="container">
				<div class="pull-right">
					<?php
				$user = new User();
				if ($user->isLoggedIn()) {
					echo "<h3>Hello: " . ucfirst($user->Data()->fname) . "</h3>";
				}
				?>
				</div>
			</div>
			<div class="container">
				<div class="row" id="well-header">
					<div class="col-sm-6">
						<h1 id="well-title">Your Sales</h1>
					</div>
					<div class="col-sm-6">
						<a id="createSale" class="btn btn-green pull-right" href="createSale2.php">Create Sale  <span class="glyphicon glyphicon-plus-sign"></span></a>
					</div>
				</div>
			</div>
			<br>
			<br>
			<div class="container">
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-3">Bob's Bouncy Bargains</div>
							<div class="col-sm-3">
								<p>Date: Mon, Oct 16 - Sun, Oct 19</p>
							</div>
							<div class="sale-buttons col-sm-6 text-right"><a class="btn btn-warning" href="">Edit Sale</a><a class="btn btn-primary" href="">View Sale</a><a class="btn btn-danger" href="">Delete</a></div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<img src="http://lorempixel.com/100/100/" />
							</div>
							<div class="col-sm-8">
								<h5 class="collapse-header">Description:</h5>
								<p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
							</div>
						</div>
					</div>
					<!-- List group -->
					<ul class="list-group">
						<li class="list-group-item">
							<div class="row">
								<div class="col-sm-6">
									<h3 class="collapse-header">Items</h3>
								</div>
								<div class="col-sm-6 text-right"><a class="btn btn-green" href="createItem.php">Add Item</a></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col-sm-3">Sword</div>
								<div class="col-sm-3">Price: $500.67</div>
								<div class="col-sm-6 text-right"><a class="btn btn-warning" href="">Edit</a><a class="btn btn-danger" href="">Delete</a>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<h5 class="collapse-header">Description:</h5>
									<p>Sword of a thousand truths</p>
								</div>
							</div>
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
