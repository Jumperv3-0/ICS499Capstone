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
    <script src="../js/source.js"></script>
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
    } else if (Session::exists('editSale')) {
      echo '<div class="container">' . Session::flash('editSale') . '</div>';
    } else if (Session::exists('deleteItem')) {
      echo '<div class="container">' . Session::flash('deleteItem') . '</div>';
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
        //var_dump($gsale->getData());
        // validate input
        include 'editSale.php';
      } else if ($found && strcmp(sanitizeInput($_GET['action']), "delete") == 0) {
        var_dump($gsale->getData());
        if (isset($_GET['gsale_id']) && !isset($_GET['item_id'])) {
          // delete gsale
//          $user = new User();
//          if (!$user->hasSale($gsale->getData()->gsale_id)) {
//            Redirect::page('404.php');
//          }

        } else if (isset($_GET['gsale_id']) && isset($_GET['item_id'])) {
          //delet item from sale
          $user = new User();
//          if (!$user->hasSale($gsale->getData()->gsale_id) || !$gsale->hasItem(sanitizeInput($_GET['item_id']))) {
//            Redirect::page('404.php');
//          }
          $item = new Item();
          $removed = $item->remove(sanitizeInput($_GET['item_id']));
          if ($removed) {
            Session::flash('deleteItem', "Item was deleted!");
            Redirect::page("yourSales.php");
          } else {

            Session::flash('deleteItem', "Item was not deleted!");
            Redirect::page("yourSales.php");
            var_dump($item);
          }
        }
        echo "in delete";
      } else {
        echo "cound not find sale";
      }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_submit']) && Token::check(sanitizeInput($_POST['token']))) {
      // check that user has permission
//      $user = new User();
//      if (!$user->hasSale($gsale->getData()->gsale_id)) {
//        Redirect::page('404.php');
//      }
      // create validator
      $validator = new validation();
      $validator2 = new validation();
      $rules2 = array(
        'image' => array(
          'image' => true,
          'name' => "image"
        ));
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
        ),
        'description' => array(
          'max' => 10000, // FIXME: what is description max size?
          'required' => false,
          'name' => "Description"

        ),
        'price' => array(
          'required' => true,
          'price' => true,
          'name' => "Price"
        ),
        'catagory' => array(
          'required' => true,
          'catagory' => true,
          'name' => "Catagory"
        )
      );
      $validation = $validator->check($_POST, $rules);
      $validation2 = $validator2->check($_FILES, $rules2);
      $count = count($_FILES['image']['name']);
      $images = array();
      $filename = array();
      for ($i = 0; $i < $count; $i++) {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'][$i])) {
          $filename[] = 'image';
          $images[] = new ImageProcesser($filename[0], $i);
          //var_dump($filename);
        } else {
          $filename[] = null;
          $images[] = new ImageProcesser($filename[0]. $i);
          //var_dump($filename);
        }
      }
      if ($validation->passed() && $validation2->passed()) {
        echo "<h1>passed</h1>";
        try {
          $formattedDates = formatDates();
          // TODO: send back to yourSales.php
          $params = array();
          $gsale = new GarageSale();
          $phone = new Phone();
          //var_dump($filename);
          if ($filename[0] != null) {
            $params = array(sanitizeInput($_POST['sale_name']), $images[0]->getNewName(),  sanitizeInput($_POST['description']), $formattedDates, sanitizeInput($_POST['gsale_id']));
          } else {
            $params = array(sanitizeInput($_POST['sale_name']), sanitizeInput($_POST['description']), $formattedDates, sanitizeInput($_POST['gsale_id']));
          }
//          var_dump($params);
//          var_dump($gsale->editSale($params));
          $gsale->editSale($params);
          $phone->edit(array(Phone::formatNumber(sanitizeInput($_POST['phone']))), sanitizeInput($_POST['phone_id']));
          //          TODO: loop each item
          $size = count($_POST['price']);
          $item = new Item();
          for ($i = 0; $i < $size; $i++) {
            if (strcmp(sanitizeInput($_POST['available'][$i]), 'sold') === 0) {
              $is_sold = 1;
            } else {
              $is_sold = 0;
            }
            if ($filename[$i+1] != null) {
              $params = array(sanitizeInput($_POST['price'][$i]), sanitizeInput($_POST['itemDescription'][$i]), $images[($i+1)]->getNewName(), $is_sold, (sanitizeInput($_POST['catagory'][$i]) . ",all"));
            } else {
              $params = array(sanitizeInput($_POST['price'][$i]), sanitizeInput($_POST['itemDescription'][$i]), $is_sold, (sanitizeInput($_POST['catagory'][$i]) . ",all"));
            }
            $item->edit($params, sanitizeInput($_POST['item_id'][$i]));
          }
          Session::flash('editSale', "Your changes were saved!");
          Redirect::page("yourSales.php");
        } catch (Exception $e) {
          die ($e->getMessage());
        }

      } else {
        // else return to edit?
//        Session::flash('editSale', "Error your changes were not saved!");
//        Redirect::page("yourSales.php");
        foreach($validation->getErrors() as $error) {
          echo $error . '<br>';
        }
        foreach($validation2->getErrors() as $error) {
          echo $error . '<br>';
        }
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
