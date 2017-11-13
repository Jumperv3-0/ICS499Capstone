<div class="container">
  <div class="map-search" id="map_search">
    <div class="map-search-title" id="map-search-title">
      <h4>Search for sales</h4>
    </div>
    <div class="">
      <input type="text" class="map-search-input form-control" id="map_search_input" placeholder="Enter a location to see nearby sales">
    </div>
  </div>
  <div id="map"></div>
  <div id="infowindow-content">
    <h5>Current Location:</h5>
    <img src="" width="16" height="16" id="place-icon">
    <span id="place-name" class="title"></span><br>
    <span id="place-address"></span>
  </div>
</div>
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
