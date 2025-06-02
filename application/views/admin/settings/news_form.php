

<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($news->id) ? 'News bearbeiten: ' . htmlspecialchars($news->name) : 'News hinzufügen' ?></h2>
				<p class="card-subtitle">
					<?= isset($news->id) ? 'Bearbeiten Sie bestehende News nach Bedarf.' : 'Geben Sie die Daten für die News ein' ?>
				</p>
			</header>

			<div class="card-body">
				<form method="post" action="<?= base_url(isset($news->id) ? 'admin/news/edit/' . $news->id : 'admin/newsSave') ?>" enctype="multipart/form-data">
					<?php if (!empty($news->id)): ?>
						<input type="hidden" name="id" value="<?= $news->id ?>">
					<?php endif; ?>

					<div class="row form-group pb-3">
						<div class="col-lg-4">
							<label class="col-form-label">Sprache
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Sprache, unter der der Inhalt angezeigt wird."></i>
							</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($news->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($news->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Hauptüberschrift
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Hauptüberschrift, die als großer Text in der Karte angezeigt wird."></i>
							</label>
							<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($news->name ?? '') ?>">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Kurztext
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Kurzer Text, der unter der Hauptüberschrift angezeigt wird."></i>
							</label>
							<input type="text" name="name1" class="form-control" required value="<?= htmlspecialchars($news->name1 ?? '') ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-4">
							<label class="col-form-label">URL*
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL sollte nicht leer bleiben, da „News“ so konzipiert ist, dass der Besucher über die Karte immer zu einem Artikel, Produkt oder einer Kampagne weitergeleitet wird. Wichtig ist, die Struktur der URL einzuhalten – sie muss mit https:// beginnen."></i>
							</label>
							<input type="text" name="buttonUrl" class="form-control" value="<?= htmlspecialchars($news->buttonUrl ?? '') ?>">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Bild hochladen
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Das Bild sollte die Maße **300x300 px** haben. Wenn das Bild größer ist, wird es von der Karte automatisch zugeschnitten. Ein hochgeladenes Bild im Format **600x600 px** aus dem Newsletter bleibt weiterhin gut erkennbar. Wichtig ist lediglich, dass die **Dateigröße 3 MB nicht überschreitet** – die **ideale Größe liegt bei ca. 900 KB**."></i>
							</label>
							<input type="file" name="image" class="form-control">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Aktueller Bildvorschau</label>
							<div>
								<?php if (!empty($news->image)): ?>
									<img src="<?= base_url('Uploads/news/' . $news->image) ?>" style="width: 100px; margin-top: 5px; border: 1px solid #ddd; padding: 2px;">
									<small class="text-muted d-block">Aktuelles Bild</small>
								<?php else: ?>
									<small class="text-muted">Kein Bild hochgeladen</small>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="form-group pb-3">

					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-4">
							<label class="col-form-label">Startdatum (optional)
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Startdatum der Karte. Nach Eingabe des Datums wird die Karte am angegebenen Datum automatisch aktiviert.Das bedeutet: Wenn z. B. der 28.01.2025 eingegeben wird, erscheint die Karte am 28.01.2025 um 00:00 Uhr. Wenn kein Datum eingegeben wird, läuft der Beitrag ohne zeitliche Begrenzung** und wird sofort nach dem Speichern** angezeigt."></i>
							</label>
							<input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($news->start_date ?? '') ?>">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Enddatum (optional)
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Enddatum der Karte. Nach Eingabe des Datums wird die Karte am angegebenen Datum automatisch deaktiviert.Das bedeutet: Wenn z. B. der 30.01.2025 eingegeben wird, wird die Karte am 30.01.2025 um 23:59 Uhr automatisch abgeschaltet. Wichtig: Der Beitrag muss als „Aktiv“ markiert sein, selbst wenn ein Start- und Enddatum definiert ist."></i>
							</label>
							<input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($news->end_date ?? '') ?>">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Aktiv?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Auswahl, ob der Menüpunkt aktiv sein soll oder verborgen bleibt und für die Öffentlichkeit nicht sichtbar ist."></i>
							</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($news->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($news->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($news->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/news') ?>" class="btn btn-danger">Zurück zur Liste</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>
