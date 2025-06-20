<?php
$this->load->view('partials/kinder_assets');
?>

<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success">
		<?= $this->session->flashdata('success') ?>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger">
		<?= $this->session->flashdata('error') ?>
	</div>
<?php endif; ?>

<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3">
					<?= ($currentLang == 'english') ? 'Contact Form' : 'Kontaktformular' ?>
				</h1>
				<p class="text-muted lead mb-0">
					<?= htmlspecialchars(($currentLang == 'english') ? 'Get in touch with us for any inquiries or support.' : 'Kontaktieren Sie uns für Anfragen oder Unterstützung.') ?>
				</p>
			</div>
		</div>
	</div>
</section>

<div class="container my-5">
	<form method="post" action="<?= base_url('app/send_kindergeburtstage') ?>">
		<!-- Contact Information -->
		<div class="form-section">
			<h2 class="fw-bold mb-2">Kontaktdaten</h2>
			<p class="mb-4">Füllen Sie das Formular vollständig aus und richten Sie so Ihre Wünsche direkt an uns.</p>

			<div class="row mb-3">
				<div class="col-md-6">
					<label for="event-date" class="form-label">Gewünschtes Veranstaltungsdatum *</label>
					<input type="date" class="form-control" id="event-date" name="event_date" required>
				</div>
				<div class="col-md-6">
					<label for="event-time" class="form-label">Gewünschte Uhrzeit *</label>
					<input type="time" class="form-control" id="event-time" name="event_time" required>
				</div>
			</div>

			<div class="mb-3">
				<label for="child-name" class="form-label">Name des Geburtstagskindes *</label>
				<input type="text" class="form-control" id="child-name" name="child_name" required>
			</div>
			<div class="mb-3">
				<label for="child-age" class="form-label">Alter des Geburtstagskind *</label>
				<input type="number" class="form-control" id="child-age" name="child_age" min="1" required>
			</div>
			<div class="mb-3">
				<label for="num-children" class="form-label">Anzahl der Kinder (max. 15) *</label>
				<input type="number" class="form-control" id="num-children" name="num_children" max="15" min="1" required>
			</div>
			<div class="mb-3">
				<label for="contact-person" class="form-label">Ansprechperson *</label>
				<input type="text" class="form-control" id="contact-person" name="contact_person" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">E-Mail *</label>
				<input type="email" class="form-control" id="email" name="email" required>
			</div>
			<div class="mb-3">
				<label for="phone" class="form-label">Telefonnummer *</label>
				<input type="tel" class="form-control" id="phone" name="phone" required>
			</div>
			<div class="mb-3">
				<label for="address" class="form-label">Straße & Hausnummer *</label>
				<input type="text" class="form-control" id="address" name="address" required>
			</div>
			<div class="mb-3">
				<label for="zip-city" class="form-label">PLZ, Ort *</label>
				<input type="text" class="form-control" id="zip-city" name="zip_city" required>
			</div>
		</div>

		<div class="form-section">
			<h4 class="fw-bold mb-3">STYX Paket <span class="text-danger">*</span></h4>
			<div class="row row-cols-1 row-cols-md-2 g-4">
				<div class="col">
					<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'paket')">
						<input type="radio" name="paket" value="shampoo_badesalz" required>
						<div class="image-wrapper d-flex align-items-center justify-content-center mb-3" style="height: 190px;">
							<img src="<?=base_url('img/image/Badesalz_STYX_Preis.png')?>" alt="Shampoo und Badesalz Paket" class="img-fluid">
						</div>
						<h4 class="fw-bold mt-2 fs-5">Shampoo / Badesalz Paket</h4>
						<p class="d-block mb-3">8+1 = €250, jedes weitere Kind: €20</p>
						<p class="small text-muted text-start fst-italic">* eine Kinderführung durch die World of STYX, Shampoo und/oder Badesalz selbst herstellen, Duft-Ratespiel, Schokoladenverkostung, kleine Stärkung – Dauer ca. 2,5 Stunden</p>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'paket')">
						<input type="radio" name="paket" value="schokolade" required>
						<div class="image-wrapper d-flex align-items-center justify-content-center mb-3" style="height: 190px;">
							<img src="<?=base_url('img/image/schokolade_bild.png')?>" alt="Schokolade Paket" class="img-fluid">
						</div>
						<h4 class="fw-bold mt-2 fs-5">Schokolade Paket</h4>
						<p class="d-block mb-3">8+1 = €300, jedes weitere Kind: €25</p>
						<p class="small text-muted text-start fst-italic">* Schokoführung, Schokoriegel & Marzipankugel herstellen und verzieren, Kostproben mitnehmen, kleine Stärkung – Dauer ca. 2,5 Stunden</p>
					</label>
				</div>
			</div>
		</div>

		<div class="form-section">
			<h4 class="fw-bold mb-3">STYX Torte <span class="text-danger">*</span></h4>
			<div class="row row-cols-1 row-cols-md-2 g-4">
				<div class="col">
					<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'torte')">
						<input type="radio" name="torte" value="ja" required>
						<div class="image-wrapper d-flex align-items-center justify-content-center mb-3" style="height: 190px;">
							<img src="<?=base_url('img/image/Torte_STYX.png')?>" alt="STYX Geburtstagstorte" class="img-fluid">
						</div>
						<h4 class="fw-bold mt-2 fs-5">STYX Torte</h4>
						<small class="d-block mb-1">Zusätzlich €45</small>
						<p class="small text-muted">Bunte Geburtstagstorte für die Kinder</p>
					</label>
				</div>
			</div>
		</div>

		<div class="form-section">
			<h4 class="fw-bold mb-3">Jause <span class="text-danger">*</span></h4>
			<div class="row row-cols-1 row-cols-md-2 g-4">
				<div class="col">
					<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'jause')">
						<input type="radio" name="jause" value="wurst" required>
						<h4 class="fw-bold mt-2 fs-6">Würstel & Semmel</h4>
						<small class="d-block text-success mb-1">Im Paketpreis inklusive</small>
						<p class="small text-muted">Beliebter Klassiker für alle Kinder</p>
					</label>
				</div>
				<div class="col">
					<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'jause')">
						<input type="radio" name="jause" value="toast" required>
						<h4 class="fw-bold mt-2 fs-6">Toast (Schinken & Käse)</h4>
						<small class="d-block text-success mb-1">Im Paketpreis inklusive</small>
						<p class="small text-muted">Warmer, leckerer Snack mit Schinken und Käse</p>
					</label>
				</div>
			</div>
			<div class="form-text text-danger mt-2 text-bold">Jause im Paketpreis inklusive!</div>
		</div>

		<div class="form-section">
			<div class="mb-3">
				<label for="notes" class="form-label">Anmerkung</label>
				<textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
			</div>
			<div class="mb-3">
				<p class="text-danger">Richten Sie bitte Ihre Terminanfrage <strong>mindestens 2 Wochen</strong> im Voraus an uns!</p>
			</div>
			<div class="mb-3">
				<div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"></div>
			</div>
			<button type="submit" class="btn btn-success">Anfrage abschicken</button>
		</div>
	</form>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
	function selectCard(element, group) {
		document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
			input.parentElement.classList.remove('active');
		});
		element.classList.add('active');
		element.querySelector('input').checked = true;
	}
</script>
