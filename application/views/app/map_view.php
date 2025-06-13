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

<section class="map-section py-5">
	<div class="container">
		<h1 class="mb-3">Filialen & Karte</h1>
		<p class="text-muted">Übersicht unserer Filialen auf der Karte</p>

		<div class="map-container">
			<div id="map" class="map-area"></div>
			<div class="sidebar">
				<div class="search-bar">
					<input type="text" id="searchInput" placeholder="Standort suchen...">
					<i class="fas fa-crosshairs location-icon" onclick="findNearestLocation()" title="Meine Position"></i>
				</div>
				<div id="locationList" class="location-list"></div>
			</div>
		</div>

		<div id="modal" class="modal">
			<div class="modal-card">
				<div class="modal-header">
					<div class="modal-logo-container">
						<img id="modalLogo" src="" alt="Logo" class="modal-logo">
					</div>
					<div class="modal-title-container">
						<h2 class="modal-title" id="modalTitle">Firmenname</h2>
					</div>
					<span class="close" onclick="closeModal()">×</span>
				</div>
				<ul class="modal-body info-list">
					<li><i class="fas fa-map-marker-alt"></i> <span id="modalAddress"></span>, <span id="modalZip"></span> <span id="modalCity"></span></li>
					<li><i class="fas fa-user"></i> <span id="modalContactPerson"></span></li>
					<li><i class="fas fa-envelope"></i> <span id="modalEmail"></span></li>
					<li><i class="fas fa-phone-alt"></i> <span id="modalPhone"></span></li>
					<li><i class="fas fa-clock"></i> <span id="modalHours"></span></li>
				</ul>
				<div class="modal-footer">
					<button id="modalWebsite" class="modal-button" data-url="#"><i class="fas fa-globe"></i> Webseite</button>
					<button onclick="planRoute()" class="modal-button"><i class="fas fa-route"></i> Route planen</button>
					<button onclick="shareLocation()" class="modal-button"><i class="fas fa-share-alt"></i> Teilen</button>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.modal-title{
		margin: 0 0 0 10px;
		font-weight: bold;
	}
	.home-intro {
		font-family: 'Poppins', sans-serif;
		font-size: 16px;
	}

	.map-section h1 {
		font-size: 2rem;
		color: #1a73e8;
	}

	.map-section p {
		font-size: 1rem;
		color: #666;
	}

	.map-container {
		display: flex;
		gap: 20px;
		flex-wrap: wrap;
	}

	.map-area {
		flex: 1;
		min-height: 500px;
		border-radius: 8px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
	}

	.sidebar {
		flex: 0 0 300px;
		background: #fff;
		border-radius: 8px;
		padding: 15px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		max-height: 500px;
		overflow-y: auto;
	}

	.search-bar {
		display: flex;
		gap: 10px;
		margin-bottom: 15px;
	}

	.search-bar input {
		flex: 1;
		padding: 8px;
		border: 1px solid #ddd;
		border-radius: 4px;
	}

	.location-icon {
		padding: 8px;
		color: #1a73e8;
		font-size: 1.5rem;
		cursor: pointer;
	}

	.location-icon:hover {
		color: #1557b0;
	}

	.location-item {
		padding: 10px;
		border: 1px solid #eee;
		border-radius: 4px;
		margin-bottom: 10px;
		background: #f9f9f9;
		cursor: pointer;
	}

	.location-item:hover {
		background: #e0e0e0;
	}

	.location-item h3 {
		font-size: 1.1rem;
		color: #1a73e8;
		margin: 0 0 5px;
	}

	.location-item p {
		font-size: 0.9rem;
		color: #555;
		margin: 0;
	}

	.location-item button {
		padding: 5px 10px;
		background: #1a73e8;
		color: #fff;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	.location-item button:hover {
		background: #1557b0;
	}

	.modal {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, 0.6);
		justify-content: center;
		align-items: center;
		z-index: 1000;
		padding: 20px;
	}

	.modal-card {
		background: #fff;
		border-radius: 12px;
		max-width: 600px;
		width: 100%;
		display: flex;
		flex-direction: column;
		animation: fadeIn 0.3s ease-out;
	}

	@keyframes fadeIn {
		from { opacity: 0; transform: translateY(10px); }
		to { opacity: 1; transform: translateY(0); }
	}

	.modal-header {
		display: flex;
		padding: 15px;
		background: #f5f5f5;
		border-radius: 12px 12px 0 0;
		position: relative;
	}

	.modal-logo-container {
		width: 60px;
		height: 60px;
		flex: 0 0 auto;
	}

	.modal-logo {
		width: 100%;
		height: 100%;
		object-fit: contain;
	}

	.modal-title-container {
		flex: 1;
		padding-left: 15px;
	}

	.modal-title {
		font-size: 1.4rem;
		margin: 0;
	}

	.close {
		position: absolute;
		top: 10px;
		right: 15px;
		font-size: 1.5rem;
		color: #999;
		cursor: pointer;
	}

	.modal-body {
		padding: 15px;
		list-style: none;
		margin: 0;
	}

	.info-list li {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
		font-size: 0.9rem;
	}

	.info-list i {
		color: #1a73e8;
		margin-right: 10px;
		min-width: 20px;
	}

	.modal-footer {
		display: flex;
		gap: 10px;
		padding: 15px;
		background: #f5f5f5;
		border-radius: 0 0 12px 12px;
	}

	.modal-button {
		flex: 1;
		padding: 8px;
		background: #1a73e8;
		color: #fff;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 5px;
	}

	.modal-button:hover {
		background: #1557b0;
	}

	@media (max-width: 991px) {
		.map-container {
			flex-direction: column;
		}
		.map-area, .sidebar {
			flex: 0 0 auto;
			width: 100%;
			max-height: 400px;
		}
		.sidebar {
			margin-top: 15px;
		}
	}

	@media (max-width: 768px) {
		.modal-card {
			margin: 20px 10px;
		}
		.modal-header {
			flex-direction: column;
			gap: 10px;
		}
		.modal-logo-container {
			width: 50px;
			height: 50px;
		}
		.modal-title-container {
			padding-left: 0;
		}
		.modal-footer {
			flex-direction: column;
		}
	}
