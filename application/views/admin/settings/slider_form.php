<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($slider->id) ? 'Slider bearbeiten: ' . htmlspecialchars($slider->title) : 'Slider hinzufügen' ?></h2>
				<p class="card-subtitle">
					<?= isset($slider->id) ? 'Bearbeiten Sie bestehende Slider nach Bedarf.' : 'Geben Sie die Daten für den Slider ein' ?>
				</p>
			</header>

			<div class="card-body">
				<form method="post" action="<?= base_url('admin/sliderSave') ?>" enctype="multipart/form-data">
					<?php if (!empty($slider->id)): ?>
						<input type="hidden" name="id" value="<?= htmlspecialchars($slider->id) ?>">
					<?php endif; ?>

					<div class="row form-group pb-3">
						<div class="col-lg-2">
							<label class="col-form-label">Sprache</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($slider->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($slider->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Titel für Inhalt</label>
							<input type="text" name="title" class="form-control" value="<?= htmlspecialchars($slider->title ?? '') ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Unterüberschrift</label>
							<input type="text" name="name2" class="form-control" value="<?= htmlspecialchars($slider->name2 ?? '') ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Slider Bild</label>
							<input type="file" name="image" class="form-control">
							<?php if (!empty($slider->image)): ?>
								<small class="text-muted d-block mt-2">Aktuelles Bild:</small>
								<img src="<?= base_url('uploads/Sliders/' . $slider->image) ?>" style="max-width: 200px;" class="img-fluid rounded shadow-sm">
							<?php endif; ?>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Schaltflächenlink (optional)</label>
							<input type="text" name="button_link" class="form-control" value="<?= htmlspecialchars($slider->button_link ?? '') ?>">
							<small class="text-muted">Für externe Links das gesamte https:// angeben</small>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-3">
							<label class="col-form-label">Hintergrundfarbe</label>
							<input type="color" name="bg_color" class="form-control" style="height: 38px; padding: 4px 6px;" value="<?= htmlspecialchars($slider->bg_color ?? '#ffffff') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Textfarbe</label>
							<input type="color" name="text_color" class="form-control" style="height: 38px; padding: 4px 6px;" value="<?= htmlspecialchars($slider->text_color ?? '#000000') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Position</label>
							<input type="number" name="orderBy" class="form-control" required value="<?= htmlspecialchars($slider->orderBy ?? '') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Aktiv?</label>
							<input type="hidden" name="active" value="0">
							<select name="active" class="form-control">
								<option value="1" <?= !empty($slider->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($slider->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($slider->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/slider') ?>" class="btn btn-danger">Zurück zur Liste</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>
<script>
	// Validácia typu súboru na strane klienta
	document.querySelector('input[name="image"]').addEventListener('change', function(e) {
		const file = e.target.files[0];
		if (file) {
			const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
			if (!validTypes.includes(file.type)) {
				alert('Bitte wählen Sie ein gültiges Bildformat (JPG, PNG, GIF).');
				e.target.value = '';
			}
		}
	});
</script>
