<style>/* custom.css */

	form .form-group {
		margin-bottom: 1rem;
	}

	form label {
		font-weight: 500;
	}

	@media (min-width: 768px) {
		form .form-group.half {
			width: 48%;
			display: inline-block;
			vertical-align: top;
			margin-right: 4%;
		}
		form .form-group.half:nth-child(even) {
			margin-right: 0;
		}
	}

	.radio-block {
		border: 1px solid #ccc;
		padding: 1rem;
		border-radius: 0.5rem;
		text-align: center;
		cursor: pointer;
		transition: all 0.2s ease;
	}

	.radio-block:hover {
		background-color: #f8f8f8;
	}

	.radio-block input {
		display: none;
	}

	.radio-block.selected {
		border-color: #8cc63f;
		background-color: #f1fbea;
	}
	/* ZAROVNANIE OBRÁZKOV – rovnaká výška obrázkového boxu */
	.select-card .img-wrapper {
		height: 180px; /* rovnaká výška pre všetky obrázky */
		display: flex;
		justify-content: center;
		align-items: center;
		margin-bottom: 1rem;
	}

	/* OBRÁZKY – zmenšiť, aby sa zmestili pekne do rámca */
	.select-card img {
		max-height: 100%;
		max-width: 100%;
		object-fit: contain;
	}

	/* VÄČŠÍ MALÝ TEXT */
	.select-card .small {
		font-size: 0.95rem !important; /* namiesto .875rem napr. */
		line-height: 1.5;
	}

	/* UL zoznam pri Platin – lepšia čitateľnosť */
	.select-card ul {
		font-size: 0.95rem;
		padding-left: 1.2rem;
		line-height: 1.5;
	}

	/* ZABEZPEČIŤ ROVNAKÚ VÝŠKU KARIET */
	.select-card {
		min-height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: flex-start;
	}
	.select-card.active {
		border: 2px solid #8cc63f !important;
		box-shadow: 0 0 10px rgba(140, 198, 63, 0.3);
	}

	/* PERSONENANZAHL: karta vo výbere */
	.radio-card {
		cursor: pointer;
		transition: all 0.2s ease-in-out;
		width: 100%;
		text-align: left;
		min-height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		padding: 1.2rem;
	}

	.radio-card span {
		font-size: 1.1rem;
		margin-bottom: 0.3rem;
		display: inline-block;
	}

	.radio-card small {
		font-size: 0.95rem;
		color: #555;
	}

	/* Vizuálne vyznačenie */
	.radio-card input[type="radio"] {
		display: none;
	}

	.radio-card.active {
		border: 2px solid #8cc63f !important;
		box-shadow: 0 0 10px rgba(140, 198, 63, 0.3);
		background-color: #f6fff2;
	}

	/* Vnútorný spacing medzi sekciami */
	.form-section + .form-section,
	.radio-card + .radio-card {
		margin-top: 1.5rem;
	}

	/* Riadkovanie – max 5 kariet v riadku na veľkých obrazovkách */
	@media (min-width: 992px) {
		.person-count-row {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
			gap: 1rem;
		}
	}
	.form-section + .form-section {
		margin-top: 5rem;
	}

	.person-count-row {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
		gap: 1rem;
		align-items: stretch;
	}

