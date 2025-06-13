<div class="container">
	<h1>Filialen & Karte</h1>
	<p>Übersicht unserer Filialen auf der Karte...</p>

	<div class="map-container">
		<div id="map" style="height: 600px; width: 70%; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);"></div>
		<div class="sidebar">
			<div class="search-bar">
				<input type="text" id="searchInput" placeholder="Standort suchen...">
				<button onclick="findNearestLocation()">Meine Position</button>
			</div>
			<div id="locationList" class="location-list"></div>
		</div>
	</div>
</div>

<script>
	function initMap() {
		var mapDiv = document.getElementById('map');
		if (!mapDiv) {
			console.error('Element #map wurde nicht gefunden!');
			return;
		}
		console.log('Karte wird initialisiert...');
		var map = new google.maps.Map(mapDiv, {
			center: {lat: 48.190077, lng: 15.586661},
			zoom: 8
		});
		var locationsStr = '<?php echo addslashes(str_replace("\r\n", "\\n", $locations)); ?>';
		try {
			var locations = JSON.parse(locationsStr);
			if (Array.isArray(locations)) {
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
					addToLocationList(location, marker);
				});
			}
		} catch (e) {
			console.error('Fehler beim Parsen von JSON:', e, 'Rohdaten:', locationsStr);
		}
	}

	function addToLocationList(location, marker) {
		var list = document.getElementById('locationList');
		var div = document.createElement('div');
		div.className = 'location-item';
		div.innerHTML = '<h3>' + location.name + '</h3><p>' + location.address + ', ' + location.zip_code + ' ' + location.city + '</p><p>Öffnungszeiten: ' + location.opening_hours + '</p>';
		div.onclick = function() {
			map.setCenter(marker.getPosition());
			map.setZoom(12);
			infowindow.open(map, marker);
		};
		list.appendChild(div);
	}

	function findNearestLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				var map = new google.maps.Map(document.getElementById('map'), {
					center: userLatLng,
					zoom: 10
				});

				// Marker für aktuelle Position (blauer Pfeil)
				var userMarker = new google.maps.Marker({
					position: userLatLng,
					map: map,
					icon: {
						path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
						scale: 5,
						fillColor: '#1a73e8',
						fillOpacity: 1,
						strokeWeight: 1
					},
					title: 'Meine Position'
				});

				var locations = JSON.parse('<?php echo addslashes(str_replace("\r\n", "\\n", $locations)); ?>');
				var distances = locations.map(function(location) {
					var locLatLng = new google.maps.LatLng(parseFloat(location.latitude), parseFloat(location.longitude));
					return {
						location: location,
						distance: google.maps.geometry.spherical.computeDistanceBetween(userLatLng, locLatLng)
					};
				}).sort(function(a, b) { return a.distance - b.distance; });

				var nearest = distances[0];
				var nextNearest = distances[1] || nearest;

				locations.forEach(function(location) {
					var marker = new google.maps.Marker({
						position: {lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)},
						map: map,
						title: location.name
					});
					if (location.name === nearest.location.name) {
						marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
					} else if (location.name === nextNearest.location.name) {
						marker.setIcon('http://maps.google.com/mapfiles/ms/icons/yellow-dot.png');
					}
					var infowindow = new google.maps.InfoWindow({
						content: '<h3>' + location.name + '</h3><p>' + location.address + ', ' + location.zip_code + ' ' + location.city + '</p>'
					});
					marker.addListener('click', function() {
						infowindow.open(map, marker);
					});
				});

				var list = document.getElementById('locationList');
				list.innerHTML = '';
				[nearest, nextNearest].forEach(function(item) {
					addToLocationList(item.location, new google.maps.Marker({
						position: {lat: parseFloat(item.location.latitude), lng: parseFloat(item.location.longitude)},
						map: map
					}));
				});
			}, function() {
				alert('Geolokation ist nicht verfügbar.');
			});
		} else {
			alert('Ihr Browser unterstützt keine Geolokation.');
		}
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap&libraries=geometry" async defer></script>

<style>
	.container {
		font-family: 'Arial', sans-serif;
		max-width: 1200px;
		margin: 0 auto;
		padding: 20px;
		color: #333;
	}
	h1 {
		font-size: 2.5em;
		color: #1a73e8;
		margin-bottom: 10px;
	}
	p {
		font-size: 1.1em;
		color: #666;
		margin-bottom: 20px;
	}
	.map-container {
		display: flex;
		justify-content: space-between;
		gap: 20px;
	}
	#map {
		flex: 0 0 70%;
		border-radius: 10px;
		overflow: hidden;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
	}
	.sidebar {
		flex: 0 0 28%;
		background: #fff;
		border-radius: 10px;
		padding: 15px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		height: 600px;
		overflow-y: auto;
	}
	.search-bar {
		margin-bottom: 15px;
	}
	.search-bar input {
		width: 70%;
		padding: 8px;
		border: 1px solid #ddd;
		border-radius: 5px;
		margin-right: 10px;
		font-size: 1em;
	}
	.search-bar button {
		padding: 8px 15px;
		background-color: #1a73e8;
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		font-size: 1em;
	}
	.search-bar button:hover {
		background-color: #1557b0;
	}
	.location-list {
		margin-top: 10px;
	}
	.location-item {
		margin-bottom: 15px;
		padding: 10px;
		border: 1px solid #eee;
		border-radius: 5px;
		background: #f9f9f9;
		cursor: pointer;
		transition: background 0.3s;
	}
	.location-item:hover {
		background: #e0e0e0;
	}
	.location-item h3 {
		margin: 0 0 5px;
		font-size: 1.2em;
		color: #1a73e8;
	}
	.location-item p {
		margin: 0;
		font-size: 0.9em;
		color: #555;
	}
</style>
