<?php
// TODO: create validator and check to see if lat and lng in acceptible range
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
  // TODO: need to implement get salse;
  // $sql = "SELECT place_id,SQRT(POWER(? - places.lat, 2) + POWER(? - places.lng,2)) AS Distance FROM places /** optional WHERE place_id > 6 **/ ORDER BY Distance ASC LIMIT ?"
  $db_conn = SqlManager::getInstance();
  $sql = "SELECT place_id,SQRT(POWER(? - places.lat, 2) + POWER(? - places.lng,2)) AS Distance FROM places WHERE place_id > ? ORDER BY Distance ASC LIMIT " . $size;
  $params = array($lat, $lng, $index);
  $result = $db_conn->query($sql,$params);
  if (!$result->getError()) {
    return $result->getResult();
  }
}

function addMarkers() {
  $chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
  // TODO: create strings for markers
  return "addMarker(new Marker({lat: 42.4668, lng: -75.9495}, '<h7>1st location</h7>', 'A'));";
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
      ?>
    </div>
  </div>

</div>
<script>
  var map, loadLocation = true;
  var zoom = 12;
  var bounds;
  var markers = [];

  /**
   * Creates the google map on the page
   * @author Gary
   *
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
        var marker = new google.maps.Marker({
          position: responce,
          map: map,
        });
        var infoWindow = new google.maps.InfoWindow({
          content: '<h7>Your Location</h7>'
        });
        marker.addListener('click', function() {
          infoWindow.open(map, marker);
        });
      });
      loadLocation = false;
    }
  }

  /**
   * Puts the location under the map on the page
   * @author Gary
   * @param {object} place that you are currently at
   *
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
   *
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
  }*/

  /**
   * Adds a marker to the map
   * @author Gary
   * @param {Marker} place that you want to place the mark
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
    //centerMap(markers[0].getPosition());
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
      zoom: 4
    };

    var card = document.getElementById('map_search');
    //var card2 = document.getElementById('map-list-sales');
    var map_tag = document.getElementById('map');
    var input = document.getElementById('map_search_input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    map = new google.maps.Map(map_tag, default_options);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(card2);
    autocomplete.bindTo('bounds', map);



    <?php echo addMarkers(); ?>


    //    addMarker(new Marker({lat: 42.4668, lng: -75.9495}, '<h7>1st location</h7>', 'A'));
    //    addMarker(new Marker({lat: 42.8584, lng: -75.9495}, '<h7>2nd location</h7>', 'B'));

    // gets your location if available
    if (loadLocation) { // NOTE: only show on first load
      getCurrentLocation(function(responce) {
        //        removeAllMarkers();
        //        centerMap(responce, zoom);
        //        addMarker(new Marker(responce, '<h7>Your Location</h7>'));
        var currentPage = document.location.href;
        if (currentPage.indexOf("?lat") === -1 && currentPage.indexOf("?lng") === -1) {
          document.location.href = currentPage + "?lat=" + responce["lat"] + "&lng=" + responce['lng'] + "&index=0";
        } else {
          centerMap({lat:<?php echo $lat;?>,lng:<?php echo $lng;?>}, zoom);
          addMarker(new Marker({lat:<?php echo $lat;?>,lng:<?php echo $lng;?>}, '<h7>Your Location</h7>'));
          resetBounds();
        }
      });
      loadLocation = false;
    }

    // makes search change location of map
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        window.alert("Unable to find " + place.name);
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        //        removeAllMarkers();
        //        map.fitBounds(place.geometry.viewport);
        //        map.setZoom(zoom);
        //        addMarker(new Marker(place.geometry.location, '<h7>Your Locationg</h7>'));
        var currentPage = removeOldLocation(document.location.href);
        document.location.href = currentPage + parseLatLng(place.geometry.location) + "&index=0";

      } else {
        //        removeAllMarkers();
        //        centerMap(place.geometry.location, zoom);
        //        addMarker(new Marker(place.geometry.location, '<h7>Your Location</h7>'));
        var currentPage = removeOldLocation(document.location.href);
        document.location.href = currentPage + parseLatLng(place.geometry.location) + "&index=0";
        //        alert("place has no geometry");
      }
    });
  }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&libraries=places&callback=initMap" async defer></script>
