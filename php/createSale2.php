<?php
    require_once 'init.php';
    require_once 'Objects.php';
//    TODO: uncomment code when page is done
//    $user = new User();
//    if (!$user->isLoggedIn()) {
//        Redirect::page('404.php');
//    }
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
				o.insertBefore(makeDate(numberOfDays++), childList[childList.length - 2]);
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
				var input1 = document.createElement('input');
				var input2 = document.createElement('input');
				var input3 = document.createElement('input');
				row.className = 'row';
				child1.className = 'col-xs-12 col-sm-6';
				child2.className = 'col-xs-12 col-sm-3';
				child3.className = 'col-xs-12 col-sm-3';
				input1.className = 'form-control';
				input2.className = 'form-control';
				input3.className = 'form-control';
				input1.type = 'date';
				input2.type = 'time';
				input3.type = 'time';
				input1.name = 'date[]';
				input2.name = 'startTime[]';
				input3.name = 'endTime[]';
				input1.id = 'date' + number;
				input2.id = 'startTime' + number;
				input3.id = 'endTime' + number;
				row.appendChild(child1);
				row.appendChild(child2);
				row.appendChild(child3);
				child1.appendChild(input1);
				child2.appendChild(input2);
				child3.appendChild(input3);
				return row;
			}

			//-----------------------------------Google maps autocomplete---------------------//
			// This example displays an address form, using the autocomplete feature
			// of the Google Places API to help users fill in the information.

			// This example requires the Places library. Include the libraries=places
			// parameter when you first load the API. For example:
			// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

			var autocomplete;
			//      FUTURE: might be usefull when desplaying multiple locations
			//      var componentForm = {
			//        street_number: 'short_name',
			//        route: 'long_name',
			//        locality: 'long_name',
			//        administrative_area_level_1: 'short_name',
			//        country: 'long_name',
			//        postal_code: 'short_name'
			//      };

			function initAutocomplete() {
				// Create the autocomplete object, restricting the search to geographical
				// location types.
				autocomplete = new google.maps.places.Autocomplete(
					/** @type {!HTMLInputElement} */
					(document.getElementById('location')), {
						types: ['geocode']
					});

				// When the user selects an address from the dropdown, populate the address
				// fields in the form.
				autocomplete.addListener('place_changed', fillInAddress);
			}

			function fillInAddress() {
				// Get the place details from the autocomplete object.
				var place = autocomplete.getPlace();

				//        NOTE: might be used in the future
				//        for (var component in componentForm) {
				//          document.getElementById(component).value = '';
				//          document.getElementById(component).disabled = false;
				//        }

				// Get each component of the address from the place details
				// and fill the corresponding field on the form.
				//        for (var i = 0; i < place.address_components.length; i++) { // var addressType=p lace.address_components[i].types[0]; // // if (componentForm[addressType]) { // var val=p lace.address_components[i][componentForm[addressType]]; // document.getElementById(addressType).value=v al; // } // }
			}

			// Bias the autocomplete object to the user's geographical location,
			// as supplied by the browser's 'navigator.geolocation' object.
			function geolocate() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						var geolocation = {
							lat: position.coords.latitude,
							lng: position.coords.longitude
						};
						var circle = new google.maps.Circle({
							center: geolocation,
							radius: position.coords.accuracy
						});
						autocomplete.setBounds(circle.getBounds());
					});
				}
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
                'max' => 10000, // FIXME: what is description max size?
								'required' => true
              ),
              'address' => array(
                'required' => true,
                'address' => true
              ),
              'phone' => array(
                'required' => true,
                'phone' => true
							),
							'date' => array(
                'required' => true,
                'date' => true
              ),
							'startTime' => array(
                'required' => true,
                'startTime' => true
              ),
							'endTime' => array(
                'required' => true,
                'endTime' => true
								//'after' => 'startTime'
              ));
            $validation = $validator->check($_POST, $rules);
						$place_name = "nunya";
            $image_url = "not_implented.png"; // TODO: need to upload image to downloads folder and create new url and save here
						$fomatedDates = formatDates();
            if ($validation->passed()) {
							$user = new User();
							$gsale = new GarageSale();
							$place = new Place();
							try {
								$address = $_POST['address'];
								$address = explode(",", $address);
								$address = sanitizeInput($address);
								$place = $place->create(array(
									$place_name,
									$address[0],
									$address[1],
									$address[2],
									"",
									$address[3]
								));
								if ($place->exists()) {
									// create garageSale()
									$gsale = $gsale->create(array(
										sanitizeInput($_POST['sale_name']),
										$image_url,
										sanitizeInput($_POST['description']),
										$fomatedDates,
										$place->getData()->place_id,
										$user->data()->user_id
									));
								}
							} catch(Exception $e) {
                die ($e->getMessage());
              }
						} else {
							foreach($validation->getErrors() as $error) {
								echo $error . "<br>";
							}
						}
						Redirect::page("yourSales.php");
          }
        }
      ?>
				<form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="sale_name">Name of sale:</label>
						<input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo (isset($_POST['sale_name']) ? sanitizeInput($_POST['sale_name']) : ''); ?>">
					</div>
					<div class="form-group">
						<input type="file" id="image" name="image">
					</div>
					<div class="form-group">
						<label for="description">General Description:</label>
						<textarea class="form-control" rows="4" cols="50" id="description" name="description"><?php echo (isset($_POST['description']) ? sanitizeInput($_POST['description']) : ''); ?></textarea>
					</div>
					<div id="date-time" class="form-group">
						<div class="row">
							<div class="col-sm-6">
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
							<div class="col-xs-12 col-sm-6">
								<input type="date" class="form-control" id="date1" name="date[]" value="">
							</div>
							<div class="col-xs-12 col-sm-3">
								<input type="time" class="form-control" id="startTime1" name="startTime[]" value="">
							</div>
							<div class="col-xs-12 col-sm-3">
								<input type="time" class="form-control" id="endTime1" name="endTime[]" value="">
							</div>
						</div>
						<div class="row" id="new_text"></div>
						<div class="row">
							<br>
							<div class="col-xs-2 pull-right">
								<button type="button" class="btn btn-default btn-green pull-right" id="add_date" onclick="addDate()">Add Day</button>
							</div>
						</div>
					</div>
					<div id="locationField" class="form-group">
						<label for="location">Location:</label>
						<input type="location" class="form-control" id="location" onFocus="geolocate()" name="address" value="<?php echo (isset($_POST['address']) ? sanitizeInput($_POST['address']) : ''); ?>">
					</div>
					<div class="form-group">
						<label for="phone">Phone:</label>
						<input type="phone" class="form-control" id="phone" name="phone" placeholder="(XXX)-XXX-XXXX" onkeypress="phoneFormat()" value="<?php echo (isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : ''); ?>">
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
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=initAutocomplete" async defer></script>
	</body>

	</html>
