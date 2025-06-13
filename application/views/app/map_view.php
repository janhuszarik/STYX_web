<div class="container">
	<h1><?php echo $title; ?></h1>
	<p><?php echo $description; ?></p>

	<div id="map" style="height: 400px; width: 100%; margin-bottom: 20px;"></div>

	<div class="location-list">
		<?php
		$locations = json_decode($locations, true);
		foreach ($locations as $loc) {
			echo '<div class="location-item">';
			echo '<h3>' . htmlspecialchars($loc['name']) . '</h3>';
			echo '<p>' . htmlspecialchars($loc['address']) . ', ' . htmlspecialchars($loc['zip_code']) . ' ' . htmlspecialchars($loc['city']) . '</p>';
			echo '<p>Öffnungszeiten: ' . htmlspecialchars($loc['opening_hours']) . '</p>';
			echo '</div>';
		}
		?>
	</div>
</div>

<script>
	function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 48.2082, lng: 16.3738}, // Defaultné centrum (Viedeň)
			zoom: 8
		});
		var locations = <?php echo $locations; ?>;
		locations.forEach(function(location) {
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
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap" async defer></script>

<style>
	.location-item { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; }
	.location-item h3 { margin: 0 0 5px; }
	.location-item p { margin: 0; }
</style>
