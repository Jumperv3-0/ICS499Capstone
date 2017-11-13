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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <style>
      #map {
        width: 100%;
        height: 450px;
      }

      .map-search-title {
        color: #fff;
        background-color: #526747;
        font-size: 25px;
        font-weight: 500;
        padding: 3px 12px;
        /*
        border-top-left-radius: 1em;
        border-top-right-radius: 1em;
        */
      }

      .map-search-input {
        display: inline;
        background-color: #fff;
        padding: 0 0 0 5px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }

      .map-search {
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        display: inline;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        border-radius: 3em;
        width: 45%;
        min-width: 200px;
      }

      img {
        max-width: 250px;
        width: 100%;
      }

    </style>
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
    <?php
    $gsale = new GarageSale();
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['gsale_id'])) {
      $found = $gsale->find(sanitizeInput($_GET['gsale_id']));
      if ($found && !isset($_GET['directions'])) {
        include 'sale.php';
      } else if ($found && isset($_GET['directions']) && sanitizeInput($_GET['directions'])) {
        echo "get Directions";
      }else {
        echo "could not find sale";
      }
    } else {
      include 'auto-complete-map.php';
      include 'list_sales.php';
    }
    ?>

    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
  </body>

</html>
