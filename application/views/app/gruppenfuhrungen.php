<?php $this->load->view('partials/gruppenfuhrungForm_assets'); ?>
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
<div class="container my-5">
	<div class="mx-auto" style="max-width: 900px;">
		<?php if ($this->session->flashdata('error')): ?>
			<div class="alert alert-danger">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('success')): ?>
			<div class="alert alert-success">
				<?= $this->session->flashdata('success') ?>
			</div>
		<?php endif; ?>
		<?= form_open('app/send_gruppenfuhrung', ['method' => 'post']) ?>
		<h4 class="mb-3">Kontaktdaten</h4>
		<div class="row">
			<div class="col-md-6 form-group">
				<label>Art der Veranstaltung *</label>
				<select name="group_type" class="form-control" required>
					<option value="">Bitte wählen</option>
					<option value="Schulklasse">Schulklasse</option>
					<option value="Kindergarten">Kindergarten</option>
					<option value="Verein">Verein</option>
					<option value="Firma">Firma</option>
					<option value="Privat">Privat</option>
				</select>
			</div>
			<div class="col-md-6 form-group">
				<label>Gewünschter Besuchstermin *</label>
				<input type="date" name="event_date" class="form-control" required>
			</div>
			<div class="col-12 form-group">
				<label>Firma / Verein / Organisation *</label>
				<input type="text" name="organization" class="form-control" required>
			</div>
		</div>

		<h5 class="mt-4">Ansprechpartner</h5>
		<div class="row">
			<div class="col-md-6 form-group">
				<label>Name *</label>
				<input type="text" name="name" class="form-control" required>
			</div>
			<div class="col-md-6 form-group">
				<label>E-Mail *</label>
				<input type="email" name="email" class="form-control" required>
			</div>
			<div class="col-md-6 form-group">
				<label>Telefon *</label>
				<input type="text" name="phone" class="form-control" required>
			</div>
			<div class="col-md-6 form-group">
				<label>Straße & Hausnummer *</label>
				<input type="text" name="street" class="form-control" required>
			</div>
			<div class="col-12 form-group">
				<label>PLZ / Ort *</label>
				<input type="text" name="zip_city" class="form-control" required>
			</div>
		</div>

		<div class="form-section mt-5">
			<h4 class="mt-5 mb-2 fw-bold">Personenanzahl *</h4>
			<p class="text-danger mb-3">
				Eine Woche vor Termin bitte genaue Personenanzahl bekannt geben!
				<span class="text-muted">Bitte beachten Sie die <strong>benötigte Zeit</strong> für die jeweilige Tour!</span>
			</p>
			<div class="form-group">
				<label for="num_persons_input" class="form-label">Geben Sie die Anzahl der Personen ein:</label>
				<input type="number" class="form-control" name="num_persons" id="num_persons_input" required min="1" placeholder="z. B. 35">
			</div>
			<div id="person_info_output" class="alert alert-info mt-3 d-none"></div>
		</div>

		<div class="form-section">
			<h4 class="fw-bold mb-3">Tour auswählen <span class="text-danger">*</span></h4>
			<div class="row row-cols-1 row-cols-md-3 g-4">
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
						<input type="radio" name="tour_type" value="silber" required class="mb-2">
						<div class="img-wrapper">
							<img src="<?=base_url('img/webImage/STYX_Tour_Silber.jpg')?>" alt="Tour Silber" class="img-fluid">
						</div>
						<h4 class="fw-bold fs-5 mb-1">Silber</h4>
						<small class="text-muted d-block mb-2">2 h inkl. Schokoladenverkostung – 7 €</small>
						<div class="form-check">
							<input type="checkbox" name="extras_silber[]" value="bierverkostung" class="form-check-input" id="silber_bier">
							<label class="form-check-label small" for="silber_bier"><strong>mit Bierverkostung <br></strong> (4€ – 20–30min)</label>
						</div>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
						<input type="radio" name="tour_type" value="gold" required class="mb-2">
						<div class="img-wrapper">
							<img src="<?=base_url('img/webImage/STYX_Tour_Gold.jpg')?>" alt="Tour Gold" class="img-fluid">
						</div>
						<h4 class="fw-bold fs-5 mb-1">Gold</h4>
						<small class="text-muted d-block mb-2">2,5 h inkl. Vorführung – ab 18,50€</small>
						<div class="form-check">
							<input type="radio" name="gold_option" value="kosmetik" class="form-check-input" id="gold_kosmetik">
							<label class="form-check-label small" for="gold_kosmetik">Kosmetikvorführung</label>
						</div>
						<div class="form-check">
							<input type="radio" name="gold_option" value="schoko" class="form-check-input" id="gold_schoko">
							<label class="form-check-label small" for="gold_schoko">Schokovorführung</label>
						</div>
						<div class="form-check mb-2">
							<input type="radio" name="gold_option" value="beides" class="form-check-input" id="gold_beides">
							<label class="form-check-label small" for="gold_beides">Beides – 28,50 €</label>
						</div>
						<div class="form-check">
							<input type="checkbox" name="extras_gold[]" value="bierverkostung" class="form-check-input" id="gold_bier">
							<label class="form-check-label small" for="gold_bier"><strong>mit Bierverkostung</strong> (4€ – 20–30min)</label>
						</div>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
						<input type="radio" name="tour_type" value="platin" required class="mb-2">
						<div class="img-wrapper">
							<img src="<?=base_url('img/webImage/STYX_Tour_Platin.jpg')?>" alt="Tour Platin" class="img-fluid">
						</div>
						<h4 class="fw-bold fs-5 mb-1">Platin</h4>
						<small class="text-muted d-block mb-2">Ganztägig – Preis auf Anfrage</small>
						<ul class="small text-muted ps-3 mb-0">
							<li>Empfang durch GF Wolfgang Stix</li>
							<li>Kosmetik- oder Schokovorführung</li>
							<li>Stelzen Essen, Bier- & Weinverkostung</li>
							<li>Nostalgie Zugfahrt (optional)</li>
							<li>Abschlussgeschenk</li>
						</ul>
					</label>
				</div>
			</div>
		</div>

		<div class="img-wrapper"><img src="<?=BASE_URL.'img/webImage/Info_Busfahrer_GRATIS.jpg'?>" width="400" alt="Reisebegleitung_gartis_logo"></div>

		<div class="form-section mt-5">
			<h4 class="fw-bold mb-2">Kombi - Pakete</h4>
			<p><strong>Silbertour inkludiert</strong> (Konsumption im Bahnhofsbräu / max. 80 Personen)</p>
			<p class="text-muted">Mittagessen mit zwei Speisen zur Auswahl auf Anfrage möglich</p>
			<div class="row">
				<div class="col-md-6 col-lg-3 mb-4">
					<label class="select-card card h-100 shadow-sm p-3 text-center border rounded" onclick="toggleCheckbox(this)">
						<input type="checkbox" name="paket[]" value="Frühstück" class="d-none">
						<div class="fw-bold h6 mb-2">Herzhaftes Frühstück</div>
						<div class="text-muted">19,90 € pro Person</div>
					</label>
				</div>
				<div class="col-md-6 col-lg-3 mb-4">
					<label class="select-card card h-100 shadow-sm p-3 text-center border rounded" onclick="toggleCheckbox(this)">
						<input type="checkbox" name="paket[]" value="Jausn" class="d-none">
						<div class="fw-bold h6 mb-2">Rustikale Jaus'n <br>aus der Region</div>
						<div class="text-muted">17,50 € pro Person</div>
					</label>
				</div>
				<div class="col-md-6 col-lg-3 mb-4">
					<label class="select-card card h-100 shadow-sm p-3 text-center border rounded" onclick="toggleCheckbox(this)">
						<input type="checkbox" name="paket[]" value="Kaffee" class="d-none">
						<div class="fw-bold h6 mb-2">Kaffee & Kuchen <br><small>(STYX Bistro)</small></div>
						<div class="text-muted">15,50 € pro Person</div>
					</label>
				</div>
				<div class="col-md-6 col-lg-3 mb-4">
					<label class="select-card card h-100 shadow-sm p-3 text-center border rounded" onclick="toggleCheckbox(this)">
						<input type="checkbox" name="paket[]" value="Stelzen" class="d-none">
						<div class="fw-bold h6 mb-2">Knuspriges <br>Stelzen-Essen</div>
						<div class="text-muted">19,90 € pro Person</div>
					</label>
				</div>
			</div>
		</div>

		<div class="form-section mt-5">
			<h4 class="fw-bold mb-2">Zahlung</h4>
			<div class="row row-cols-2 row-cols-md-4 g-3">
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm text-center" onclick="selectCard(this, 'zahlung')">
						<input type="radio" name="zahlung" value="Vorauskassa" class="mb-2" required>
						<span class="fw-bold text-center">Vorauskassa</span>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm text-center" onclick="selectCard(this, 'zahlung')">
						<input type="radio" name="zahlung" value="vor Ort" class="mb-2" required>
						<span class="fw-bold text-center">vor Ort</span>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm text-center" onclick="selectCard(this, 'zahlung')">
						<input type="radio" name="zahlung" value="Voucher" class="mb-2" required>
						<span class="fw-bold text-center">Voucher</span>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm text-center" onclick="selectCard(this, 'zahlung')">
						<input type="radio" name="zahlung" value="Rechnung" class="mb-2" required>
						<span class="fw-bold text-center">Rechnung</span>
					</label>
				</div>
			</div>
			<div class="form-group mt-3">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="rechnung_adresse" id="adresse1" value="gleich" checked>
					<label class="form-check-label fw-bold" for="adresse1">Rechnungsadresse gleich Anfrageadresse <span class="text-danger">*</span></label>
				</div>
				<div class="form-check mt-2">
					<input class="form-check-input" type="radio" name="rechnung_adresse" id="adresse2" value="andere">
					<label class="form-check-label" for="adresse2">andere Rechnungsadresse</label>
				</div>
				<textarea class="form-control mt-2" rows="4" name="andere_adresse" placeholder="Bei anderer Rechnungsadresse bitte ausfüllen (Firma, Verein, Organisation / E-Mail / Straße, PLZ, Ort / UID-Nr)" disabled></textarea>
			</div>
		</div>

		<div class="form-group mt-4">
			<p class="text-muted">
				Der angegebene Gruppenpreis ist erst ab einer Teilnehmeranzahl von 20 Personen gültig. Sollte die Gruppe am Tag des Besuches weniger als 20 Personen umfassen, kommt der normale Ticketpreis von EUR 11,50 pro Erwachsene (Einzelticket) zum Tragen. Eine kostenfreie Stornierung des Besuches ist bis 14 Tage vor dem Termin möglich, danach fallen Stornogebühren an.
			</p>
			<p class="mt-3"><strong>Bankverbindung:</strong><br>
				RAIBA St. Pölten IBAN: AT42 3258 5000 0000 5520 BIC: RLNWATWWOBG
			</p>
		</div>

		<div class="form-group mt-3">
			<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA?>"></div>
		</div>

		<div class="form-group mt-4 text-center">
			<button type="submit" class="btn btn-success btn-lg px-5">Anfrage abschicken</button>
		</div>
		</form>
	</div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
