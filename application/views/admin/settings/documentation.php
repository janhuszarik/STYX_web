<style>
	.doc-section ul li { margin-bottom: 1.1em; }
</style>

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
									<img src="<?= BASE_URL.LOGO?>" alt="STYX Logo" style="max-width: 180px;" class="mb-4">
									<h2 class="fw-bold mb-3">📘 STYX Admin Dokumentation</h2>
									<p class="text-muted mx-auto" style="max-width: 600px;">
										Diese Dokumentation bietet dir eine vollständige Übersicht über alle administrativen Module im System von STYX Naturkosmetik.
										Hier findest du technische Informationen, Benutzerhinweise und Tipps für jede einzelne Verwaltungseinheit.
									</p>
									<p class="text-secondary">
										Klicke links auf eine Sektion, um deren Beschreibung und technische Details anzuzeigen.
									</p>
									<p>Erstellt von: Huszarik Jan | STYX Grafik & Marketing</p>
								</div>
							</div>
							<div class="tab-pane fade" id="menuverwaltung" role="tabpanel" aria-labelledby="menuverwaltung-tab">
								<div class="doc-section">
									<h3 class="mb-4"><i></i>📁 Menüverwaltung</h3>
									<section class="mb-4">
										<h5 class="text-success"><i class="fas fa-user me-1"></i>Was macht dieses Modul?</h5>
										<p>
											Im Modul Menüverwaltung kannst du zentral alle Navigationspunkte deiner Website verwalten. <br>
											<b>In diesem Bereich werden auch die Hauptkategorien für Artikel im Bereich „Beiträge Manager“ automatisch erstellt.</b> <br>
											Dies bedeutet: Sobald du einen neuen Menüpunkt erstellst, die Hauptinformationen im Formular ausfüllst und speicherst, wird gleichzeitig ein Menüpunkt <b>und</b> auch eine neue Kategorie im Beiträge Manager angelegt.
										</p>
									</section>

									<section class="mb-4">
										<h5 class="text-primary"><i class="fas fa-list-ol me-1"></i>Wie funktioniert das Erstellen eines Menüpunktes?</h5>
										<ul>
											<li>
												<strong>Sprache einstellen:</strong><br>
												Beim Anlegen eines Menüpunkts ist der erste Schritt die Spracheinstellung. Stelle die gewünschte Anzeigesprache ein. Wird zum Beispiel „Deutsch“ gewählt, erscheint dieser Menüpunkt <b>nur</b> in der deutschen Version der Webseite. Im Beiträge Manager wird automatisch eine neue Kategorie mit der Sprache Deutsch erstellt.<br>
												<strong>Hinweis:</strong> Achte darauf, beim Erstellen die Sprache korrekt zu setzen – bei Bedarf sollten gleich beide Sprachversionen angelegt werden.
											</li>
											<li>
												<strong>Aktiv/Inaktiv:</strong><br>
												Lege fest, ob der Menüpunkt aktiv (sichtbar im Menü) oder inaktiv (unsichtbar im Menü, aber als Unterseite verfügbar) sein soll.<br>
												<strong>Tipp:</strong> Für neue Kategorien, die auf der Webseite verwendet werden, aber nicht im Menü sichtbar sein sollen, wähle „Inaktiv“. Die Kategorie ist dann im Beiträge Manager nutzbar, aber nicht im Hauptmenü sichtbar.
											</li>
											<li>
												<strong>Hauptname:</strong><br>
												Der eingegebene Name ist sichtbar in der Menüleiste und wird ein Teil der URL-Adresse für die zugehörigen Beiträge.<br>
												Verwende <b>keine</b> Sonderzeichen und Umlaute (z. B. ß, ä, ü usw.) als Namen – das System ersetzt sie automatisch, aber das kann zu unschönen URLs führen.<br>
												<strong>Empfehlung:</strong> Wähle möglichst einfache, klare Namen ohne Akzente oder Sonderzeichen.
											</li>
											<li>
												<strong>URL:</strong><br>
												Die URL wird automatisch aus dem Namen generiert. Sie kann beim Bearbeiten angepasst werden, falls das System Sonderzeichen nicht korrekt verarbeitet.
											</li>
											<li>
												<strong>Zugehörigkeit/Hierarchie:</strong><br>
												Dies ist der wichtigste Schritt für die Struktur.<br>
												Es gibt zwei Möglichkeiten:
												<ul>
													<li><b>Hauptmenü:</b> Der Menüpunkt steht ganz oben in der Navigation.</li>
													<li><b>Unterpunkt:</b> Wenn der Menüpunkt einem bestehenden Hauptmenüpunkt zugeordnet werden soll, wähle den gewünschten „Elternpunkt“ (Parent) aus.<br>
														<strong>Beispiel:</strong> Erstellst du einen Menüpunkt „Kontakt“, und das soll ein Hauptmenüpunkt sein, dann wähle „Hauptmenü: Ja“. <br>
														Erstellst du z.B. „Kontaktformular“ als Unterseite, wähle als Parent „Kontakt“.
													</li>
												</ul>
												<strong>Hinweis:</strong> Damit ein Menüpunkt als „Elternpunkt“ wählbar ist, muss dieser zuerst erstellt und als „Leerer Menü Button“ markiert werden!
											</li>
											<li>
												<strong>Position:</strong><br>
												Die Reihenfolge der Menüpunkte wird durch Positionsnummern bestimmt (beginnend bei 0 = ganz oben). Unterpunkte haben ebenfalls eigene Positionsnummern (ab 0).
											</li>
											<li>
												<strong>Leerer Menü Button:</strong><br>
												Dies sollte aktiviert werden, wenn ein Hauptmenüpunkt nicht anklickbar sein soll (z. B. als reiner „Kategoriekopf“).<br>
												<strong>Sehr wichtig:</strong> Ist dies nicht aktiviert, kann der Hauptmenüpunkt angeklickt werden, was dazu führt, dass auf Mobilgeräten das Ausklappen der Unterpunkte nicht korrekt funktioniert.
											</li>
										</ul>
									</section>

									<section class="mb-4">
										<h5 class="text-warning"><i class="fas fa-info-circle me-1"></i>Zusätzliche Hinweise & Tipps</h5>
										<ul>
											<li>
												Hauptmenüpunkte, denen Unterpunkte zugeordnet werden sollen, <b>müssen</b> als „Leerer Menü Button“ markiert sein, damit die Navigation – besonders auf Mobilgeräten – korrekt funktioniert.
											</li>
											<li>
												Änderungen werden sofort im Frontend sichtbar – teste die Navigation nach jeder Änderung.
											</li>
											<li>
												Vermeide doppelte Slugs, um Routing-Probleme zu verhindern.
											</li>
											<li>
												Halte die Struktur möglichst flach (maximal 2–3 Hierarchieebenen).
											</li>
											<li>
												Menüpunkte und Kategorien werden automatisch im Beiträge Manager angelegt – beachte immer die richtige Spracheinstellung.
											</li>
										</ul>
									</section>

									<section class="mb-4">
										<h5 class="text-primary"><i class="fas fa-code me-1"></i>Technische Umsetzung</h5>
										<ul>
											<li><strong>Controller:</strong> <code>Admin::menuSave()</code></li>
											<li><strong>Model:</strong> <code>Admin_model::menuSave()</code>, <code>getFullMenu()</code></li>
											<li><strong>View (Formular):</strong> <code>views/admin/settings/menu_form.php</code></li>
											<li><strong>View (Liste):</strong> <code>views/admin/settings/menu.php</code></li>
											<li>
												<strong>Datenbank:</strong> Tabelle <code>menu</code> mit:
												<code>id</code>, <code>name</code>, <code>url</code>, <code>lang</code>, <code>parent</code>, <code>orderBy</code>, <code>active</code>, <code>created_at</code>, <code>updated_at</code>
											</li>
											<li><strong>Validierung:</strong> Alle Felder sind verpflichtend, außer <code>parent</code></li>
										</ul>
									</section>
								</div>

							</div>
							<div class="tab-pane fade" id="slider" role="tabpanel" aria-labelledby="slider-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="text-info me-2"></i>🎞️ Slider</h4>

									<p><strong>Was macht dieses Modul?</strong><br>
										Im Modul <strong>Sliderverwaltung</strong> kannst du die Slider deiner Webseite verwalten – inklusive Textinhalten, Bildern, Farben, Position und Sprache. Slider sind visuelle Bannerbereiche, die auf der Startseite oder Unterseiten angezeigt werden.</p>

									<h5 class="mt-4">🔧 Wie funktioniert das Erstellen eines Sliders?</h5>
									<ul>
										<li><strong>Sprache:</strong> Wähle, in welcher Sprachversion der Slider erscheinen soll (z. B. Deutsch oder Englisch).</li>
										<li><strong>Titel für Inhalt:</strong> Überschrift, die als erste unter dem Slider angezeigt wird. Sie ist am größten und wird auch als Title für die Google-Suche verwendet. Daher sollte dieser Title auch im View verwendet werden.</li>
										<li><strong>Unterüberschrift</strong> Zusätzliche erklärende Texte unter der Überschrift.</li>
										<li><strong>Slider Bild:</strong> Lade ein Bild im Format JPG, PNG hoch (empfohlen: 1600x600px).</li>
										<li><strong>Schaltflächenlink:</strong> Optionaler Button-Link, z. B. zu einer Angebotsseite.</li>
										<li><strong>Hintergrundfarbe & Textfarbe:</strong> Farbauswahl für den Hintergrundbereich unter dem Slider, wo der Text angezeigt wird. Es kann notwendig sein, den Hintergrund anzupassen, um ein einheitliches Design zwischen dem Slider und dem unteren Textbereich zu gewährleisten. Der Text sollte unter jedem Slider ungefähr gleich groß sein, um zu vermeiden, dass sich die Slider nach oben oder unten verschieben und sich die Größe des Bereichs verändert. Das ist aus optischen Gründen ungünstig, da ein „Springen“ oder eine Größenänderung der Sektion störend wirken kann.
											Die Hintergrundfarbe kann entweder über die Farbauswahl (durch Anklicken und Verschieben im Farbfeld) oder durch die direkte Eingabe eines Farbwertes ausgewählt werden, wobei drei Formate unterstützt werden: RGB, HSL oder HEX. Am gebräuchlichsten ist vermutlich das HEX-Format, das immer mit # beginnt und durch den entsprechenden Farbcode fortgesetzt wird. Der Hintergrund kann z.B. weiß bleiben, wobei der Text dann beispielsweise schwarz sein kann.
											Die Farbauswahl für den Text funktioniert genauso wie die Auswahl der Hintergrundfarbe. Hier empfiehlt es sich jedoch, nur weiße oder schwarze Farben zu verwenden, um die Einhaltung der Kontrastanforderungen der Website sicherzustellen.</li>
										<li><strong>Position:</strong> Bestimmt die Reihenfolge auf der Webseite (z. B. 0 = ganz oben). Das bedeutet, dass – wie beim Menü – auch hier die Reihenfolge bei null beginnt und nach oben fortgesetzt wird. Dementsprechend werden die Slider auf der Webseite in der Reihenfolge angezeigt, wobei der Slider mit der Nummer 0 ganz oben steht und die weiteren darunter folgen.</li>
										<li><strong>Aktiv/Inaktiv:</strong> Bestimmt, ob der Slider angezeigt wird.</li>
									</ul>

									<h5 class="mt-4">🗑 Slider löschen</h5>
									<p>Ein Slider kann dauerhaft gelöscht werden. Dabei wird das Bild automatisch vom Server entfernt.<br>
										Achtung: Dieser Vorgang ist unwiderruflich!</p>

									<h5 class="mt-4">💡 Tipps & Hinweise</h5>
									<ul>
										<li>Nutze einfache, optimierte Bilder für bessere Ladezeiten.</li>
										<li>Verwende kontrastreiche Textfarben für bessere Lesbarkeit.</li>
										<li>Teste Slider nach dem Speichern im Frontend und auf Mobilgeräten.</li>
										<li>Vermeide doppelte Positionen – jeder Slider sollte eine eindeutige Reihenfolge haben.</li>
									</ul>

									<h5 class="mt-4">⚙️ Technische Umsetzung</h5>
									<ul>
										<li><strong>Controller:</strong> <code>Admin::sliderSave()</code></li>
										<li><strong>Model:</strong> <code>Admin_model::save_slider_full()</code>, <code>get_all_sliders()</code></li>
										<li><strong>Formular View:</strong> <code>views/admin/settings/slider_form.php</code></li>
										<li><strong>Listen View:</strong> <code>views/admin/settings/sliders.php</code></li>
										<li><strong>Datenbanktabelle:</strong> <code>slider</code></li>
									</ul>
								</div>
							</div>

							<div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news-tab">
								<div class="doc-section">
									<h4 class="mb-3"><i class="fas fa-newspaper text-secondary me-2"></i>📰 News</h4>

									<section class="mb-4">
										<h5 class="text-success"><i class="fas fa-user me-1"></i>Was macht dieses Modul?</h5>
										<p>
											Das Modul <strong>News</strong> ermöglicht die Verwaltung von Nachrichten, die auf der Webseite angezeigt werden. Diese Nachrichten erscheinen in Form von Karten, die eine Hauptüberschrift, einen kurzen Text, ein Bild und einen optionalen Link enthalten. <br>
											<b>Das Modul ist darauf ausgelegt, Besucher durch ansprechende Karten zu Artikeln, Produkten oder Kampagnen weiterzuleiten.</b> <br>
											Du kannst die Sprache, Sichtbarkeit, Anzeigedauer (Start- und Enddatum) sowie das Erscheinungsbild der News-Karten anpassen.
										</p>
									</section>

									<section class="mb-4">
										<h5 class="text-primary"><i class="fas fa-list-ol me-1"></i>Wie funktioniert das Erstellen einer News-Karte?</h5>
										<ul>
											<li>
												<strong>Sprache:</strong><br>
												Wähle die Sprache, in der die News-Karte angezeigt werden soll (z. B. Deutsch oder Englisch). Die gewählte Sprache bestimmt, in welcher Sprachversion der Webseite die Nachricht sichtbar ist.<br>
												<strong>Hinweis:</strong> Stelle sicher, dass die Sprache korrekt eingestellt ist, da die News nur in der ausgewählten Sprachversion erscheint.
											</li>
											<li>
												<strong>Hauptüberschrift:</strong><br>
												Die Hauptüberschrift ist der große, auffällige Text, der auf der News-Karte angezeigt wird. Sie sollte kurz, prägnant und ansprechend sein, um die Aufmerksamkeit der Besucher zu erregen.<br>
												<strong>Empfehlung:</strong> Verwende keine Sonderzeichen oder Umlaute, um Darstellungsprobleme zu vermeiden.
											</li>
											<li>
												<strong>Kurztext:</strong><br>
												Der Kurztext erscheint unter der Hauptüberschrift und dient als kurze Beschreibung oder Teaser. Er sollte die Hauptüberschrift ergänzen und die Besucher neugierig machen, auf den Link zu klicken.<br>
												<strong>Tipp:</strong> Halte den Text knapp (max. 1–2 Sätze), um die Lesbarkeit zu gewährleisten.
											</li>
											<li>
												<strong>URL (Button-Link):</strong><br>
												Die URL ist optional, aber dringend empfohlen, da News-Karten darauf ausgelegt sind, Besucher zu einer bestimmten Seite (z. B. Artikel, Produkt oder Kampagne) weiterzuleiten. Die URL muss mit <code>https://</code> beginnen, um gültig zu sein.<br>
												<strong>Beispiel:</strong> <code>https://www.styx.at/produkte/neues-produkt</code><br>
												<strong>Hinweis:</strong> Stelle sicher, dass die URL korrekt ist, da fehlerhafte Links zu einer schlechten Nutzererfahrung führen.
											</li>
											<li>
												<strong>Bild hochladen:</strong><br>
												Lade ein Bild für die News-Karte hoch (Formate: JPG, PNG). Die empfohlenen Maße sind <strong>300x300 px</strong>. Größere Bilder (z. B. 600x600 px) werden automatisch zugeschnitten, bleiben aber erkennbar. Die maximale Dateigröße beträgt <strong>3 MB</strong>, ideal sind ca. <strong>900 KB</strong> für schnelle Ladezeiten.<br>
												<strong>Tipp:</strong> Verwende optimierte Bilder, um die Ladezeit der Webseite nicht zu beeinträchtigen.
											</li>
											<li>
												<strong>Startdatum (optional):</strong><br>
												Lege ein Startdatum fest, ab dem die News-Karte automatisch sichtbar wird. Wird kein Datum angegeben, ist die Karte sofort nach dem Speichern aktiv.<br>
												<strong>Beispiel:</strong> Wenn du den 28.01.2025 eingibst, erscheint die Karte am 28.01.2025 um 00:00 Uhr.<br>
												<strong>Hinweis:</strong> Das Startdatum ist ideal für zeitlich geplante Kampagnen.
											</li>
											<li>
												<strong>Enddatum (optional):</strong><br>
												Definiere ein Enddatum, an dem die News-Karte automatisch deaktiviert wird. Ohne Enddatum bleibt die Karte dauerhaft aktiv (sofern sie als „Aktiv“ markiert ist).<br>
												<strong>Beispiel:</strong> Bei einem Enddatum vom 30.01.2025 wird die Karte am 30.01.2025 um 23:59 Uhr ausgeblendet.<br>
												<strong>Wichtig:</strong> Die News-Karte muss als „Aktiv“ markiert sein, damit Start- und Enddatum wirksam sind.
											</li>
											<li>
												<strong>Aktiv/Inaktiv:</strong><br>
												Bestimme, ob die News-Karte sofort sichtbar (Aktiv) oder ausgeblendet (Inaktiv) sein soll. Inaktive Karten sind für die Öffentlichkeit unsichtbar, können aber weiterhin bearbeitet werden.<br>
												<strong>Tipp:</strong> Nutze „Inaktiv“ für Entwürfe oder Karten, die erst später veröffentlicht werden sollen.
											</li>
										</ul>
									</section>

									<section class="mb-4">
										<h5 class="text-danger"><i class="fas fa-trash-alt me-1"></i>News-Karte löschen</h5>
										<p>
											Eine News-Karte kann dauerhaft gelöscht werden. Dabei wird das zugehörige Bild automatisch vom Server entfernt.<br>
											<strong>Achtung:</strong> Das Löschen ist unwiderruflich! Stelle sicher, dass die Karte nicht mehr benötigt wird, bevor du sie löschst.
										</p>
									</section>

									<section class="mb-4">
										<h5 class="text-warning"><i class="fas fa-info-circle me-1"></i>Zusätzliche Hinweise & Tipps</h5>
										<ul>
											<li>Verwende ansprechende, hochauflösende Bilder, die zur Botschaft der News passen.</li>
											<li>Teste die News-Karte nach dem Speichern im Frontend, insbesondere auf Mobilgeräten, um sicherzustellen, dass Bild und Text korrekt angezeigt werden.</li>
											<li>Überprüfe die URL vor dem Speichern, um sicherzustellen, dass sie funktioniert und zur gewünschten Seite führt.</li>
											<li>Nutze Start- und Enddaten, um zeitlich begrenzte Kampagnen oder Aktionen zu steuern.</li>
											<li>Vermeide zu lange Hauptüberschriften oder Kurztexte, da diese auf kleineren Bildschirmen abgeschnitten werden können.</li>
										</ul>
									</section>

									<section class="mb-4">
										<h5 class="text-primary"><i class="fas fa-code me-1"></i>Technische Umsetzung</h5>
										<ul>
											<li><strong>Controller:</strong> <code>Admin::newsSave()</code></li>
											<li><strong>Model:</strong> <code>Admin_model::newsSave()</code>, <code>getNews()</code>, <code>newsDelete()</code></li>
											<li><strong>Formular View:</strong> <code>views/admin/settings/news_form.php</code></li>
											<li><strong>Listen View:</strong> <code>views/admin/settings/news.php</code></li>
											<li>
												<strong>Datenbank:</strong> Tabelle <code>news</code> mit: <br>
												<code>id</code>, <code>lang</code>, <code>name</code>, <code>name1</code>, <code>buttonUrl</code>, <code>image</code>, <code>active</code>, <code>start_date</code>, <code>end_date</code>, <code>created_at</code>, <code>updated_at</code>
											</li>
											<li><strong>Validierung:</strong> <code>name</code> und <code>name1</code> sind Pflichtfelder. <code>buttonUrl</code> und <code>image</code> sind optional, sollten aber für optimale Nutzung ausgefüllt werden.</li>
										</ul>
									</section>
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
				</div>
			</div>
		</section>
	</div>
</div>
