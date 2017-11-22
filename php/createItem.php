<?php
require_once 'init.php';
require_once 'Objects.php';
//    TODO: uncomment code when page is done
$user = new User();
if (!$user->isLoggedIn()) {
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
			<h1>Create Item for your Sale</h1>
			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (isset($_POST['submit']) && Token::check(sanitizeInput($_POST['token']))) {
					$validator = new validation();
					$rules = array(
						'item_name' => array(
							'name' => "Item Name",
							'required' => true,
							'min' => 3,
							'max' => 22
						),
						'description' => array(
							'max' => 10000, // FIXME: what is description max size?
							'required' => false
						),
						'price' => array(
							'required' => true,
							'price' => true
						));				//Not sure how keywords are handled. Probably with dropdown menu or check boxes.
				}
				$validation = $validator->check($_POST, $rules);
				$image_url = "not_implented.png"; // TODO: need to upload image to downloads folder and create new url and save here
				$formattedDates = formatDates();
				if ($validation->passed()) { //convert this to instead connect item to sale.
					$user = new User();
					$gsale = new GarageSale();
					$place = new Place();
					try {
						$address = $_POST['location'];
						$address = sanitizeInput($_POST['location']);
						$place->getPlaceJSON("?address=" . $address);
						$address = sanitizeInput($address);
						$place->create();
						if ($place->exists()) {
							var_dump($place);
							// create garageSale()
							$gsale->create(array(
								sanitizeInput($_POST['sale_name']),
								$image_url,
								sanitizeInput($_POST['description']),
								$formattedDates,
								$place->getData()->place_id,
								$user->data()->user_id
							));
						}
					} catch (Exception $e) {
						die ($e->getMessage());
					}
				} else {
					foreach ($validation->getErrors() as $error) {
						echo $error . "<br>";
					}
				}
				//Redirect::page("yourSales.php");
			}
			?>
				<form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="item_name">Name of Item:</label>
						<input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo(isset($_POST['item_name']) ? sanitizeInput($_POST['item_name']) : ''); ?>" placeholder="Enter name of item">
					</div>
					<div class="form-group">
						<label for="image">Image of Item (Optional):</label>
						<input type="file" id="image" name="image">
					</div>
					<div class="form-group">
						<label for="description">General Description:</label>
						<textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the types of item for sale"><?php echo(isset($_POST['description']) ? sanitizeInput($_POST['description']) : ''); ?></textarea>
					</div>

					<div class="form-group">
						<label for="price">Price:</label>
						<input class="form-control" type="text" id="price" placeholder="Enter price of item">
					</div>

					<div class="form-group">
						<label for="sel1">Item Type:</label>
						<select class="form-control" id="sel1">
						<option>--</option>
						<option>type1</option>
						<option>type2</option>
						<option>type3</option>
					</select>
					</div>
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