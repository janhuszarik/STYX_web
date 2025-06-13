<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3"><?= $title ?></h1>
				<p class="text-muted lead mb-0"><?= htmlspecialchars($description) ?></p>
			</div>
		</div>
	</div>
</section>

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

	<!-- Modal (karta štýl) -->
	<div id="modal" class="modal">
		<div class="modal-card">
			<div class="modal-header">
				<img id="modalLogo" src="" alt="Logo" class="modal-logo">
				<h2 id="modalTitle" class="modal-firma-name">Firmenname</h2>
				<span class="close" onclick="closeModal()">×</span>
			</div>
			<div class="modal-body">
				<ul class="info-list">
					<li><i class="fas fa-map-marker-alt"></i> <span id="modalAddress"></span>, <span id="modalZip"></span> <span id="modalCity"></span></li>
					<li><i class="fas fa-user"></i> <span id="modalContactPerson"></span></li>
					<li><i class="fas fa-envelope"></i> <span id="modalEmail"></span></li>
					<li><i class="fas fa-phone-alt"></i> <span id="modalPhone"></span></li>
					<li><i class="fas fa-clock"></i> <span id="modalHours"></span></li>
				</ul>
			</div>
			<div class="modal-footer">
				<a id="modalWebsite" href="#" target="_blank" class="modal-action"><i class="fas fa-globe"></i> Webseite</a>
				<button onclick="planRoute()" class="modal-action"><i class="fas fa-route"></i> Route planen</button>
				<button onclick="shareLocation()" class="modal-action"><i class="fas fa-share-alt"></i> Teilen</button>
			</div>
		</div>
	</div>

</div>

