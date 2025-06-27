<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">📘 Admin Dokumentation</h3>
					<p class="card-subtitle">Interaktive Übersicht über alle administrierbaren Module.</p>
				</div>
			</header>
			<div class="card-body">
				<div class="row">
					<!-- Ľavé menu -->
					<div class="col-md-3">
						<nav class="nav flex-column nav-pills" id="doc-tab" role="tablist" aria-orientation="vertical">
							<a class="nav-link active" id="uebersicht-tab" data-bs-toggle="pill" href="#uebersicht" role="tab" aria-controls="uebersicht" aria-selected="true">🏁 Übersicht</a>
							<a class="nav-link" id="menuverwaltung-tab" data-bs-toggle="pill" href="#menuverwaltung" role="tab" aria-controls="menuverwaltung" aria-selected="false">📁 Menüverwaltung</a>
							<a class="nav-link" id="slider-tab" data-bs-toggle="pill" href="#slider" role="tab" aria-controls="slider" aria-selected="false">🎞️ Slider</a>
							<a class="nav-link" id="news-tab" data-bs-toggle="pill" href="#news" role="tab" aria-controls="news" aria-selected="false">📰 News</a>
							<a class="nav-link" id="galerie-tab" data-bs-toggle="pill" href="#galerie" role="tab" aria-controls="galerie" aria-selected="false">🖼️ Galerie</a>
							<a class="nav-link" id="produkte-tab" data-bs-toggle="pill" href="#produkte" role="tab" aria-controls="produkte" aria-selected="false">🛍️ Beliebte Produkte</a>
							<a class="nav-link" id="shopfinder-tab" data-bs-toggle="pill" href="#shopfinder" role="tab" aria-controls="shopfinder" aria-selected="false">📍 Shopfinder</a>
							<a class="nav-link" id="ftpmanager-tab" data-bs-toggle="pill" href="#ftpmanager" role="tab" aria-controls="ftpmanager" aria-selected="false">🗂️ FTP-Manager</a>
						</nav>
					</div>

					<!-- Pravý obsah -->
					<div class="col-md-9">
						<div class="tab-content" id="doc-tabContent">
							<div class="tab-pane fade show active" id="uebersicht" role="tabpanel" aria-labelledby="uebersicht-tab">
								<div class="text-center py-5">
									<img src="<?= base_url('assets/img/logo_styx_black.png') ?>" alt="STYX Logo" style="max-width: 180px;" class="mb-4">
									<h2 class="fw-bold mb-3">📘 STYX Admin Dokumentation</h2>
									<p class="text-muted mx-auto" style="max-width: 600px;">
										Diese Dokumentation bietet dir eine vollständige Übersicht über alle administrativen Module im System von STYX Naturkosmetik.
										Hier findest du technische Informationen, Benutzerhinweise und Tipps für jede einzelne Verwaltungseinheit.
									</p>
									<p class="text-secondary">
										Klicke links auf eine Sektion, um deren Beschreibung und technische Details anzuzeigen.
									</p>
								</div>
							</div>
							<div class="tab-pane fade" id="menuverwaltung" role="tabpanel" aria-labelledby="menuverwaltung-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-folder-open text-primary me-2"></i>📁 Menüverwaltung</h4>
									<section class="mb-4">
										<h5 class="text-success"><i class="fas fa-user me-1"></i>Was macht dieses Modul?</h5>
										<p>
											In der Menüverwaltung kannst du alle Navigationspunkte der Website zentral verwalten.
											Du kannst neue Menüpunkte erstellen, bestehende bearbeiten, sortieren oder löschen.
											Dabei ist es wichtig, dass die Struktur übersichtlich bleibt, um die Benutzerfreundlichkeit im Frontend zu gewährleisten.
										</p>
										<ul>
											<li>Jeder Menüpunkt besitzt eine Sprache, Bezeichnung und Ziel-URL.</li>
											<li>Untermenüs lassen sich durch Hierarchie (Parent-ID) erstellen.</li>
											<li>Die Reihenfolge kann per Drag & Drop angepasst werden.</li>
										</ul>
									</section>
									<section class="mb-4">
										<h5 class="text-primary"><i class="fas fa-code me-1"></i>Technische Umsetzung</h5>
										<ul>
											<li><strong>Controller:</strong> <code>Admin::menuSave()</code></li>
											<li><strong>Model:</strong> <code>Admin_model::menuSave()</code>, <code>getFullMenu()</code></li>
											<li><strong>View (Formular):</strong> <code>views/admin/settings/menu_form.php</code></li>
											<li><strong>View (Liste):</strong> <code>views/admin/settings/menu.php</code></li>
											<li><strong>Datenbank:</strong> Tabelle <code>menu</code> mit:
												<code>id</code>, <code>name</code>, <code>url</code>, <code>lang</code>, <code>parent</code>, <code>orderBy</code>, <code>active</code>, <code>created_at</code>, <code>updated_at</code>
											</li>
											<li><strong>Validierung:</strong> Alle Felder sind verpflichtend, außer <code>parent</code></li>
										</ul>
									</section>
									<section>
										<h5 class="text-warning"><i class="fas fa-info-circle me-1"></i>Hinweise & Tipps</h5>
										<ul>
											<li>Änderungen werden sofort im Frontend sichtbar – teste die Navigation nach jeder Änderung.</li>
											<li>Jede Sprache hat ihre eigene Menüstruktur (z. B. <code>de</code>, <code>en</code>, <code>sk</code>).</li>
											<li>Vermeide doppelte Slugs – das kann zu Routing-Problemen führen.</li>
											<li>Halte die Struktur flach (max. 2–3 Hierarchieebenen).</li>
										</ul>
									</section>
								</div>
							</div>
							<div class="tab-pane fade" id="slider" role="tabpanel" aria-labelledby="slider-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-film text-info me-2"></i>🎞️ Slider</h4>
									<p>Hier kannst du Slider verwalten...</p>
								</div>
							</div>
							<div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-newspaper text-secondary me-2"></i>📰 News</h4>
									<p>Hier kannst du News verwalten...</p>
								</div>
							</div>
							<div class="tab-pane fade" id="galerie" role="tabpanel" aria-labelledby="galerie-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-images text-success me-2"></i>🖼️ Galerie</h4>
									<p>Hier kannst du Galerien verwalten...</p>
								</div>
							</div>
							<div class="tab-pane fade" id="produkte" role="tabpanel" aria-labelledby="produkte-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-star text-warning me-2"></i>🛍️ Beliebte Produkte</h4>
									<p>Hier kannst du beliebte Produkte verwalten...</p>
								</div>
							</div>
							<div class="tab-pane fade" id="shopfinder" role="tabpanel" aria-labelledby="shopfinder-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i>📍 Shopfinder</h4>
									<p>Hier kannst du Shopfinder verwalten...</p>
								</div>
							</div>
							<div class="tab-pane fade" id="ftpmanager" role="tabpanel" aria-labelledby="ftpmanager-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-server text-dark me-2"></i>🗂️ FTP-Manager</h4>
									<p>Hier kannst du FTP-Uploads verwalten...</p>
								</div>
							</div>
						</div>
					</div>
					<!-- /Pravý obsah -->
				</div>
			</div>
		</section>
	</div>
</div>

<!-- Bootstrap JS (na koniec body ak ešte nemáš) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
