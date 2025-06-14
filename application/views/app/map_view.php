<?php
$this->load->view('partials/shopfinder_assets');
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ&callback=initMap&libraries=geometry" async defer></script>
