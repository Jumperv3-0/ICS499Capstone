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
    <style>
      .category-option a:hover {
        background: #ccc !important;
      }

    </style>
  </head>

  <body>
    <header>
      <?php
      $pageBuilder = new ItemsPage();
      $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <?php
      $validation = false;
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit']) && Token::check(sanitizeInput($_POST['token']))) {
          $validator = new validation();
          $rules = array(
            'catagory' => array(
              'required' => true,
              'name' => "Select catagory",
              'catagory' => true
            ),
            'search' => array(
              'required' => true,
              'name' => 'Search',
              'min' => 2,
              'max' => 20
            ));
          $validation = $validator->check($_POST, $rules);
          if ($validation->passed()) {
            // TODO: Get matches
          } else {
            foreach ($validation->getErrors() as $error) {
              echo $error . "<br>";
            }
          }
        }
      } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['start_index']) && isset($_GET['catagory']) && isset($_GET['search'])) {
          $validator = new Validation();
          $rules = array(
            'catagory' => array(
              'required' => true,
              'name' => "Select catagory",
              'catagory' => true
            ),
            'search' => array(
              'required' => true,
              'name' => 'Search',
              'min' => 2,
              'max' => 20
            ));
          $validation = $validator->check($_GET, $rules);
          if ($validation->passed()) {
            // TODO: Get matches
          } else {
            foreach ($validation->getErrors() as $error) {
              echo $error . "<br>";
            }
          }
        }
      }
      ?>
        <div class="row">
          <div class="col-sm-12">
            <h1>Items</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form method="post" action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>">
              <div class="form-group">
                <label for="catagory">Select Catagory</label>
                <select name="catagory" id="catagory">
                <option value="default">---</option>
                <option value="all" <?php  if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'all') ==0? 'selected' : '');} ?>>All Catagories</option>
                <option value="clothes" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'clothes') ==0? 'selected' : '');} ?>>Clothes</option>
                <option value="electronic" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'electronic') ==0? 'selected' : ''); }?>>Electronics</option>
                <option value="furnture" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'furnture') ==0? 'selected' : '');} ?>>Furnture</option>
                <option value="media" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'media') ==0? 'selected' : '');} ?>>Media eg.(Books, Magazines, Music, Movies)</option>
                <option value="tool" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'tool') ==0? 'selected' : '');} ?>>Tools</option>
                <option value="toy" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'toy') ==0? 'selected' : '');} ?>>Toys</option>
                <option value="vehicle" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'vehicle') ==0? 'selected' : '');} ?>>Vehicle</option>
                <option value="other" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'other') ==0? 'selected' : '');} ?>>Other</option>
              </select>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search for item">
              </div>

              <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
              <input type="submit" name="submit" class="btn btn-green pull-right" value="Search">
            </form>
          </div>
        </div>

        <!-- FIXME: uses get instead of post -->
        <!-- FIXME: number of pages should be dynamic -->

        <br>
        <br>
        <br>
        <?php
      if (!$validation) {
        // desplay nothing
      } else {
        if ($validation->passed()) {
          $table = new ItemsListTable();
          $numberOfItems = 1;
          $startingIndex = 0;
          if (isset($_POST['catagory']) && isset($_POST['search'])) {
            $catagory = sanitizeInput($_POST['catagory']);
            $search = sanitizeInput($_POST['search']);
          } else if (isset($_GET['catagory']) && isset($_GET['search'])) { // FUTURE: was going to be used for paging
            echo "<div>get</div>";
            $catagory = sanitizeInput($_GET['catagory']);
            $search = sanitizeInput($_GET['search']);
          }
          echo $table->getTable($search, $catagory, $startingIndex);
        }
      }
      ?>
    </div>
    <!--FUTURE: replacement of select option-->
    <!--
    <div class="container">
    <div class="input-group">
    <input type="text" id="category" class="form-control dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="Click for Options" aria-describedby="catagory" readonly>
    <label class="input-group-addon" for="category"><span class="caret"></span></label>
    <ul class="dropdown-menu" id="choice">
    <li class="category-option"><a href="#">---</a></li>
    <li class="category-option"><a href="#">All Catagories</a></li>
    <li class="category-option"><a href="#">Clothes</a></li>
    <li class="category-option"><a href="#">Electronics</a></li>
    <li class="category-option"><a href="#">Furnture</a></li>
    <li class="category-option"><a href="#">Media eg.(Books, Magazines, Music, Movies)</a></li>
    <li class="category-option"><a href="#">Tools</a></li>
    <li class="category-option"><a href="#">Electronics</a></li>
    <li class="category-option"><a href="#">Toys</a></li>
    <li class="category-option"><a href="#">Vehicle</a></li>
    <li class="category-option"><a href="#">Clothes</a></li>
    <li class="category-option"><a href="#">Other</a></li>
    </ul>
    </div>
    </div>
    -->



    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
    <script>
      (function init() {
        var options = document.getElementsByClassName("category-option");
        console.log(options);
        var length = options.length;
        for (var i = 0; i < length; i++) {
          options[i].addEventListener("click", (function(n) {
            return function() {
              setCategory(options[n].firstChild.innerHTML);
            }
          })(i));
        }
      })();

      function setCategory(text) {
        document.getElementById("category").value = text;
      }

    </script>
  </body>

  </html>
