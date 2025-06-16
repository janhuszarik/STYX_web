<?php
$this->load->view('partials/mapfind_assets');
?>

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
		<p>In den folgenden Geschäften, Märkten und Bio-Läden können Sie unsere STYX-Produkte in Österreich sowie in Deutschland kaufen.<br>
			Bitte beachten Sie, dass nicht alle Produkte in jedem Shop verfügbar sind. <br> Alle Produkte finden Sie in unserem
			<a href="https://shop.styx.at/">Online-Shop</a>.
		</p>
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
					<li class="info-list-item">
						<i class="fas fa-map-marker-alt"></i>
						<div>
							<div class="fw-bold" id="modalFirmName"></div>
							<div id="modalAddress"></div>
							<div><span id="modalZip"></span>, <span id="modalCity"></span></div>
							<div id="modalCountry"></div>
						</div>
					</li>
					<li><i class="fas fa-user"></i> <span id="modalContactPerson"></span></li>
					<li><i class="fas fa-envelope"></i> <span id="modalEmail"></span></li>
					<li><i class="fas fa-phone-alt"></i> <span id="modalPhone"></span></li>
					<li style="align-items: flex-start;">
						<i class="fas fa-clock" style="margin-top: 4px;"></i>
						<div id="modalHours"></div>
					</li>
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
			locations.forEach((location, index) => {
				const position = { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) };
				bounds.extend(position);

				const letter = String.fromCharCode(65 + index); // Generovanie písmena (A, B, C, ...)

				const marker = new google.maps.Marker({
					position,
					map,
					title: location.name,
					icon: {
						url: `https://maps.google.com/mapfiles/marker${letter}.png`
					}
					// Odstránenie labelu, aby sa písmeno nezobrazovalo dvakrát
				});

				const infowindow = new google.maps.InfoWindow({
					content: `<h3>${location.name}</h3><p>${location.address}, ${location.zip_code} ${location.city}</p>`
				});

				marker.addListener('click', () => {
					infowindow.open(map, marker);
					map.setCenter(marker.getPosition());
					map.setZoom(12);
				});

				addToLocationList(location, marker, infowindow, letter);
			});

			map.fitBounds(bounds);
			google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
				if (map.getZoom() > 10) map.setZoom(10);
			});
		} catch (e) {
			console.error('Fehler beim Parsen der Standorte:', e);
		}
	}

	function addToLocationList(location, marker, infowindow, letter) {
		const list = document.getElementById('locationList');
		const div = document.createElement('div');
		div.className = 'location-item';
		div.innerHTML = `
			<h3><span class="letter-icon">${letter}</span>${location.name}</h3>
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

		filtered.forEach((loc, index) => {
			const letter = String.fromCharCode(65 + index); // Generovanie písmena pre filtrovaný zoznam
			const marker = new google.maps.Marker({
				position: { lat: parseFloat(loc.latitude), lng: parseFloat(loc.longitude) },
				map,
				title: loc.name,
				icon: {
					url: `https://maps.google.com/mapfiles/marker${letter}.png`
				}
				// Odstránenie labelu
			});

			const infowindow = new google.maps.InfoWindow({
				content: `<h3>${loc.name}</h3><p>${loc.address}, ${loc.zip_code} ${loc.city}</p>`
			});

			marker.addListener('click', () => {
				infowindow.open(map, marker);
				map.setCenter(marker.getPosition());
				map.setZoom(12);
			});

			addToLocationList(loc, marker, infowindow, letter);
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

	function formatOpeningHours(hoursJson) {
		if (!hoursJson || hoursJson === "{}") {
			return '<span>Keine näheren Informationen verfügbar</span>';
		}

		let html = '<ul style="padding-left: 0; list-style: none;">';
		const days = {
			monday: 'Montag',
			tuesday: 'Dienstag',
			wednesday: 'Mittwoch',
			thursday: 'Donnerstag',
			friday: 'Freitag',
			saturday: 'Samstag',
			sunday: 'Sonntag',
			holidays: 'Feiertage'
		};

		try {
			const hours = typeof hoursJson === 'string' ? JSON.parse(hoursJson) : hoursJson;

			let isEmpty = true;

			for (const [key, label] of Object.entries(days)) {
				const h = hours[key];
				if (h?.start || h?.end || h?.closed) isEmpty = false;

				if (h?.closed || (!h?.start && !h?.end)) {
					html += `<li><strong>${label}:</strong> <span class="text-danger">Geschlossen</span></li>`;
				} else {
					html += `<li><strong>${label}:</strong> ${h.start || '--:--'} – ${h.end || '--:--'}</li>`;
				}
			}

			if (isEmpty) return '<span>Keine näheren Informationen verfügbar</span>';
		} catch (e) {
			console.warn('Fehler beim Parsen der Öffnungszeiten:', e);
			return '<span>Keine näheren Informationen verfügbar</span>';
		}

		html += '</ul>';
		return html;
	}

	function showModal({ name, address, zip, city, hours, contact, email, phone, website, logo, country }) {
		const modal = document.getElementById('modal');
		const fields = {
			modalTitle: name || 'Nicht verfügbar',
			modalFirmName: name || 'Nicht verfügbar',
			modalAddress: address || 'Nicht verfügbar',
			modalZip: zip || '',
			modalCity: city || 'Nicht verfügbar',
			modalCountry: country || 'Österreich',
			modalContactPerson: contact?.trim() || 'Nicht verfügbar',
			modalEmail: email?.trim() || 'Nicht verfügbar',
			modalPhone: phone?.trim() || 'Nicht verfügbar',
			modalHours: formatOpeningHours(hours)
		};

		Object.entries(fields).forEach(([id, value]) => {
			const el = document.getElementById(id);
			if (el) el.innerHTML = value;
		});

		if (website) {
			const btn = document.getElementById('modalWebsite');
			btn.setAttribute('data-url', website);
			btn.onclick = () => window.open(website, '_blank');
		}

		const img = document.getElementById('modalLogo');
		if (logo && logo.trim() !== '') {
			img.src = '<?= base_url("uploads/") ?>' + logo;
		} else {
			img.src = '<?= base_url("img/logo/kein_logo.png") ?>';
		}
		img.onerror = function () {
			this.src = '<?= base_url("img/logo/kein_logo.png") ?>';
		};



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

			const distances = locations.map((loc, index) => ({
				location: loc,
				distance: google.maps.geometry.spherical.computeDistanceBetween(userLatLng, new google.maps.LatLng(parseFloat(loc.latitude), parseFloat(loc.longitude))),
				letter: String.fromCharCode(65 + index)
			})).sort((a, b) => a.distance - b.distance);

			const list = document.getElementById('locationList');
			list.innerHTML = '';
			[distances[0], distances[1] || distances[0]].forEach(item => {
				const marker = new google.maps.Marker({
					position: { lat: parseFloat(item.location.latitude), lng: parseFloat(item.location.longitude) },
					map,
					title: item.location.name,
					icon: {
						url: `https://maps.google.com/mapfiles/marker${item.letter}.png`
					}
					// Odstránenie labelu
				});

				const infowindow = new google.maps.InfoWindow({
					content: `<h3>${item.location.name}</h3><p>${item.location.address}, ${item.location.zip_code} ${item.location.city}</p>`
				});

				marker.addListener('click', () => {
					infowindow.open(map, marker);
					map.setCenter(marker.getPosition());
					map.setZoom(12);
				});

				addToLocationList(item.location, marker, infowindow, item.letter);
			});
		}, () => alert('Geolokation nicht verfügbar'));
	}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap&libraries=geometry" async defer></script>
