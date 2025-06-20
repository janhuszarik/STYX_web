<style>
	/* Existing styles */
	.text-bold {
		font-weight: 600;
	}
	.select-card {
		border: 2px solid transparent;
		border-radius: 12px;
		padding: 20px;
		text-align: center;
		background-color: #fff;
		transition: all 0.2s ease-in-out;
		height: 100%;
		cursor: pointer;
		box-shadow: 0 2px 8px rgba(0,0,0,0.05);
	}
	.select-card:hover {
		border-color: #ccc;
	}
	.select-card input[type="radio"] {
		display: none;
	}
	.select-card img {
		max-height: 120px;
		margin-bottom: 15px;
	}
	.select-card.active {
		border-color: #28a745;
		background-color: #eaffea;
	}
	.select-card .fw-bold {
		font-size: 1.2rem;
	}
	.select-card small {
		font-size: 1rem;
	}
	.select-card p {
		font-size: 0.95rem;
		line-height: 1.4;
		margin-bottom: 0;
	}
	.section-heading {
		font-size: 1.4rem;
		font-weight: 600;
		margin-bottom: 15px;
		margin-top: 10px;
	}

	/* New and modified styles for better spacing */
	.geburtstagsauswahl-section {
		margin-bottom: 3rem;
	}

	.geburtstagsauswahl-section h3 {
		margin-bottom: 2rem;
	}

	.card-group {
		margin-bottom: 2rem;
	}

	.card-group h4 {
		margin-bottom: 1.5rem;
		margin-top: 2rem;
	}

	.select-card {
		margin-bottom: 1.5rem;
	}
