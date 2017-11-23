<?php
// TODO: create validator check for index
if (isset($_GET['lat']) && isset($_GET['lng']) && isset($_GET['index'])) {
  $validator = new Validation();
  $validation = $validator->check($_GET, array(
    'lat' => array('required' => true, 'lat' => true),
    'lng' => array('required' => true, 'lng' => true)));
  if (isset($_GET['lat']) && isset($_GET['lng']) && $validation->passed()) {  // user input passed validation checks
    $lat = sanitizeInput($_GET['lat']);
    $lng = sanitizeInput($_GET['lng']);
    $index = sanitizeInput($_GET['index']);
  } else {
    foreach($validation->getErrors() as $error) {
      echo $error . '<br>';
    }
    $lat = 39.8283;
    $lng = -98.5795;
    $index = 0;
  }
} else {
  $lat = 39.8283;
  $lng = -98.5795;
  $index = 0;
}
/**
 * Gets that sales closest to the provided lat and lng
 * @author Gary
 * @param string $lat        of location
 * @param string $lng        of location
 * @param integer [$size = 5] number of sales to get from db, default 5
 */
function getClosestSales($lat, $lng, $index, $size = 5) {
  // NOTE: Limit can not be dynamic and must be a number
  $db_conn = SqlManager::getInstance();
  $sql = "SELECT *,SQRT(POWER(? - p.lat, 2) + POWER(? - p.lng,2)) AS Distance FROM places AS p
	         JOIN garage_sales_places AS g_fk ON p.place_id = g_fk.place_fk_id
          JOIN (SELECT g.gsale_id FROM garage_sales AS g WHERE DATE(RIGHT(g.dates, 10)) >= CURRENT_DATE) g ON g.gsale_id = g_fk.garage_sale_fk_id
        WHERE p.place_id > ? ORDER BY Distance ASC LIMIT " . $size;
  $params = array($lat, $lng, $index);
  $result = $db_conn->query($sql,$params);
  if (!$result->getError()) {
    return $result->getResult();
  }
}


function addMarkers($placeData, $gsaleData) {
  $markers = "";
  $listener = "";
  $charIndex = 0;
  $chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  $lat = $placeData[0]->lat;
  $lng = $placeData[0]->lng;
  $sales = $gsaleData[0];
  // FIXME: change to count $gsaleData
  // FIXME: fix error with multiple sales at the same location
  for($i = 0; $i < count($placeData); $i++) {
    $listener .= "google.maps.event.addDomListener(document.getElementById('sale{$i}'), 'click', function() {centerMap({lat: " . $placeData[$i]->lat . ", lng: " . $placeData[$i]->lng . "})});";
    $markers .= $listener. "addMarker(new Marker({lat: " . $placeData[$i]->lat . ", lng: " . $placeData[$i]->lng . "}, '<h7>" . $gsaleData[$i][0]->sale_name . "</h7>', '$chars[$charIndex]'));";
    $charIndex++;
  }
  return $markers;
}

?>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 pull-right">
      <div class="map-search" id="map_search">
        <div class="map-search-title" id="map-search-title">
          <h4>Search for sales</h4>
        </div>
        <div class="">
          <input type="text" class="map-search-input form-control" id="map_search_input" placeholder="Enter a location to see nearby sales">
        </div>
      </div>
      <div id="map"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
      <?php
      $table = new SalesListTable();
      $table->getTable($lat, $lng, $index);
      //var_dump($table->getGsales()[0]);
      //var_dump($table->getPlaces());
      ?>
    </div>
  </div>

