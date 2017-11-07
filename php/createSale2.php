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
		<script>
			// FUTURE: add javascript to its own page if time
			var numberOfDays = 2;

			/**
			 * Adds a date selector to the date-time div
			 * @author Gary
			 */
			function addDate() {

				var o = document.getElementById('date-time');
				var childList = o.childNodes;
				o.insertBefore(makeDate(numberOfDays++), childList[childList.length - 1]);
			}

			/**
			 *
			 * @author Gary
			 * @param   {int}     number of date selectors on page
			 * @returns {element} of new date input selectors
			 */
			function makeDate(number) {
				var row = document.createElement('div');
				var child1 = document.createElement('div');
				var child2 = document.createElement('div');
				var child3 = document.createElement('div');
				var child4 = document.createElement('div');
				var input1 = document.createElement('input');
				var input2 = document.createElement('input');
				var input3 = document.createElement('input');
				var input4 = document.createElement('button');
				row.className = 'row';
				child1.className = 'col-xs-12 col-sm-4 form-group';
				child2.className = 'col-xs-12 col-sm-3 form-group';
				child3.className = 'col-xs-12 col-sm-3 form-group';
				child4.className = 'col-xs-12 col-sm-2 form-group';
				input1.className = 'form-control';
				input2.className = 'form-control';
				input3.className = 'form-control';
				input4.className = 'btn btn-danger form-control';
				input1.type = 'date';
				input2.type = 'time';
				input3.type = 'time';
				input4.type = 'button';
				input1.name = 'date[]';
				input2.name = 'startTime[]';
				input3.name = 'endTime[]';
				input4.name = 'button[]';
				row.id = 'row' + number;
				input1.id = 'date' + number;
				input2.id = 'startTime' + number;
				input3.id = 'endTime' + number;
				input4.id = 'button' + number;
				input4.innerHTML = 'Delete <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>';
				input4.onclick = function() {
					document.getElementById('date-time').removeChild(row);
					numberOfDays--;
				};
				row.appendChild(child1);
				row.appendChild(child2);
				row.appendChild(child3);
				row.appendChild(child4);
				child1.appendChild(input1);
				child2.appendChild(input2);
				child3.appendChild(input3);
				child4.appendChild(input4);
				return row;
			}

			function removeDate() {
				var o = document.getElementById('date-time');
			}

			//-----------------------------------Google maps autocomplete---------------------//
			// This example displays an address form, using the autocomplete feature
			// of the Google Places API to help users fill in the information.

			// This example requires the Places library. Include the libraries=places
			// parameter when you first load the API. For example:
			// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

			var autocomplete;

			function initAutocomplete() {
				// Create the autocomplete object, restricting the search to geographical
				// location types.
				autocomplete = new google.maps.places.Autocomplete(
					/** @type {!HTMLInputElement} */
					(document.getElementById('location')), {
						types: ['geocode']
					});
			}

			function phoneFormat() { // FUTURE: make phone format work with deleteing numbers
				var el = document.getElementById('phone');
				var phoneNumber = el.value;
				phoneNumber = phoneNumber.replace(/[^0-9|\(\)\-]/g, '');
				if (phoneNumber.length >= 1 && (phoneNumber.charAt(0) != '(' && phoneNumber.charAt(1) != '(' && phoneNumber.charAt(2) != '(')) {
					phoneNumber = '(' + phoneNumber;
				}
				if (phoneNumber.length >= 4 && (phoneNumber.charAt(4) != ')' && phoneNumber.charAt(4) != ')' && phoneNumber.charAt(5) != ')')) {
					phoneNumber = phoneNumber + ')';
				}
				if (phoneNumber.length >= 5 && phoneNumber.charAt(5) != '-' && phoneNumber.charAt(6) != '-') {
					phoneNumber = phoneNumber + "-";
				}
				if (phoneNumber.length >= 9 && phoneNumber.charAt(9) != '-' && phoneNumber.charAt(10) != '-') {
					phoneNumber = phoneNumber + "-";
				}
				if (phoneNumber.length == 14) {
					phoneNumber = phoneNumber.replace(/\D/g, '');
					phoneNumber = phoneNumber.charAt(0) + "(" + phoneNumber.substring(1, 4) + ")-" + phoneNumber.substring(4, 7) + "-" + phoneNumber.substring(7);
				}
				if (phoneNumber.length == 15) {
					phoneNumber = phoneNumber.replace(/\D/g, '');
					phoneNumber = phoneNumber.substring(0, 2) + "(" + phoneNumber.substring(2, 5) + ")-" + phoneNumber.substring(5, 8) + "-" + phoneNumber.substring(8);
				}

				el.value = phoneNumber;
				//alert(phoneNumber);
			}

		</script>
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
              'required' => true,
              'min' => 4,
              'max' => 22
            ),
            'description' => array(
              'max' => 1500,
              'required' => true
            ),
             'date' => array(
              'required' => true,
              'date' => true
              // TODO: chage date rules after today
            ),
             'startTime' => array(
              'required' => true,
              'startTime' => true
            ),
            'endTime' => array(
              'required' => true,
              'endTime' => true
            ),
            'location' => array(
              'required' => true,
              'address' => true
            ),
            'phone' => array(
              'required' => true,
              'phone' => true
            ));
          $image = new ImageProcesser("image");
          $validation = $validator->check($_POST, $rules);
          $formattedDates = formatDates();
          if ($validation->passed() && count($image->getErrors()) === 0) {      // input passed all validaiton
            try {
              $user = new User();
							var_dump($user);
              $place = new Place();
              $place->getPlaceJSON(sanitizeInput($_POST['location']));
              $place->create();
              $phone = new Phone();
              $phone->create(array(Phone::formatNumber(sanitizeInput($_POST['phone']))));
              $gsale = new GarageSale();
              $gsale->create(array(sanitizeInput($_POST['sale_name']), $image->getNewName(), sanitizeInput($_POST['description']), $formattedDates));
              // TODO: create Place, GarageSale, 
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
						<input type="file" id="image" name="image">
					</div>
					<div class="form-group">
						<label for="description">General Description:</label>
						<textarea class="form-control" rows="4" cols="50" id="description" name="description" placeholder="Enter a description of the types of item for sale"><?php echo(isset($_POST['description']) ? sanitizeInput($_POST['description']) : ''); ?></textarea>
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
								<input type="date" class="form-control" id="date1" name="date[]" value="">
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
						<input type="location" class="form-control" id="location" onFocus="geolocate()" name="location" value="<?php echo(isset($_POST['location']) ? sanitizeInput($_POST['location']) : ''); ?>" placeholder="Enter location of sale">
					</div>
					<div class="form-group">
						<label for="phone">Phone:</label>
						<input type="phone" class="form-control" id="phone" name="phone" placeholder="(XXX)-XXX-XXXX" onkeypress="phoneFormat()" value="<?php echo(isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : ''); ?>" maxlength="16">
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
