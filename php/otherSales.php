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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <style>
      #map {
        width: 100%;
        height: 450px;
      }

      .map-search-title {
        color: #fff;
        background-color: #526747;
        font-size: 25px;
        font-weight: 500;
        padding: 3px 12px;
        /*
        border-top-left-radius: 1em;
        border-top-right-radius: 1em;
        */
      }

      .map-search-input {
        display: inline;
        background-color: #fff;
        padding: 0 0 0 5px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
      }

      .map-search {
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        display: inline;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        border-radius: 3em;
        width: 45%;
        min-width: 200px;
      }

      img {
        max-width: 250px;
        width: 100%;
      }

      i {

      }

    </style>
  </head>

  <body>
    <header>
      <?php
  $pageBuilder = new SalesPage();
      $pageBuilder->getHeader();
      ?>
    </header>
    <div class="container">
      <h1>Sales</h1>
    </div>
    <?php
    $gsale = new GarageSale();
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['gsale_id'])) {
      if ($gsale->find(sanitizeInput($_GET['gsale_id']))) {
        var_dump($gsale->getData());
      } else {
        echo "false";
      }
    } else {
      include 'auto-complete-map.php';
    }
    ?>

    <div class="container">
      <div class="well">
        <div class="row">
          <h3 class="text-center">First Test</h3>
        </div>
        <div class="row">
          <div class="col-sm-3">
            <img src="https://dummyimage.com/200x200/878787/fff.png&text=Garage Sale">
          </div>
          <div class="col-sm-8">
            <div class="row">
              <h3>Dates:</h3>
              <div class="col-sm-2">
                <p>11/4/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <div class="col-sm-2">
                <p>11/5/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <!--<div class="col-sm-2">
                <p>11/4/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <div class="col-sm-2">
                <p>11/5/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <div class="col-sm-2">
                <p>11/4/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <div class="col-sm-2">
                <p>11/5/2017</p>
                <p>10:00am-3:00pm</p>
              </div>
              <div class="col-sm-2">
                <p>11/4/2017</p>
                <p>10:00am-3:00pm</p>
              </div>-->
            </div>
            <div class="row">

            </div>
          </div>
        </div>
        <div class="row">

          <div class="col-sm-3">
           <h3>Location:</h3>
            <p>2016 Zircon Lane, Eagan MN 55122, US</p>
          </div>

          <div class="col-sm-6">
           <h3>Description:</h3>
            <p>This is our first test of a garage sale. It is not a real one but a fake one. Why are you still reading this text its pointless. Did you want some useful information lol, look elsewhere.</p>
          </div>
          <div class="col-sm-2">
            <h3>&nbsp;</h3>
            <a class="btn btn-green-no-padding" href="?gsale_id=1&directions=true">Show Directions<i class="material-icons">directions</i></a>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <h3>Items:</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">
            <img src="https://dummyimage.com/200x200/878787/fff.png&text=Item">
          </div>

          <div class="col-sm-2">
            <h3>Name:</h3>
            <p>Name: $500.63</p>
          </div>
          <div class="col-sm-2">
            <h3>Price:</h3>
            <p>$500.63</p>
          </div>
          <div class="col-sm-7">
            <h3>description</h3>
            <p>This is our first test of a garage sale. It is not a real one but a fake one. Why are you still reading this text its pointless. Did you want some useful information lol, look elsewhere.</p>
          </div>
        </div>
        <div class="row"><p></p></div>
        <div class="divider"></div>
        <div class="row">
          <div class="col-sm-3">
            <img src="https://dummyimage.com/200x200/878787/fff.png&text=Item">
          </div>

          <div class="col-sm-2">
            <h3>Name:</h3>
            <p>Blazing Sword</p>
          </div>
          <div class="col-sm-2">
            <h3>Price:</h3>
            <p>$500.63</p>
          </div>
          <div class="col-sm-7">
            <h3>description</h3>
            <p>This is our first test of a garage sale. It is not a real one but a fake one. Why are you still reading this text its pointless. Did you want some useful information lol, look elsewhere.</p>
          </div>
        </div>
      </div>
    </div>



    <div class="container">
      <!--TODO: make sales dynamic and add link to sale and get directions?-->
      <h3>Active Sales</h3>
      <div class="panel-group">
        <div class="panel panel-default">
          <div class="panel-heading" data-toggle="collapse" data-target="#collapse1">
            <h4 class="panel-title">
              <h5 class="collapse-header">Location:</h5>
              <p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
              <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
            </h4>
          </div>
          <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="row text-center">
                <a class="" href="#">Name: Bob's Bouncy House</a>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <img src="http://lorempixel.com/g/100/100/"/>
                </div>
                <div class="col-sm-4">
                  <h5 class="collapse-header">Date:</h5>
                  <p>Mon, Oct 16 - Sun, Oct 19</p>
                </div>
                <div class="col-sm-5">
                  <h5 class="collapse-header">Description:</h5>
                  <p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" data-toggle="collapse" data-target="#collapse2">
            <h4 class="panel-title">
              <h5 class="collapse-header">Location:</h5>
              <p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
              <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
            </h4>
          </div>
          <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="row text-center">
                <a class="" href="#">Name: Bob's Bouncy House</a>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <img src="http://lorempixel.com/g/100/100/" />
                </div>
                <div class="col-sm-4">
                  <h5 class="collapse-header">Date:</h5>
                  <p>Mon, Oct 16 - Sun, Oct 19</p>
                </div>
                <div class="col-sm-5">
                  <h5 class="collapse-header">Description:</h5>
                  <p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" data-toggle="collapse" data-target="#collapse3">
            <h4 class="panel-title">
              <h5 class="collapse-header">Location:</h5>
              <p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
              <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
            </h4>
          </div>
          <div id="collapse3" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="row text-center">
                <a class="" href="#">Name: Bob's Bouncy House</a>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <img src="http://lorempixel.com/g/100/100/" />
                </div>
                <div class="col-sm-4">
                  <h5 class="collapse-header">Date:</h5>
                  <p>Mon, Oct 16 - Sun, Oct 19</p>
                </div>
                <div class="col-sm-5">
                  <h5 class="collapse-header">Description:</h5>
                  <p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading" data-toggle="collapse" data-target="#collapse4">
            <h4 class="panel-title">
              <h5 class="collapse-header">Location:</h5>
              <p class="collapse-header-text">700 7th Street East Saint Paul, MN 55106</p>
              <span class="glyphicon glyphicon-chevron-down pull-right" aria-hidden="true"></span>
            </h4>
          </div>
          <div id="collapse4" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="row text-center">
                <a class="" href="#">Name: Bob's Bouncy House</a>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <img src="http://lorempixel.com/g/100/100/" />
                </div>
                <div class="col-sm-4">
                  <h5 class="collapse-header">Date:</h5>
                  <p>Mon, Oct 16 - Sun, Oct 19</p>
                </div>
                <div class="col-sm-5">
                  <h5 class="collapse-header">Description:</h5>
                  <p>Huge garage sale with more than 30 families participating. Multiple classrooms/lunchroom will be utilized for the sale. Tons of kids and women's clothing, toys, books, Halloween costumes, Christmas decorations, home décor and furniture. Preview sale ($2 at door): October 19, 4-8pm General sale October 20, 10-6pm and October 21, 10-4pm Pictures to be added prior to sale date.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="text-center">
        <nav aria-label="Page navigation">
          <ul class="pagination pagination-lg">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <footer>
      <?php
      PageBuilder::getFooter();
      ?>
    </footer>
    <script>
      var map, infoWindow, loadLocation = true;
      /**
       * Creates the google map on the page
       * @author Gary
       */
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: 42.877742,
            lng: -97.380979
          }, // default location
          zoom: 4
        });

        var card = document.getElementById('map_search');
        var input = document.getElementById('map_search_input');
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Unable to find " + place.name);
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            map.setZoom(13);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(13);
          }

          setInfoContent(place);
        });

        if (loadLocation) { // FUTURE: current location is not shown on firstLoad
          getCurrentLocation(function(responce) {
            map.setCenter(responce);
            map.setZoom(13);
          });
          loadLocation = false;
        }
      }

      /**
       * Puts the location under the map on the page
       * @author Gary
       * @param {object} place that you are currently at
       */
      function setInfoContent(place) {
        infowindowContent = document.getElementById('infowindow-content');
        var address = '';
        if (place.address_components) {
          address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
          ].join(' ');
        }
        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
      }

      /**
			 * Gets the current location that the user is at if location serverices available
			 * @author Gary
			 * @param {function} callback function to get the data back asynconously
			 */
      function getCurrentLocation(callback) {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            callback(pos);
          }, function() {
            handleLocationError(true);
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false);
        }
      }

      function handleLocationError(browserHasGeolocation) {
        browserHasGeolocation ? window.alert('Error: Please enable location to see sales near you') : window.alert('Error: Your browser doesn\'t support geolocation.');
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=initMap" async defer>


    </script>
  </body>

</html>
