<?php
require_once 'init.php';
require_once 'Objects.php';
//    TODO: uncomment code when page is done
$user = new User();
if (!$user->isLoggedIn()) {
  Redirect::page('404.php');
}
//if (!$user->hasSale(sanitizeInput($_GET['gsale_id']))) {
//  Redirect::page('404.php');
//}
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
    <script>
      function priceFormat() { // Make price idiot proof and convert to double. if an int is entered just give it .00
        var el = document.getElementById('price');
        var priceNumber = el.value;
        priceNumber = priceNumber.replace(/[^0-9|\(\)\-]/g, '');
        //don't remove period for cents. and add one if none is entered. $4.99 would be 4.99. and 4$ would be converted to 4.00
        el.value = priceNumber;
        //alert(priceNumber);
      }

    </script>
    <header>
      <?php
  $pageBuilder = new CreateItemsPage();
      $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <h1>Create Item</h1>
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit']) && Token::check(sanitizeInput($_POST['token']))) {
          $validator = new validation();
          $validator2 = new validation();
          $rules2 = array(
            'image' => array(
              'image' => true,
              'name' => "Image"
            )
          );
          $rules = array(
            'description' => array(
              'max' => 10000, // FIXME: what is description max size?
              'required' => false,
              'name' => 'Description'
            ),
            'price' => array(
              'required' => true,
              'price' => true,
              'name' => 'Price'
            ),
            'catagory' => array(
              'required' => true,
              'catagory' => true,
              'name' => 'Catagory'
            )
          );
        }
        $filename = "";
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
          $filename = 'image';
        } else {
          $filename = null;
        }
        $image = new ImageProcesser($filename);
        $validation = $validator->check($_POST, $rules);
        $validation2 = $validator2->check($_FILES, $rules2);
        if ($validation->passed() && $validation2->passed()) { //convert this to instead connect item to sale.
          $item = new Item();
          try {
            echo "passed";
            $params = array(sanitizeInput($_POST['price']), sanitizeInput($_POST['description']), $image->getNewName(), 0, (sanitizeInput($_POST['catagory'])) . ", all", sanitizeInput($_POST['gsale_id']));

            //$params = array(price, description, image_url, 0, keywords);
            $item->create($params);
            Session::flash('addItem', "Your item was added!");
            Redirect::page("yourSales.php");
          } catch (Exception $e) {
            die ($e->getMessage());
          }
        } else {
          Session::flash('addItem', "Your item was not added!");
          Redirect::page("yourSales.php");
//          foreach ($validation->getErrors() as $error) {
//            echo $error . "<br>";
//          }
        }
        //Redirect::page("yourSales.php");
      }
      ?>
      <form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="image">Image of Item (Optional):</label>
          <input type="file" id="image" name="image[]">
        </div>
        <div class="form-group">
          <label for="description">General Description:</label>
          <textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the item for sale"><?php echo(isset($_POST['description']) ? sanitizeInput($_POST['description']) : ''); ?></textarea>
        </div>

        <div class="form-group">
          <label for="price">Price:</label>
          <input class="form-control" type="text" id="price" name="price" placeholder="Enter price of item">
        </div>

        <div class="form-group">
          <label for="select">Change catagory:</label>
          <select class="form-control" name="catagory" id="catagory">
            <option value="default">---</option>
            <option value="clothes" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'clothes') ==0? 'selected' : '');} ?>>Clothes</option>
            <option value="electronic" <?php if (isset($_POST['catagory'])) {(strcmp(sanitizeInput($_POST['catagory']), 'electronic') ==0? 'selected' : ''); }?>>Electronics</option>
            <option value="furnture" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'furnture') ==0? 'selected' : '');} ?>>Furnture</option>
            <option value="media" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'media') ==0? 'selected' : '');} ?>>Media eg.(Books, Magazines, Music, Movies)</option>
            <option value="tool" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'tool') ==0? 'selected' : '');} ?>>Tools</option>
            <option value="toy" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'toy') ==0? 'selected' : '');} ?>>Toys</option>
            <option value="vehicle" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'vehicle') ==0? 'selected' : '');} ?>>Vehicle</option>
            <option value="other" <?php if (isset($_POST['catagory'])) { (strcmp(sanitizeInput($_POST['catagory']), 'other') ==0? 'selected' : '');} ?>>Other</option>
          </select>
        </div>
        <input type="hidden" name="gsale_id" value="<?php echo sanitizeInput($_GET['gsale_id']); ?>">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <button type="submit" class="btn btn-default btn-green pull-right" name="submit">Submit</button>
      </form>
    </div>
    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
  </body>

</html>
