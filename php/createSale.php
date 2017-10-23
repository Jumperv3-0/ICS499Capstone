<?php
	require_once 'init.php';
    require_once 'Objects.php';
    require_once 'functions.php';
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
				$pageBuilder = new RegisterPage();
				$pageBuilder->getHeader();
       ?>
		</header>
		<div class="container">
			<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {                // check to see a form was submited by $_POST
					if (isset($_POST['submit'])) {                         // check to see if data was submitted
                        if (Token::check(sanitizeInput($_POST['token']))) {// protects agains resumitting form multiple times
                            $validator = new Validation();                  // creates new validation object
                            $validation = $validator->check($_POST, array(  // calles check function giving it submit type and an array of rules
                                'sale_name' => array(        // rules for sale name
                                    'required' => true,     // cant be empty
                                    'min' => 4,             // min length is 4 char
                                    'max' => 22,            // max length is 22 char
                                    'unique' => 'sale_name'     // username must be unique in sale_name table
                                ),
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["image"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
{
    echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["image"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
                                ),
                                echo "Optional";
                                'description' => array(
                                    'required' => false,
                                    'min' => 0,
                                    'max' => 35,
                                ),
                                $time = strtotime($_POST['dateStart']);
                                if ($time != false){
                                  $start_date = date('Y-m-d', $time));
                                  echo $start_date;
                                }
                                else{
                                   echo 'Invalid Date: ' . $_POST['dateStart'];
                                }
                                ),
                                $time = strtotime($_POST['dateEnd']);
                                if (time != false && time > start_date){
                                  $end_date = date('Y-m-d', $time));
                                  echo $new_date;
                                }
                                else{
                                   echo 'Invalid Date: ' . $_POST['dateEnd'];
                                }
                                ),
                                    'Location' => array(
                                    'required' => true,
                                    'min' => ,6
                                    'max' => 75,
                                    'email' => true         // Change to Google maps test.
                                )
                                    'phone' => array(
                                    'required' => true,
                                    'min' => ,6
                                    'max' => 15,
                                )
                            ));
                            if ($validation->passed()) { // create place then create sale for user
                                $sale = new sale();
                                try {
                                    $sale->create(array(
                                        sanitizeInput($_POST['sale_name']),
                                        sanitizeInput($_FILES["fileToUpload"]["image"]),
                                        sanitizeInput($_POST['description']),
                                        sanitizeInput($_POST['start_date']),
                                        sanitizeInput($_POST['end_date'])
																		));
                                } catch(Exception $e) {
                                    die ($e->getMessage());
                                }
                                Session::flash('success', 'You registered successfully!');
                                Redirect::page('yourSales.php');
                            } else { // Display errors
                               foreach($validation->getErrors() as $error) {
                                   echo $error . "<br>";
                               }
                            }
                        }
					}
				}
			?>
				<form action="<?php echo sanitizeInput($_SERVER['PHP_SELF']); ?>" method="post">
					<div class="form-group">
						<label for="sale_name">Name of sale:</label>
						<input type="text" class="form-control" id="sale_name" name="sale_name" value="<?php echo (isset($_POST['sale_name']) ? sanitizeInput($_POST['sale_name']) : " "); ?>">
					</div>
					<div class="form-group">
						$(".drop-files-container").bind("drop", function(e) { var files = e.originalEvent.dataTransfer.image; processFileUpload(image); // forward the image object to your ajax upload method return false; });
					</div>
					<div class="form-group">
						<label for="description">General Description:</label>
						<input type="description" class="form-control" id="description" name="description">
					</div>
					<div class="form-group">
						<label for="start_date">Start Date:</label>
						<input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo (isset($_POST['start_date']) ? sanitizeInput($_POST['start_date']) : " "); ?>">
					</div>
					<div class="form-group">
						<label for="end_date">End Date:</label>
						<input type="text" class="form-control" id="end_date" name="end_date" value="<?php echo (isset($_POST['end_date']) ? sanitizeInput($_POST['end_date']) : " "); ?>">
					</div>
					<div class="form-group">
						<label for="location">Location:</label>
						<input type="location" class="form-control" id="location" name="location" value="<?php echo (isset($_POST['location']) ? sanitizeInput($_POST['location']) : " "); ?>">
					</div>
					<div class="form-group">
						<label for="phone">Phone:</label>
						<input type="phone" class="form-control" id="phone" name="phone" value="<?php echo (isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : " "); ?>">
					</div>
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<button type="submit" class="btn btn-default" name="submit">Submit</button>
				</form>
		</div>
		<footer>
			<?php
        PageBuilder::getFooter();
      ?>
		</footer>
	</body>

	</html>
