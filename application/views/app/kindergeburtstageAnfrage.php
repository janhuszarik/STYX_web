
<div class="container my-5">

	<div class="form-section">
		<h2>Kontaktdaten</h2>
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
	<div class="form-section">
		<h2>Geburtstagspakete</h2>
		<p>(Infos zu den Paketen finden Sie unter: <a href="#">STYX Kindergeburtstage</a>)</p>
		<div class="mb-3">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="paket" id="shampoo" required>
				<label class="form-check-label" for="shampoo">Shampoo / Badesalz Paket *</label>
			</div>
			<small>8+1 = €250, jedes weitere Kind: €20 – Dauer ca. 2.5h</small>
		</div>
		<div class="mb-3">
			<div class="form-check">
				<input class="form-check-input" type="radio" name="paket" id="schoko" required>
				<label class="form-check-label" for="schoko">Schokolade Paket *</label>
			</div>
			<small>8+1 = €300, jedes weitere Kind: €25 – Dauer ca. 2.5h</small>
		</div>
	</div>

	<!-- Verköstigung -->
	<div class="form-section">
		<h2>Verköstigung</h2>

		<div class="mb-3">
			<label>STYX Torte (zusätzlich €45) *</label><br>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="torte" value="ja" required>
				<label class="form-check-label">Ja</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="torte" value="nein" required>
				<label class="form-check-label">Nein</label>
			</div>
		</div>

		<div class="mb-3">
			<label>Jause *</label><br>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="jause" value="Würstel & Semmel" required>
				<label class="form-check-label">Würstel & Semmel</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="jause" value="Toast" required>
				<label class="form-check-label">Toast (Schinken & Käse)</label>
			</div>
			<div class="form-text text-danger">Jause im Paketpreis inklusive!</div>
		</div>
	</div>

	<!-- Anmerkung a Sicherheitsprüfung -->
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