</style>
<div class="container my-5">
	<div class="mx-auto" style="max-width: 900px;">
		<form action="<?=base_url('app/send_gruppenfuhrung')?>" method="post">
	<!-- Sekcia: Kontaktdaten -->
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

		<!-- Sekcia: Ansprechpartner -->
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
					<input type="number" class="form-control" name="num_persons" id="num_persons_input" required min="1" placeholder="z. B. 35">
				</div>

				<!-- Dynamický výstup -->
				<div id="person_info_output" class="alert alert-info mt-3 d-none"></div>
			</div>




			<div class="form-section">
				<h4 class="fw-bold mb-3">Tour auswählen <span class="text-danger">*</span></h4>
				<div class="row row-cols-1 row-cols-md-3 g-4">

					<!-- SILBER -->
					<div class="col">
						<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
							<input type="radio" name="tour_type" value="silber" required class="mb-2">
							<img src="<?=base_url('img/webImage/STYX_Tour_Silber.jpg')?>" alt="Tour Silber" class="img-fluid mb-2">
							<h4 class="fw-bold fs-5 mb-1">Silber</h4>
							<small class="text-muted d-block mb-2">2 h inkl. Schokoladenverkostung – 7 €</small>

							<div class="form-check">
								<input type="checkbox" name="extras_silber[]" value="bierverkostung" class="form-check-input" id="silber_bier">
								<label class="form-check-label small" for="silber_bier"><strong>mit Bierverkostung <br></strong> (4€ – 20–30min)</label>
							</div>
						</label>
					</div>

					<!-- GOLD -->
					<div class="col">
						<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
							<input type="radio" name="tour_type" value="gold" required class="mb-2">
							<img src="<?=base_url('img/webImage/STYX_Tour_Gold.jpg')?>" alt="Tour Gold" class="img-fluid mb-2">
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

					<!-- PLATIN -->
					<div class="col">
						<label class="select-card d-flex flex-column h-100 p-3 border rounded shadow-sm" onclick="selectCard(this, 'tour_type')">
							<input type="radio" name="tour_type" value="platin" required class="mb-2">
							<img src="<?=base_url('img/webImage/STYX_Tour_Platin.jpg')?>" alt="Tour Platin" class="img-fluid mb-2">
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


		<h5 class="mt-4">Zahlung *</h5>
		<div class="form-group d-flex flex-wrap">
			<div class="form-check mr-3">
				<input class="form-check-input" type="radio" name="payment" id="bar" value="Barzahlung" required>
				<label class="form-check-label" for="bar">Barzahlung</label>
			</div>
			<div class="form-check mr-3">
				<input class="form-check-input" type="radio" name="payment" id="ueberweisung" value="Überweisung">
				<label class="form-check-label" for="ueberweisung">Überweisung</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="payment" id="rechnung" value="Rechnung">
				<label class="form-check-label" for="rechnung">Rechnung</label>
			</div>
		</div>

		<!-- Sekcia: Nachricht -->
		<div class="form-group mt-3">
			<label>Ihre Nachricht</label>
			<textarea name="message" rows="4" class="form-control" placeholder="Anmerkungen, Sonderwünsche, etc."></textarea>
		</div>

		<!-- reCAPTCHA -->
		<div class="form-group mt-3">
			<div class="g-recaptcha" data-sitekey="<?=RECAPTCHA?>"></div>
		</div>

		<!-- Submit -->
		<div class="form-group mt-4 text-center">
			<button type="submit" class="btn btn-success btn-lg px-5">Anfrage abschicken</button>
		</div>

		</form>
	</div>
</div>


<!-- JS: reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
	function selectCard(element, group) {
		// Vyčisti pre všetky inputy tejto skupiny
		document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
			const card = input.closest('.select-card');
			if (card) card.classList.remove('active');
		});

		// Aktivuj aktuálnu
		element.classList.add('active');
		element.querySelector('input[type="radio"]').checked = true;
	}
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const input = document.getElementById('num_persons_input');
		const output = document.getElementById('person_info_output');

		const options = [
			{ range: [20, 40], text: '20–40 Pers.', time: '2 h' },
			{ range: [41, 60], text: '41–60 Pers.', time: '2,5 h' },
			{ range: [61, 80], text: '61–80 Pers.', time: '3 h' },
			{ range: [81, 100], text: '81–100 Pers.', time: '3,5 h' },
			{ range: [101, 150], text: '101–150 Pers.', time: '4 h' }
		];

		input.addEventListener('input', function () {
			const val = parseInt(input.value, 10);
			if (!val || val < 1) {
				output.classList.add('d-none');
				output.innerHTML = '';
				return;
			}

			let match = options.find(opt => val >= opt.range[0] && val <= opt.range[1]);

			if (match) {
				output.classList.remove('d-none');
				output.innerHTML = `Für <strong>${val} Personen</strong> haben wir das Paket im Bereich von <strong>${match.text}</strong> mit einer ungefähren Dauer von <strong>${match.time}</strong> zur Verfügung.`;
			} else {
				output.classList.remove('d-none');
				output.innerHTML = `Für <strong>${val} Personen</strong> haben wir derzeit kein passendes Paket verfügbar. Bitte kontaktieren Sie uns direkt.`;
			}
		});
	});
</script>

