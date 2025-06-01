

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
						<div class="col-lg-6">
							<label class="col-form-label">Sprache</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($news->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($news->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Aktiv?</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($news->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($news->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">Hauptüberschrift</label>
						<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($news->name ?? '') ?>">
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">Kurztext</label>
						<input type="text" name="name1" class="form-control" required value="<?= htmlspecialchars($news->name1 ?? '') ?>">
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">URL (optional)</label>
						<input type="text" name="buttonUrl" class="form-control" value="<?= htmlspecialchars($news->buttonUrl ?? '') ?>">
						<small class="text-muted">Für externe Links das gesamte https:// angeben</small>
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">Bild hochladen</label>
						<input type="file" name="image" class="form-control">
						<?php if (!empty($news->image)): ?>
							<small class="text-muted">Aktuelles Bild: <img src="<?= base_url('Uploads/news/' . $news->image) ?>" style="width: 50px; margin-top: 5px;"></small>
						<?php endif; ?>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Startdatum*</label>
							<input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($news->start_date ?? '') ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Enddatum (optional)</label>
							<input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($news->end_date ?? '') ?>">
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
