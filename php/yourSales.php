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
    </head>

    <body>
        <header>
            <?php
			$page = new SalesPage();
            $page->getHeader();
		?>
        </header>
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
		<div class="well">
		<h3>Plan a new Garage Sale.</h3>
		<a href="createSale2.php">
			Create Sale
			<span class="glyphicon glyphicon-plus-sign"></span>
		</a>
		//Add List of your sales.
			
		</div>
	</div>	
        
        <footer>
            <?php
			PageBuilder::getFooter();
		?>
        </footer>
    </body>

    </html>
