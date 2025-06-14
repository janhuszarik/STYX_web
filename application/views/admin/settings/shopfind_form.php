<?php
// application/views/admin/shopfind/form.php
?>

<form method="post" action="<?= base_url('admin/shopfind') ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= isset($location->id) ? $location->id : '' ?>">

	<section class="card">
		<header class="card-header">
			<h3 class="card-title mb-0"><?= $title ?></h3>
		</header>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<label>Name *</label>
					<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($location->name ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label>Verantwortliche Person</label>
					<input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($location->contact_person ?? '') ?>">
				</div>

				<div class="col-md-6">
					<label>Adresse *</label>
					<input type="text" name="address" class="form-control" required value="<?= htmlspecialchars($location->address ?? '') ?>">
				</div>
				<div class="col-md-3">
					<label>PLZ *</label>
					<input type="text" name="zip_code" class="form-control" required value="<?= htmlspecialchars($location->zip_code ?? '') ?>">
				</div>
				<div class="col-md-3">
					<label>Stadt *</label>
					<input type="text" name="city" class="form-control" required value="<?= htmlspecialchars($location->city ?? '') ?>">
				</div>

				<div class="col-md-4">
					<label>Land</label>
					<input type="text" name="country" class="form-control" value="<?= htmlspecialchars($location->country ?? 'Österreich') ?>">
				</div>
				<div class="col-md-4">
					<label>E-Mail</label>
					<input type="email" name="email" class="form-control" value="<?= htmlspecialchars($location->email ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label>Telefon</label>
					<input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($location->phone ?? '') ?>">
				</div>

				<div class="col-md-6">
					<label>Website</label>
					<input type="url" name="website" class="form-control" placeholder="z.b.: https://www.websiteapp.eu"
						   value="<?= htmlspecialchars($location->website ?? 'https://') ?>"
						   pattern="https://.*">
				</div>
				<div class="col-md-6">
					<label>Logo</label>
					<input type="url" name="website" class="form-control"
						   placeholder="https://example.com"
						   value="<?= htmlspecialchars(!empty($location->website) && $location->website !== 'https://' ? $location->website : '') ?>">

				</div>

				<div class="row">
					<div class="col-12">
						<button type="button" class="btn btn-sm btn-outline-primary mb-6" id="copyMonday">Montag auf alle kopieren</button>
					</div>

					<?php
					$days = [
						'Montag' => 'monday',
						'Dienstag' => 'tuesday',
						'Mittwoch' => 'wednesday',
						'Donnerstag' => 'thursday',
						'Freitag' => 'friday',
						'Samstag' => 'saturday',
						'Sonntag' => 'sunday',
						'Feiertage' => 'holidays'
					];
					$hours = json_decode($location->opening_hours ?? '{}', true) ?: [];
					$counter = 0;

					foreach ($days as $dayName => $dayKey) {
						$startTime = $hours[$dayKey]['start'] ?? '';
						$endTime = $hours[$dayKey]['end'] ?? '';
						$closed = !empty($hours[$dayKey]['closed']) ? 'checked' : '';

						if ($counter % 2 === 0) echo '<div class="row mb-3"><div class="col-12 ps-4"><div class="row">';

						?>
						<div class="col-lg-6">
							<div class="mb-2 fw-bold"><?= $dayName ?></div>
							<div class="row">
								<div class="col-md-6 mb-2">
									<input type="time" name="opening_hours[<?= $dayKey ?>][start]" class="form-control"
										   value="<?= htmlspecialchars($startTime) ?>">
								</div>
								<div class="col-md-6 mb-2">
									<input type="time" name="opening_hours[<?= $dayKey ?>][end]" class="form-control"
										   value="<?= htmlspecialchars($endTime) ?>">
								</div>
								<div class="col-md-12">
									<div class="form-check mt-1">
										<input class="form-check-input closed-checkbox" type="checkbox"
											   id="closed_<?= $dayKey ?>"
											   name="opening_hours[<?= $dayKey ?>][closed]" value="1" <?= $closed ?>>
										<label class="form-check-label small" for="closed_<?= $dayKey ?>">Geschlossen</label>
									</div>
								</div>
							</div>
						</div>
						<?php

						if ($counter % 2 === 1) echo '</div></div></div>'; // zatvoríme vnútorný rad
						$counter++;
					}
					if ($counter % 2 !== 0) echo '</div></div></div>'; // zatvoríme ak ostal jeden deň bez dvojice
					?>
				</div>




				<div class="col-md-6">
					<label>Latitude</label>
					<input type="text" name="latitude" class="form-control" value="<?= htmlspecialchars($location->latitude ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label>Longitude</label>
					<input type="text" name="longitude" class="form-control" value="<?= htmlspecialchars($location->longitude ?? '') ?>">
				</div>
				<div class="col-md-12">
					<button type="button" onclick="getCoordinatesFromAddress()" class="btn btn-sm btn-outline-secondary mt-2">
						Koordinaten automatisch holen
					</button>
				</div>

				<div class="col-md-3">
					<label>Status</label><br>
					<input type="checkbox" name="active" value="1" <?= (!isset($location) || $location->active) ? 'checked' : '' ?>> Aktiv
				</div>
			</div>
		</div>
		<footer class="card-footer text-end">
			<a href="<?= base_url('admin/shopfind') ?>" class="btn btn-secondary">Zurück</a>
			<button type="submit" class="btn btn-success">Speichern</button>
		</footer>
	</section>
</form>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll('.closed-checkbox').forEach(function (checkbox) {
			const row = checkbox.closest('.row');
			const inputs = row.querySelectorAll('input[type="time"]');

			function toggleDisabled() {
				inputs.forEach(input => input.disabled = checkbox.checked);
			}

			checkbox.addEventListener('change', toggleDisabled);
			toggleDisabled(); // Apply on load
		});

		document.getElementById('copyMonday')?.addEventListener('click', function () {
			const monStart = document.querySelector('input[name="opening_hours[monday][start]"]').value;
			const monEnd = document.querySelector('input[name="opening_hours[monday][end]"]').value;

			const days = ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'holidays'];
			days.forEach(day => {
				document.querySelector(`input[name="opening_hours[${day}][start]"]`).value = monStart;
				document.querySelector(`input[name="opening_hours[${day}][end]"]`).value = monEnd;
				const checkbox = document.querySelector(`input[name="opening_hours[${day}][closed]"]`);
				if (checkbox) checkbox.checked = false;
			});
		});
	});
</script>
<script>
	function getCoordinatesFromAddress() {
		console.log('➡️ Spúšťam funkciu getCoordinatesFromAddress');

		const address = document.querySelector('input[name="address"]').value;
		const zip = document.querySelector('input[name="zip_code"]').value;
		const city = document.querySelector('input[name="city"]').value;
		const fullAddress = `${address}, ${zip} ${city}`;

		console.log('🔎 Adresa:', fullAddress);

		const apiKey = 'AIzaSyCZbtqHZxjo2p5oc7_0LBXksSqFhPFK3FQ';

		const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(fullAddress)}&key=${apiKey}`;

		fetch(url)
			.then(response => response.json())
			.then(data => {
				console.log('✅ API odpoveď:', data);
				if (data.status === "OK") {
					const result = data.results[0].geometry.location;
					document.querySelector('input[name="latitude"]').value = result.lat;
					document.querySelector('input[name="longitude"]').value = result.lng;
				} else {
					alert("Geocodovanie zlyhalo: " + data.status);
				}
			})
			.catch(err => {
				console.error("❌ Fetch error:", err);
				alert("Chyba pri požiadavke na Google API");
			});
	}
</script>


