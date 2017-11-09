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
    $gsale = new GarageSale();
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['gsale_id'])) {
      if ($gsale->find(sanitizeInput($_GET['gsale_id']))) {
        var_dump($gsale->getData());
      } else {
        echo "false";
      }
    } else {

    }
    ?>


    <div class="container top-container">
      <div class="row">
        <div class="col-sm-12">
          <h1 id="well-title">Your Sales</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <?php
          $user = new User();
          if ($user->isLoggedIn()) {
            echo "<h3>Hello: " . ucfirst($user->Data()->fname) . "</h3>";
          }
          ?>
        </div>
        <div class="col-sm-6">
          <a id="createSale" class="btn btn-green pull-right" href="createSale2.php">Create Sale  <span class="glyphicon glyphicon-plus-sign"></span></a>
        </div>
      </div>
    </div>
    <br>
    <div class="container">
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
          <div class="row">
            <div class="col-sm-3">
              <div class="collapse-header">Name: </div>
              <div>Bob's Bouncy Bargains</div>
            </div>
            <div class="col-sm-3">
              <div class="collapse-header">Date: </div>
              <div>Mon, Oct 16 - Sun, Oct 19</div>
            </div>
            <div class="sale-buttons col-sm-6 text-right">
              <div class="col-xs-12">
                <a class="btn btn-warning" href="?action=edit&gsale_id=1">Edit Sale</a>
              </div>
              <div class="col-xs-12">
                <a class="btn btn-primary" href="otherSales.php?gsale_id=1">View Sale</a>
              </div>
              <div class="col-xs-12">
                <a class="btn btn-danger" href="" data-toggle="modal" data-target="#deleteModal">Delete</a>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="deleteModal" role="dialog">
        <div class="modal-dialog bg-danger">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>&nbsp;Warning</h4>
            </div>
            <div class="modal-body">
              <p>You are about to delete a sale are you sure you want to do that?</p>
            </div>
            <div class="modal-footer">
              <a type="button" class="btn btn-danger pull-left" href="?action=delete&gsale_id=1">Delete Sale</a>
              <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
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
