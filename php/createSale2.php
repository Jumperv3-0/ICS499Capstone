<?php
require_once 'init.php';
require_once 'Objects.php';
$user = new User();
if (!$user->isLoggedIn()) {   // User must be logged in to see page else redirect to error page
  Redirect::page('404.php');
}
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
    <script src="../js/source.js"></script>
    <header>
      <?php

  $pageBuilder = new CreateSalesPage();
      $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <h1>Create Sale</h1>
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit']) && Token::check(sanitizeInput($_POST['token']))) {
          $validator = new validation();
          $rules = array(
            'sale_name' => array(
              'name' => "Sale Name",
              'required' => true,
              'min' => 4,
              'max' => 22
            ),
            'description' => array(
              'name' => 'Description',
              'max' => 1500,
              'required' => true
            ),
            'date' => array(
              'required' => true,
              'date' => true,
              'name' => 'Date'
              // TODO: chage date rules after today
              // TODO: change date to YYYY/mm/dd
            ),
            'startTime' => array(
              'name' => "Start Time",
              'required' => true,
              'startTime' => true
            ),
            'endTime' => array(
              'name' => "End Time",
              'required' => true,
              'endTime' => true
            ),
            'location' => array(
              'required' => true,
              'address' => true,
              'name' => 'Location'
            ),
            'phone' => array(
              'required' => true,
              'phone' => true,
              'name' => 'Phone number'
            ));
          $filename = "";
          if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $filename = 'image';
          } else {
            $filename = null;
          }
          $image = new ImageProcesser($filename);
          $validation = $validator->check($_POST, $rules);
          if ($validation->passed() && count($image->getErrors()) === 0) {      // input passed all validaiton
            try {
              $formattedDates = formatDates();
              $user = new User();
              $place = new Place();
              $place->getPlaceJSON(sanitizeInput($_POST['location']));
              $place->create();
              $phone = new Phone();
              $phone->create(array(Phone::formatNumber(sanitizeInput($_POST['phone']))));
              $gsale = new GarageSale();
              $gsale->create(array(sanitizeInput($_POST['sale_name']), $image->getNewName(), sanitizeInput($_POST['description']), $formattedDates));
              $gsale_data;
              $place_data;
              $phone_data;
              $isAdded = $gsale->lastAdded();
              if ($isAdded) {
                $gsale_data = $gsale->getData()[0];
              }
              $isAdded = $place->lastAdded();
              if ($isAdded) {
                $place_data = $place->getData()[0];
              }
              $isAdded = $phone->lastAdded();
              if ($isAdded) {
                $phone_data = $phone->getData()[0];
              }
              $db_conn = SqlManager::getInstance();
              $sql = "INSERT INTO garage_sales_phones (garage_sale_fk_id, phone_fk_id) VALUES (?, ?);";
              $result = $db_conn->query($sql, array($gsale_data->gsale_id, $phone_data->phone_id));
              $sql = "INSERT INTO garage_sales_places (garage_sale_fk_id, place_fk_id) VALUES (?, ?);";
              $result = $db_conn->query($sql, array($gsale_data->gsale_id, $place_data->place_id));
              $sql = "INSERT INTO garage_sales_users (user_fk_id, garage_sales_fk_id) VALUES (?, ?);";
              $result = $db_conn->query($sql, array($user->data()->user_id, $gsale_data->gsale_id));
              // FIXME: ->lastAdded() returns true or false not $data call getData()->id
              // TODO: Link place and gsale, phone and gsale, user and gsale
              Session::flash('createSale', "Your garage sale was created!");
              Redirect::page("yourSales.php");
            } catch (Exception $e) {
              die ($e->getMessage());
            }
          } else {
            if (count($image->getErrors()) > 0) {
              echo $image->getErrors()[0] . "<br>";
            }
            foreach ($validation->getErrors() as $error) {
              echo $error . "<br>";
            }
          }
        }
      }
      ?>
      <form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="sale_name">Name of sale:</label>
          <input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo(isset($_POST['sale_name']) ? sanitizeInput($_POST['sale_name']) : ''); ?>" placeholder="Enter name of sale">
        </div>
        <div class="form-group">
          <label for="image">Picture of Sale (Optional):</label>
          <input type="file" id="image" name="image">
        </div>
        <div class="form-group">
          <label for="description">General Description:</label>
          <textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Tell us about your sale and the types of items you'll have"><?php echo(isset($_POST['description']) ? sanitizeInput($_POST['description']) : ''); ?></textarea>
        </div>
        <div id="date-time" class="form-group">
          <div class="row">
            <div class="col-sm-4">
              <label for="location1">Date:</label>
            </div>
            <div class="col-sm-3">
              <label for="startTime1">Start Time:</label>
            </div>
            <div class="col-sm-3">
              <label for="endTime1">End Time:</label>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4 form-group">
              <input type="text" class="form-control" id="datepicker" name="date[]" value="" placeholder="mm/dd/yyyy">
            </div>
            <div class="col-xs-12 col-sm-3 form-group">
              <input type="time" class="form-control " id="startTime1" name="startTime[]" value="">
            </div>
            <div class="col-xs-12 col-sm-3 form-group">
              <input type="time" class="form-control" id="endTime1" name="endTime[]" value="">
            </div>
            <div class="col-xs-12 col-sm-2 form-group">
              <button type="button" class="btn btn-green-no-padding form-control" id="add_date" onclick="addDate()">Add Day <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </div>
        <div id="locationField" class="form-group">
          <label for="location">Location:</label>
          <input type="location" class="form-control" id="location" name="location" value="<?php echo(isset($_POST['location']) ? sanitizeInput($_POST['location']) : ''); ?>" placeholder="Enter location of sale">
        </div>
        <div class="form-group">
          <label for="phone">Phone:</label>
          <input type="phone" class="form-control" id="phone" name="phone" placeholder="(xxx)-xxx-xxxx" onKeyUp="formatPhone()" onkeypress="formatPhone()" value="<?php echo(isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : ''); ?>" maxlength="16">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <div class="row">
          <div class="col-xs-12 col-sm-2 pull-right">
            <button type="submit" class="btn btn-green-no-padding form-control pull-right" name="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <br>
    <br>
    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=initAutocomplete" async defer></script>
  </body>

</html>