</style>

<script>
	let map, locations;

	function initMap() {
		const mapDiv = document.getElementById('map');
		if (!mapDiv) return console.error('Karten-Element nicht gefunden');

		map = new google.maps.Map(mapDiv, {
			center: { lat: 48.190077, lng: 15.586661 },
			zoom: 8
		});

		try {
			locations = JSON.parse('<?php echo addslashes(str_replace("\r\n", "\\n", $locations)); ?>');
			if (!Array.isArray(locations)) throw new Error('Ungültige Standortdaten');

			const bounds = new google.maps.LatLngBounds();
			locations.forEach(location => {
				const position = { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) };
				bounds.extend(position);

				const marker = new google.maps.Marker({
					position,
					map,
					title: location.name
				});
				const infowindow = new google.maps.InfoWindow({
					content: `<h3>${location.name}</h3><p>${location.address}, ${location.zip_code} ${location.city}</p>`
				});
				marker.addListener('click', () => {
					infowindow.open(map, marker);
					map.setCenter(marker.getPosition());
					map.setZoom(12);
				});
				addToLocationList(location, marker, infowindow);
			});
			map.fitBounds(bounds);
			google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
				if (map.getZoom() > 10) map.setZoom(10);
			});
		} catch (e) {
			console.error('Fehler beim Parsen der Standorte:', e);
		}
	}

	function addToLocationList(location, marker, infowindow) {
		const list = document.getElementById('locationList');
		const div = document.createElement('div');
		div.className = 'location-item';
		div.innerHTML = `
			<h3>${location.name}</h3>
			<p>${location.city}</p>
			<button class="info-btn" data-info='${JSON.stringify(location)}'>Mehr Infos</button>
		`;
		div.addEventListener('click', () => {
			map.setCenter(marker.getPosition());
			map.setZoom(12);
			infowindow.open(map, marker);
		});
		list.appendChild(div);
	}

	function filterLocations(query) {
		const list = document.getElementById('locationList');
		list.innerHTML = '';
		const filtered = locations.filter(loc =>
			loc.name.toLowerCase().includes(query.toLowerCase()) ||
			loc.city.toLowerCase().includes(query.toLowerCase())
		);
		filtered.forEach(loc => {
			const marker = new google.maps.Marker({
				position: { lat: parseFloat(loc.latitude), lng: parseFloat(loc.longitude) },
				map,
				title: loc.name
			});
			const infowindow = new google.maps.InfoWindow({
				content: `<h3>${loc.name}</h3><p>${loc.address}, ${loc.zip_code} ${loc.city}</p>`
			});
			marker.addListener('click', () => {
				infowindow.open(map, marker);
				map.setCenter(marker.getPosition());
				map.setZoom(12);
			});
			addToLocationList(loc, marker, infowindow);
		});
	}

	document.addEventListener('input', e => {
		if (e.target.id === 'searchInput') {
			filterLocations(e.target.value);
		}
	});

	document.addEventListener('click', e => {
		if (e.target.classList.contains('info-btn')) {
			const { name, address, zip_code, city, opening_hours, contact_person, email, phone, website, logo } = JSON.parse(e.target.dataset.info);
			showModal({ name, address, zip: zip_code, city, hours: opening_hours, contact: contact_person, email, phone, website, logo });
		}
	});

	function showModal({ name, address, zip, city, hours, contact, email, phone, website, logo }) {
		const modal = document.getElementById('modal');
		const fields = {
			modalTitle: name,
			modalAddress: address,
			modalZip: zip,
			modalCity: city,
			modalContactPerson: contact || 'Nicht verfügbar',
			modalEmail: email || 'Nicht verfügbar',
			modalPhone: phone || 'Nicht verfügbar',
			modalHours: hours || 'Nicht verfügbar'
		};
		Object.entries(fields).forEach(([id, value]) => document.getElementById(id).textContent = value);

		const websiteBtn = document.getElementById('modalWebsite');
		websiteBtn.setAttribute('data-url', website || '#');
		websiteBtn.onclick = () => website && website !== '#' ? window.open(website, '_blank') : alert('Webseite nicht verfügbar');

		const logoElement = document.getElementById('modalLogo');
		const base = '<?= base_url("uploads/") ?>';
		logoElement.src = logo ? (logo.startsWith('http') || logo.startsWith('/') ? logo : base + logo) : '<?= base_url("img/logo_default.png") ?>';
		logoElement.alt = name;

		modal.style.display = 'flex';
	}

	function closeModal() {
		document.getElementById('modal').style.display = 'none';
	}

	function planRoute() {
		const address = `${document.getElementById('modalAddress').textContent}, ${document.getElementById('modalZip').textContent} ${document.getElementById('modalCity').textContent}`;
		if (!navigator.geolocation) {
			const url = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(address)}`;
			window.open(url, '_blank');
			return;
		}

		navigator.geolocation.getCurrentPosition(pos => {
			const origin = `${pos.coords.latitude},${pos.coords.longitude}`;
			const url = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${encodeURIComponent(address)}`;
			window.open(url, '_blank');
		}, () => {
			const url = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(address)}`;
			window.open(url, '_blank');
		});
	}

	function shareLocation() {
		const url = window.location.href;
		const title = document.getElementById('modalTitle').textContent;
		if (navigator.share) {
			navigator.share({ title, url }).catch(console.error);
		} else {
			navigator.clipboard.writeText(url).then(() => alert('Link in die Zwischenablage kopiert'));
		}
	}

	function findNearestLocation() {
		if (!navigator.geolocation) return alert('Geolokation wird nicht unterstützt');

		navigator.geolocation.getCurrentPosition(pos => {
			const userLatLng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
			map.setCenter(userLatLng);
			map.setZoom(10);

			new google.maps.Marker({
				position: userLatLng,
				map,
				icon: { path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, scale: 5, fillColor: '#1a73e8', fillOpacity: 1, strokeWeight: 1 },
				title: 'Meine Position'
			});

			const distances = locations.map(loc => ({
				location: loc,
				distance: google.maps.geometry.spherical.computeDistanceBetween(userLatLng, new google.maps.LatLng(parseFloat(loc.latitude), parseFloat(loc.longitude)))
			})).sort((a, b) => a.distance - b.distance);

			const list = document.getElementById('locationList');
			list.innerHTML = '';
			[distances[0], distances[1] || distances[0]].forEach(item => {
				const marker = new google.maps.Marker({
					position: { lat: parseFloat(item.location.latitude), lng: parseFloat(item.location.longitude) },
					map
				});
				const infowindow = new google.maps.InfoWindow({
					content: `<h3>${item.location.name}</h3><p>${item.location.address}, ${item.location.zip_code} ${item.location.city}</p>`
				});
				marker.addListener('click', () => {
					infowindow.open(map, marker);
					map.setCenter(marker.getPosition());
					map.setZoom(12);
				});
				addToLocationList(item.location, marker, infowindow);
			});
		}, () => alert('Geolokation nicht verfügbar'));
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap&libraries=geometry" async defer></script>