</style>
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

	<div class="form-section">
		<div class="container my-5">
			<h2 class="fw-bold mb-2 text-bold">Kontaktdaten</h2>
			<p class="mb-0">Füllen Sie das Formular vollständig aus und richten Sie so Ihre Wünsche direkt an uns.</p>
		</div>

		<form>
			<div class="row mb-3">
				<div class="col-md-6">
					<label>Gewünschtes Veranstaltungsdatum *</label>
					<input type="date" class="form-control" required>
				</div>
				<div class="col-md-6">
					<label>Gewünschte Uhrzeit *</label>
					<input type="time" class="form-control" required>
				</div>
			</div>

			<div class="mb-3">
				<label>Name des Geburtstagskindes *</label>
				<input type="text" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>Alter des Geburtstagskind *</label>
				<input type="number" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>Anzahl der Kinder (max. 15) *</label>
				<input type="number" max="15" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>Ansprechperson *</label>
				<input type="text" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>E-Mail *</label>
				<input type="email" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>Telefonnummer *</label>
				<input type="tel" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>Straße & Hausnummer *</label>
				<input type="text" class="form-control" required>
			</div>
			<div class="mb-3">
				<label>PLZ, Ort *</label>
				<input type="text" class="form-control" required>
			</div>
	</div>

	<!-- Geburtstagspakete -->
	<div class="container my-5">
		<h3 class="fw-bold mb-4">Geburtstagsauswahl</h3>

		<!-- Riadok 1 – STYX Paket -->
		<div class="row g-5 mb-5">
			<!-- Shampoo -->
			<div class="col-md-6">
				<div class="mb-3">
					<h4 class="fw-bold mb-2">STYX Paket <span class="text-danger">*</span></h4>
				</div>
				<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'paket')">
					<input type="radio" name="paket" value="shampoo" required>
					<img src="<?=base_url('img/shampoo.png')?>" alt="Shampoo Paket">
					<div class="fw-bold mt-2 fs-5">Shampoo / Badesalz Paket</div>
					<small class="d-block mb-1">8+1 = €250, jedes weitere Kind: €20</small>
					<p class="small text-muted">*) eine Kinderführung durch die World of STYX, Shampoo und/oder Badesalz selbst herstellen, Duft-Ratespiel, Schokoladenverkostung, kleine Stärkung – Dauer ca. 2,5 Stunden</p>
				</label>
			</div>

			<!-- Schokolade -->
			<div class="col-md-6">
				<div class="mb-3">
					<h4 class="fw-bold mb-2 invisible">STYX Paket</h4> <!-- skryté pre výšku -->
				</div>
				<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'paket')">
					<input type="radio" name="paket" value="schoko" required>
					<img src="<?=base_url('img/schoko.png')?>" alt="Schoko Paket">
					<div class="fw-bold mt-2 fs-5">Schokolade Paket</div>
					<small class="d-block mb-1">8+1 = €300, jedes weitere Kind: €25</small>
					<p class="small text-muted">*) Schokoführung, Schokoriegel & Marzipankugel herstellen und verzieren, Kostproben mitnehmen, kleine Stärkung – Dauer ca. 2,5 Stunden</p>
				</label>
			</div>
		</div>

		<!-- Riadok 2 – STYX Torte a Jause -->
		<div class="row g-5">
			<!-- STYX Torte -->
			<div class="col-md-6">
				<div class="mb-3">
					<h4 class="fw-bold mb-2">STYX Torte <span class="text-danger">*</span></h4>
				</div>
				<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'torte')">
					<input type="radio" name="torte" value="ja" required>
					<img src="<?=base_url('img/torte.png')?>" alt="STYX Torte">
					<div class="fw-bold mt-2 fs-5">STYX Torte</div>
					<small class="d-block mb-1">Zusätzlich €45</small>
					<p class="small text-muted">Bunte Geburtstagstorte für die Kinder</p>
				</label>
			</div>

			<!-- Jause – Toast a Würstel -->
			<div class="col-md-6">
				<div class="mb-3">
					<h4 class="fw-bold mb-2">Jause <span class="text-danger">*</span></h4>
				</div>
				<div class="row g-3">
					<!-- Würstel -->
					<div class="col-sm-6">
						<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'jause')">
							<input type="radio" name="jause" value="wurst" required>
							<img src="<?=base_url('img/wurst.png')?>" alt="Würstel & Semmel">
							<div class="fw-bold mt-2 fs-6">Würstel & Semmel</div>
							<small class="d-block text-success mb-1">Im Paketpreis inklusive</small>
							<p class="small text-muted">Beliebter Klassiker für alle Kinder</p>
						</label>
					</div>

					<!-- Toast -->
					<div class="col-sm-6">
						<label class="select-card d-flex flex-column h-100" onclick="selectCard(this, 'jause')">
							<input type="radio" name="jause" value="toast" required>
							<img src="<?=base_url('img/toast.png')?>" alt="Toast">
							<div class="fw-bold mt-2 fs-6">Toast (Schinken & Käse)</div>
							<small class="d-block text-success mb-1">Im Paketpreis inklusive</small>
							<p class="small text-muted">Warmer, leckerer Snack mit Schinken und Käse</p>
						</label>
					</div>
				</div>
				<div class="form-text text-danger mt-2">Jause im Paketpreis inklusive!</div>
			</div>
		</div>
	</div>





	<div class="form-section">
		<div class="mb-3">
			<label>Anmerkung</label>
			<textarea class="form-control" rows="4"></textarea>
		</div>
		<div class="mb-3">
			<p class="text-danger">Richten Sie bitte Ihre Terminanfrage <strong>mindestens 2 Wochen</strong> im Vorraus an uns!</p>
			<label>Sicherheitsüberprüfung: Bitte geben Sie das aktuelle Datum ein (z.B. 31.05.2024) *</label>
			<input type="text" class="form-control" placeholder="TT.MM.JJJJ" required>
		</div>
		<button type="submit" class="btn btn-success">Anfrage abschicken</button>
		</form>
	</div>

</div>

<script>
	function selectCard(el, groupName) {
		document.querySelectorAll(`input[name="${groupName}"]`).forEach(input => {
			input.closest('.select-card').classList.remove('active');
		});
		el.classList.add('active');
		el.querySelector('input').checked = true;
	}
</script>



