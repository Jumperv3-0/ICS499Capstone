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
    $pageBuilder = new ItemsPage();
    $pageBuilder->getHeader();
    ?>
    </header>

    <div class="container">
      <h1>Items</h1>
    </div>
    <div class="container">
      <form>
        <!-- TODO: should the select have fewer catagories -->
        <div class="form-group">
          <label for="search">search items</label>
          <select>
          <option value="default">---</option>
          <option value="all">All Catagories</option>
          <option value="car">Car</option>
          <option value="boat">Boat</option>
          <option value="vehicle">Vehicle(Other)</option>
          <option value="couch">Couch</option>
          <option value="bed">Bed</option>
          <option value="lamp">Lamp</option>
          <option value="furnture">Furnture(Other)</option>
          <option value="tv">TV</option>
          <option value="audio">Audio</option>
          <option value="gaming">Gaming</option>
          <option value="electronic">Electronic(Other)</option>
          <option value="book">Book</option>
          <option value="movie">Movie</option>
          <option value="music">Music</option>
          <option value="kids_toy">Kids Toy</option>
          <option value="clothes_men">Clothes (Men)</option>
          <option value="clothes_women">Clothes (Women)</option>
          <option value="clothes_boy">Clothes (Boy)</option>
          <option value="clothes_girl">Clothes (Girl)</option>
          <option value="clothes_other">Clothes (Other)</option>
          <option value="baby">Baby</option>
          <option value="pet">Pet</option>
          <option value="tool">Tool</option>
          <option value="decoration">Decoration</option>
          <option value="other">Other</option>
        </select>
          <input type="text" class="form-control" id="search">
          <button type="button" class="btn btn-green pull-right">Search</button>
        </div>
      </form>
      <br>
      <br>
      <ul class="list-group">
        <li class="list-group-item">First item</li>
        <li class="list-group-item">Second item</li>
        <li class="list-group-item">Third item</li>
      </ul>
    </div>



    <footer>
      <?php
    PageBuilder::getFooter();
  ?>
    </footer>
  </body>

  </html>
