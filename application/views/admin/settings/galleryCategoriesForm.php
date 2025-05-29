<section class="card">
	<header class="card-header">
		<h2 class="card-title"><?= isset($category) && $category ? 'Kategorie bearbeiten' : 'Kategorie hinzufügen' ?></h2>
		<p class="card-subtitle">Geben Sie die Daten für die Galerie-Kategorie ein</p>
	</header>
	<div class="card-body">
		<form action="<?= base_url('admin/galleryCategory/save') ?>" method="post">
			<?php if (isset($category) && $category && isset($category->id)): ?>
				<input type="hidden" name="id" value="<?= $category->id ?>">
			<?php endif; ?>

			<div class="row form-group pb-3">
				<div class="col-lg-6">
					<label class="col-form-label">Sprache</label>
					<select class="form-control" name="lang">
						<option value="de" <?= isset($category->lang) && $category->lang == 'de' ? 'selected' : '' ?>>Deutsch</option>
						<option value="en" <?= isset($category->lang) && $category->lang == 'en' ? 'selected' : '' ?>>English</option>
					</select>
				</div>
				<div class="col-lg-6">
					<label class="col-form-label">Aktiv?</label>
					<select name="active" class="form-control">
						<option value="1" <?= isset($category->active) && $category->active ? 'selected' : '' ?>>Ja</option>
						<option value="0" <?= isset($category->active) && !$category->active ? 'selected' : '' ?>>Nein</option>
					</select>
				</div>
			</div>

			<div class="form-group pb-3">
				<label class="col-form-label">Kategoriename</label>
				<input type="text" name="name" class="form-control" required value="<?= isset($category->name) ? htmlspecialchars($category->name) : '' ?>">
			</div>
			<div class="row form-group pb-3">
				<div class="col-lg-6">
					<label class="col-form-label">Keywords</label>
					<input type="text" name="keywords" class="form-control" value="<?= isset($category->keywords) ? htmlspecialchars($category->keywords) : '' ?>">
				</div>
				<div class="col-lg-6">
					<label class="col-form-label">Description</label>
					<input type="text" name="description" class="form-control" value="<?= isset($category->description) ? htmlspecialchars($category->description) : '' ?>">
				</div>
			</div>

			<footer class="card-footer text-end">
				<button type="submit" class="btn btn-primary"><?= isset($category) && $category ? 'Änderungen speichern' : 'Speichern' ?></button>
				<a href="<?= base_url('admin/galleryCategory') ?>" class="btn btn-secondary">Zurück</a>
			</footer>
		</form>
	</div>
</section>
