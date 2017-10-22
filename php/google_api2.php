<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Map api 2.0</title>
	<meta name="viewport" content="initial-scale=1.0">
	<style>
		#map {
			width: 100%;
			height: 400px;
		}

	</style>
</head>

<body>
	<h1>Google map 2</h1>
	<div id="map"></div>

	<script>
		function initMap() {
			// Map options
			var options = {
				zoom: 8,
				center: {
					lat: 42.3601,
					lng: -71.0589
				}
			}

			// New map
			var map = new google.maps.Map(document.getElementById('map'), options);

			// Add marker
			var marker = new google.maps.Marker({
				position: {
					lat: 42.4668,
					lng: -70.9495
				},
				map: map,
				//icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
			});
			var infoWindow = new google.maps.InfoWindow({
				content: '<h3>Lynn MA</h3>'
			});
			// open window listener on click
			marker.addListener('click', function() {
				infoWindow.open(map, marker);
			});
		}

	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDn4zPdPO8C7P1s-4YoVPG_FuMabLYqVcw&callback=initMap" async defer></script>
</body>

</html>