</div>
<script>
  var map, loadLocation = true;
  var zoom = 12;
  var bounds;
  var markers = [];
  var initial = true;
  var center;

  /**
     * Adds a marker to the map
     * @author Gary
     * @param {Marker}  place that you want to place the mark
     */
  function addMarker(place) {
    var marker = new google.maps.Marker({
      position: place.coords,
      map: map
      //label: place.label
      //icon: 'image_url'
    });
    if (place.message) {
      var infoWindow = new google.maps.InfoWindow({
        content: place.message
      });
      marker.addListener('click', function() {
        infoWindow.open(map, marker);
      });
    }
    if (place.label) {
      marker.setLabel(place.label);
    }
    markers.push(marker);
  }

  //  function removeAllMarkers() {
  //    for (var i = 0; i < markers.length; i++) {
  //      markers[i].setMap(null);
  //    }
  //  }

  function resetBounds() {
    // fit all markers into window
    bounds = new google.maps.LatLngBounds();
    for (var i = 0; i < markers.length; i++) {
      bounds.extend(markers[i].getPosition());
    }
    map.fitBounds(bounds);
  }

  /**
     * Funcion creates a marker object and sets it coords
     * message and label
     * @author Gary
     * @param {object} coords  lat and lng
     * @param {string} message to be displayed on click
     * @param {string} label   for the marker
     */
  function Marker(coords, message, label) {
    this.coords = coords;
    this.message = message;
    if (label) {
      this.label = label;
    }
  }

  /**
     * Centers the map on given coordinates
     * @author Gary
     * @param {object} coords lat and lng
     * @param {number} zoom   level 1 - 17
     */
  function centerMap(coords, zoom) {
    map.setCenter(coords);
    if (zoom) {
      map.setZoom(zoom);
    }
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

  /**
     * Displays error if location is disabled or is not supported
     * @author Gary
     * @param {boolean} browserHasGeolocation true if browser has location, else false
     */
  function handleLocationError(browserHasGeolocation) {
    browserHasGeolocation ? window.alert('Error: Please enable location to see sales near you') : window.alert('Error: Your browser doesn\'t support geolocation.');
  }


  /**
     * Returns a string for _GET variables of lat and lng
     * @author Gary
     * @param   {object} location coords
     * @returns {string}   lat and lng _GET variables
     */
  function parseLatLng(location) {
    return "?lat=" + location.lat() + "&lng=" + location.lng();
  }

  /**
     * Removes all get variables from url
     * @author Gary
     * @param   {string}   url of webpage
     * @returns {string} url without get variables
     */
  function removeOldLocation(url) {
    var array = url.split("?");
    return array[0];
  }

  /**
     * Initializes the google map
     * @author Gary
     */
  function initMap() {
    // default map center option if geolocation not supported or not enabled
    var default_options = {
      center: {
        lat: 39.8283,
        lng: -98.5795
      },
      zoom: 4,
      //maxZoom: 11
    };

    var card = document.getElementById('map_search');
    var map_tag = document.getElementById('map');
    var input = document.getElementById('map_search_input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    map = new google.maps.Map(map_tag, default_options);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
    autocomplete.bindTo('bounds', map);



    <?php echo addMarkers($table->getPlaces(), $table->getGsales()); ?>

    var currentPage = document.location.href;
    if (currentPage.indexOf("?lat") === -1 && currentPage.indexOf("?lng") === -1) {
      getCurrentLocation(function(responce) {
        document.location.href = currentPage + "?lat=" + responce["lat"] + "&lng=" + responce['lng'] + "&index=0";
      });
    } else {
      centerMap({
        lat: <?php echo $lat;?>,
        lng: <?php echo $lng;?>
      }, zoom - 2);
      addMarker(new Marker({
        lat: <?php echo $lat;?>,
        lng: <?php echo $lng;?>
      }, '<h7>Your Location</h7>'));
      resetBounds();
    }
    // TODO: check to see what happens with location services disabled
    // makes search change location of map
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        window.alert("Unable to find " + place.name);
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        var currentPage = removeOldLocation(document.location.href);
        document.location.href = currentPage + parseLatLng(place.geometry.location) + "&index=0";

      } else {
        var currentPage = removeOldLocation(document.location.href);
        document.location.href = currentPage + parseLatLng(place.geometry.location) + "&index=0";
      }
    });


    google.maps.event.addListener(map, "zoom_changed", function() {
      if (initial) {
        if (map.getZoom() > 11) {
          map.setZoom(11);
          initial = false;
        }
      }
    });

    google.maps.event.addDomListener(map, 'idle', function() {
      center = map.getCenter();
    });
    google.maps.event.addDomListener(window, 'resize', function() {
      map.setCenter(center);
    });
  }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=initMap" async defer></script>