<script>
	let map;

	function initMap() {
		const mapDiv = document.getElementById('map');
		if (!mapDiv) {
			console.error('Element #map wurde nicht gefunden!');
			return;
		}

		map = new google.maps.Map(mapDiv, {
			center: { lat: 48.190077, lng: 15.586661 },
			zoom: 8
		});

		const locationsStr = '<?php echo addslashes(str_replace("\r\n", "\\n", $locations)); ?>';
		try {
			const locations = JSON.parse(locationsStr);
			if (Array.isArray(locations)) {
				locations.forEach(function(location) {
					const marker = new google.maps.Marker({
						position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
						map: map,
						title: location.name
					});
					const infowindow = new google.maps.InfoWindow({
						content: `<h3>${location.name}</h3><p>${location.address}, ${location.zip_code} ${location.city}</p>`
					});
					marker.addListener('click', function() {
						infowindow.open(map, marker);
					});
					addToLocationList(location, marker, infowindow);
				});
			}
		} catch (e) {
			console.error('Fehler beim Parsen von JSON:', e, 'Rohdaten:', locationsStr);
		}
	}

	function addToLocationList(location, marker, infowindow) {
		const list = document.getElementById('locationList');
		const div = document.createElement('div');
		div.className = 'location-item';
		div.innerHTML = `
		<h3>${location.name}</h3>
		<p>${location.city}</p>
		<button class="info-btn"
			data-name="${location.name}"
			data-address="${location.address}"
			data-zip="${location.zip_code}"
			data-city="${location.city}"
			data-hours="${location.opening_hours || ''}"
			data-contact="${location.contact_person || ''}"
			data-email="${location.email || ''}"
			data-phone="${location.phone || ''}"
			data-website="${location.website || ''}"
			data-logo="${location.logo || ''}"
		>Mehr Info</button>
	`;

		div.onclick = function () {
			map.setCenter(marker.getPosition());
			map.setZoom(12);
			infowindow.open(map, marker);
		};

		list.appendChild(div);
	}

	// Globálne počúvanie na všetky .info-btn
	document.addEventListener('click', function (e) {
		if (e.target && e.target.classList.contains('info-btn')) {
			const btn = e.target;
			showModal(
				btn.dataset.name,
				btn.dataset.address,
				btn.dataset.zip,
				btn.dataset.city,
				btn.dataset.hours,
				btn.dataset.contact,
				btn.dataset.email,
				btn.dataset.phone,
				btn.dataset.website
			);
		}
	});

	function showModal(name, address, zip, city, hours, contactPerson, email, phone, website, logo = '') {
		document.getElementById('modalTitle').textContent = name;
		document.getElementById('modalAddress').textContent = address;
		document.getElementById('modalZip').textContent = zip;
		document.getElementById('modalCity').textContent = city;
		document.getElementById('modalContactPerson').textContent = contactPerson || 'Nicht verfügbar';
		document.getElementById('modalEmail').textContent = email || 'Nicht verfügbar';
		document.getElementById('modalPhone').textContent = phone || 'Nicht verfügbar';
		document.getElementById('modalWebsite').href = website || '#';
		document.getElementById('modalWebsite').textContent = 'Webseite';
		document.getElementById('modalHours').textContent = hours || 'Nicht verfügbar';

		// Zobraziť logo
		const logoElement = document.getElementById('modalLogo');
		if (logo) {
			logoElement.src = logo.startsWith('http') ? logo : '<?= base_url("uploads/logos/") ?>' + logo;
			logoElement.alt = name;
		} else {
			logoElement.src = '<?= base_url("img/logo_default.png") ?>';
			logoElement.alt = 'Logo';
		}

		document.getElementById('modal').style.display = 'flex';
	}



	function closeModal() {
		document.getElementById('modal').style.display = 'none';
	}

	function planRoute() {
		const address = `${document.getElementById('modalAddress').textContent}, ${document.getElementById('modalZip').textContent} ${document.getElementById('modalCity').textContent}`;
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				const directionsService = new google.maps.DirectionsService();
				const directionsRenderer = new google.maps.DirectionsRenderer();
				directionsRenderer.setMap(map); // Použijeme globálnu mapu
				const request = {
					origin: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
					destination: address,
					travelMode: 'DRIVING'
				};
				directionsService.route(request, function(result, status) {
					if (status === 'OK') {
						directionsRenderer.setDirections(result);
					} else {
						alert('Route konnte nicht berechnet werden.');
					}
				});
			}, function() {
				alert('Geolokation ist nicht verfügbar.');
			});
		} else {
			alert('Ihr Browser unterstützt keine Geolokation.');
		}
	}
	function shareLocation() {
		const url = window.location.href;
		if (navigator.share) {
			navigator.share({
				title: document.getElementById('modalTitle').textContent,
				url: url
			}).catch(console.error);
		} else {
			navigator.clipboard.writeText(url);
			alert('Link wurde in die Zwischenablage kopiert.');
		}
	}


	function findNearestLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				const userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				map.setCenter(userLatLng);
				map.setZoom(10);

				new google.maps.Marker({
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

				const locations = JSON.parse('<?php echo addslashes(str_replace("\r\n", "\\n", $locations)); ?>');
				const distances = locations.map(function(location) {
					const locLatLng = new google.maps.LatLng(parseFloat(location.latitude), parseFloat(location.longitude));
					return {
						location: location,
						distance: google.maps.geometry.spherical.computeDistanceBetween(userLatLng, locLatLng)
					};
				}).sort(function(a, b) {
					return a.distance - b.distance;
				});

				const nearest = distances[0];
				const nextNearest = distances[1] || nearest;

				const list = document.getElementById('locationList');
				list.innerHTML = '';
				[nearest, nextNearest].forEach(function(item) {
					addToLocationList(item.location, new google.maps.Marker({
						position: { lat: parseFloat(item.location.latitude), lng: parseFloat(item.location.longitude) },
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
	/* Základné nadpisy */
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

	/* Layout mapy a bočného panelu */
	.map-container {
		display: flex;
		justify-content: space-between;
		gap: 20px;
		flex-wrap: wrap;
	}
	#map {
		flex: 0 0 70%;
		min-height: 600px;
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
		max-height: 600px;
		overflow-y: auto;
	}

	/* Vyhľadávanie */
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

	/* Zoznam pobočiek */
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
	.location-item button {
		padding: 5px 10px;
		background-color: #1a73e8;
		color: white;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		font-size: 0.9em;
		margin-top: 5px;
	}
	.location-item button:hover {
		background-color: #1557b0;
	}

	/* Modal okno (fixované, centrované, responzívne) */
	.modal {
		display: none; /* ← sem je zásadná oprava */
		position: fixed;
		z-index: 1050;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0,0,0,0.6);
		box-sizing: border-box;
		padding: 20px;
		justify-content: center;
		align-items: center;
		overflow-y: auto;
	}


	.modal-card {
		margin: auto;
		background: #fff;
		border-radius: 15px;
		width: 100%;
		max-width: 700px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
		font-family: 'Poppins', sans-serif;
		display: flex;
		flex-direction: column;
		animation: fadeInUp 0.3s ease-out;
	}

	@keyframes fadeInUp {
		from { transform: translateY(-10px); opacity: 0; }
		to { transform: translateY(0); opacity: 1; }
	}

	.modal-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		background: #f5f5f5;
		padding: 20px;
		position: relative;
	}
	.modal-logo {
		width: 60px;
		height: 60px;
		object-fit: contain;
		margin-right: 20px;
	}
	.modal-firma-name {
		font-size: 1.5em;
		margin: 0;
		flex-grow: 1;
	}
	.modal-header .close {
		position: absolute;
		top: 15px;
		right: 20px;
		font-size: 1.8em;
		color: #999;
		cursor: pointer;
	}

	.modal-body {
		padding: 20px;
		max-height: 60vh;
		overflow-y: auto;
	}
	.info-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.info-list li {
		margin-bottom: 12px;
		font-size: 1em;
		color: #333;
		display: flex;
		align-items: center;
	}
	.info-list i {
		margin-right: 10px;
		color: #1a73e8;
		min-width: 20px;
		text-align: center;
	}

	.modal-footer {
		background: #f5f5f5;
		padding: 15px 20px;
		display: flex;
		justify-content: space-around;
		align-items: center;
		border-top: 1px solid #ddd;
		flex-wrap: wrap;
		gap: 10px;
	}
	.modal-action {
		background: none;
		border: none;
		color: #1a73e8;
		font-size: 1em;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 6px;
		text-decoration: none;
		transition: color 0.3s;
	}
	.modal-action:hover {
		color: #1557b0;
	}

	/* Responsivita */
	@media (max-width: 991px) {
		.map-container {
			flex-direction: column;
		}
		#map, .sidebar {
			width: 100%;
			flex: 0 0 100%;
			height: 400px;
		}
	}
	@media (max-width: 768px) {
		.modal-card {
			margin: 40px 10px;
		}
		.modal-header {
			flex-direction: column;
			align-items: flex-start;
			gap: 10px;
		}
		.modal-firma-name {
			font-size: 1.2em;
		}
		.modal-logo {
			width: 50px;
			height: 50px;
		}
		.modal-footer {
			flex-direction: column;
			gap: 10px;
		}
		.modal-action {
			width: 100%;
			justify-content: center;
		}
	}
	@media (max-width: 480px) {
		.modal-card {
			padding: 10px;
		}
		.modal-header,
		.modal-footer {
			padding: 10px;
		}
	}
</style>

