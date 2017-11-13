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
    <?php
    if (Session::exists('createSale')) {
      echo '<div class="container">' . Session::flash('createSale') . '</div>';
    }
    ?>


    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1>Your Sales</h1>
        </div>
      </div>
    </div>
    <?php
    $gsale = new GarageSale();
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['gsale_id'])) {
      $found = $gsale->find(sanitizeInput($_GET['gsale_id']));
      if ($found && strcmp(sanitizeInput($_GET['action']), "edit") == 0) {
        var_dump($gsale->getData());
        include 'editSale.php';
      } else if ($found && strcmp(sanitizeInput($_GET['action']), "delete") == 0) {
        var_dump($gsale->getData());
        echo "in delete";
      } else {
        echo "cound not find sale";
      }
    } else {
      echo '<div class="container">
              <div class="row">
                <div class="col-sm-6"><h3>Hello: ' . ucfirst($user->Data()->fname) . '</h3>
              </div>
              <div class="col-sm-6">
                <a id="createSale" class="btn btn-green pull-right" href="createSale2.php" style="margin-top:18px;">Create Sale  <span class="glyphicon glyphicon-plus-sign"></span></a>
              </div>
            </div>
          </div>
          <br>';
      echo $page->getContent();
    }
    ?>
    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
  </body>

</html>
