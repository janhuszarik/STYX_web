<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($menu->id) ? 'Menüpunkt bearbeiten: ' . htmlspecialchars($menu->name) : 'Menüpunkt hinzufügen' ?></h2>
				<p class="card-subtitle">
					<?= isset($menu->id) ? 'Bearbeiten Sie bestehendes Menüelement nach Bedarf.' : 'Geben Sie die Daten für das Menüelement ein' ?>
				</p>
			</header>

			<div class="card-body">
				<form method="post" action="<?= base_url(isset($menu->id) ? 'admin/menu/edit/' . $menu->id : 'admin/menuSave') ?>">
					<?php if (!empty($menu->id)): ?>
						<input type="hidden" name="id" value="<?= $menu->id ?>">
					<?php endif; ?>
					<!-- Skryté pole pre jazyk -->
					<input type="hidden" name="lang" value="<?= htmlspecialchars($menu->lang ?? 'de') ?>">

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Sprache
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Sprachauswahl, in der dieser Menüpunkt angezeigt wird."></i>
							</label>
							<select class="form-control" name="lang_display" onchange="document.querySelector('input[name=lang]').value = this.value">
								<option value="de" <?= ($menu->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($menu->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Aktiv?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Auswahl, ob der Menüpunkt aktiv sein soll oder verborgen bleibt und für die Öffentlichkeit nicht sichtbar ist."></i>
							</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($menu->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($menu->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Name des Menüpunkt
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Hauptname des Menüpunktes. Aus diesem Namen wird auch die URL generiert, auf die der Benutzer nach dem Klick weitergeleitet wird. Daher bitte korrekt und ohne Sonderzeichen ausfüllen!"></i>
							</label>
							<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($menu->name ?? '') ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">URL (interne oder externe)
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wenn dieses Feld leer bleibt, wird die URL automatisch generiert. Für externe URLs geben Sie die vollständige Adresse ein, z.B. https://www.styx.at. Externe URLs müssen mit http:// oder https:// beginnen und werden genau so gespeichert, wie eingegeben."></i>
							</label>
							<input type="text" name="url" class="form-control" value="<?= htmlspecialchars($menu->url ?? '') ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Hauptmenüpunkt?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="In diesem Abschnitt muss ausgewählt werden, ob es sich um einen Hauptmenüpunkt oder um einen Unterpunkt eines bestehenden Menüs handelt."></i>
							</label>
							<select name="parent" class="form-control">
								<option value="0" <?= ($menu->parent ?? 0) == 0 ? 'selected' : '' ?>>Ja, Hauptmenü</option>
								<?php foreach ($menuparent as $parentItem): ?>
									<?php if ($parentItem->parent == 0): ?>
										<option value="<?= $parentItem->id ?>" <?= ($menu->parent ?? 0) == $parentItem->id ? 'selected' : '' ?>>
											<?= htmlspecialchars($parentItem->name) ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Position
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Position, an der sich der Menüpunkt befinden wird. Das bedeutet die Reihenfolge von oben nach unten – oder in einer Zeile, wenn es sich um einen Hauptmenüpunkt handelt. Die Nummerierung sollte immer bei 0 beginnen. Position 0 ist stets die erste und hat Vorrang vor allen anderen Nummern."></i>
							</label>
							<input type="number" name="orderBy" class="form-control" min="0" value="<?= htmlspecialchars($menu->orderBy ?? '') ?>">
						</div>
					</div>

					<div class="form-group pb-3">
						<div class="checkbox-custom">
							<input type="checkbox" id="base" name="base" value="1" <?= !empty($menu->base) ? 'checked' : '' ?>>
							<label for="base">Leerer Menü-Button
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Durch das Aktivieren dieses Feldes wird der aktuelle Menüpunkt in eine nicht anklickbare Form versetzt. Das bedeutet, dass der Menüpunkt keine Weiterleitung ausführt – zum Beispiel, wenn er nur als Informations- oder Trennpunkt dient. Wenn ein Menüpunkt ein Hauptpunkt ist und weitere Unterpunkte unter sich hat, wird er automatisch nicht anklickbar."></i>
							</label>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($menu->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/menu') ?>" class="btn btn-danger">Zurück zur Liste</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>

<script>
	document.querySelector('form').addEventListener('submit', function(e) {
		const urlInput = document.querySelector('input[name="url"]');
		const urlValue = urlInput.value.trim();

		// Check if URL is non-empty and looks like an external URL
		if (urlValue && (urlValue.startsWith('http://') || urlValue.startsWith('https://'))) {
			// Basic URL format validation
			const urlPattern = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;
			if (!urlPattern.test(urlValue)) {
				e.preventDefault();
				alert('Bitte geben Sie eine gültige URL ein (z.B. https://www.example.com).');
				urlInput.focus();
			}
		}
	});
</script>
