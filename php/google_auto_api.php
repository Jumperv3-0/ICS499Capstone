<?php
require_once "Objects.php";
?>

<!DOCTYPE html>
<html lang="">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Starter Template for Bootstrap 3.3.7</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <style>
      body {
        padding-top: 50px;
      }

      .starter-template {
        padding: 40px 15px;
        text-align: center;
      }

    </style>

  <!--[if IE]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
    <div class="container">
      <form method="post" action="">
        <fieldset>
          <h1>Auto Complete Example</h1>
          <input type="text" id="location" name="location" class="form-control">
          <input type="submit" id="submit" name="submit" value="Submit">
        </fieldset>
      </form>

      <p id="demo"></p>
      <?php
      if (isset($_POST['location'])) {
        try {
          var_dump(sanitizeInput($_POST['location']));
          $place = new Place();
          $json = $place->getPlaceJSON("?address=" . sanitizeInput($_POST['location']))['results'][0]['geometry']['location'];
          var_dump($json);
        } catch (Exception $e) {
          var_dump($e);
        }

      } else {
        echo "a;lsdkfjlaskdjf";
      }
      ?>
    </div>
    <script>
      var geo_location;

      /**
       * Links location element to google maps auto complete
       */
      function activatePlacesSearch() {
        var location = document.getElementById('location');
        var auto_complete = new google.maps.places.Autocomplete(location);
      }

      // Example of js get request
      function getRequest() {
        if (window.XMLHttpRequest) { // code for modern browsers
          xmlhttp = new XMLHttpRequest();
        } else { // code for old IE browsers
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw", true);
        // TODO: also need to check for error should use onreadystatechange
        xmlhttp.onload = function () {
          geo_location = JSON.parse(xmlhttp.responseText);
        }
      }

    </script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=activatePlacesSearch"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  </body>

</html>
