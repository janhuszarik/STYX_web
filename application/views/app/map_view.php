<div class="container">
	<h1><?php echo $title; ?></h1>
	<p><?php echo $description; ?></p>

	<div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>

	<div class="location-list">
		<?php
		$locations_array = json_decode($locations, true);
		if ($locations_array) {
			foreach ($locations_array as $loc) {
				echo '<div class="location-item">';
				echo '<h3>' . htmlspecialchars($loc['name']) . '</h3>';
				echo '<p>' . htmlspecialchars($loc['address']) . ', ' . htmlspecialchars($loc['zip_code']) . ' ' . htmlspecialchars($loc['city']) . '</p>';
				echo '<p>Öffnungszeiten: ' . htmlspecialchars($loc['opening_hours']) . '</p>';
				echo '</div>';
			}
		} else {
			echo '<p>Žiadne pobočky na zobrazenie.</p>';
		}
		?>
	</div>

	<?php echo '<pre>Debug $locations: ' . htmlspecialchars($locations) . '</pre>'; ?>

	<script>
		function initMap() {
			var mapDiv = document.getElementById('map');
			if (!mapDiv) {
				console.error('Element #map nebol nájdený!');
				return;
			}
			console.log('Map div found, initializing map...');
			var map = new google.maps.Map(mapDiv, {
				center: {lat: 48.190077, lng: 15.586661},
				zoom: 8
			});
			var locationsStr = '<?php echo addslashes($locations); ?>';
			console.log('Raw Locations String:', locationsStr);
			try {
				var locations = JSON.parse(locationsStr.replace(/\\r\\n/g, '\n'));
				console.log('Parsed Locations:', locations);
				if (Array.isArray(locations)) {
					locations.forEach(function(location) {
						console.log('Processing location:', location);
						var marker = new google.maps.Marker({
							position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
							map: map,
							title: location.name
						});
						var infowindow = new google.maps.InfoWindow({
							content: '<h3>' + location.name + '</h3><p>' + location.address + ', ' + location.zip_code + ' ' + location.city + '</p>'
						});
						marker.addListener('click', function() {
							infowindow.open(map, marker);
						});
					});
				} else {
					console.error('Locations nie je pole:', locations);
				}
			} catch (e) {
				console.error('Chyba pri parsovaní JSON:', e, 'Raw string:', locationsStr);
			}
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap" async defer></script>

	<style>
		.location-item { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; }
		.location-item h3 { margin: 0 0 5px; }
		.location-item p { margin: 0; }
	</style>
