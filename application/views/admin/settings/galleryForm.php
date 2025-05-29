<section class="card">
	<header class="card-header">
		<h2 class="card-title"><?= isset($gallery) ? 'Galerie bearbeiten' : 'Galerie hinzufügen' ?></h2>
		<p class="card-subtitle">Geben Sie den Namen der Galerie ein</p>
	</header>
	<div class="card-body">
		<form action="<?= base_url('admin/gallery/save') ?>" method="post">
			<input type="hidden" name="category_id" value="<?= $category_id ?>">
			<?php if (isset($gallery) && $gallery): ?>
				<input type="hidden" name="id" value="<?= $gallery->id ?>">
			<?php endif; ?>
			<div class="form-group pb-3">
				<label class="col-form-label">Galeriename</label>
				<input type="text" name="name" class="form-control" required value="<?= isset($gallery) && $gallery ? htmlspecialchars($gallery->name) : '' ?>">
			</div>
			<div class="form-group pb-3">
				<label class="col-form-label">Aktiv?</label>
				<select name="active" class="form-control">
					<option value="1" <?= isset($gallery) && $gallery->active ? 'selected' : '' ?>>Ja</option>
					<option value="0" <?= isset($gallery) && !$gallery->active ? 'selected' : '' ?>>Nein</option>
				</select>
			</div>
			<footer class="card-footer text-end">
				<button type="submit" class="btn btn-primary"><?= isset($gallery) ? 'Änderungen speichern' : 'Speichern' ?></button>
				<a href="<?= $category_id ? base_url('admin/galleries_in_category/' . $category_id) : base_url('admin/galleryCategory') ?>" class="btn btn-secondary">Zurück</a>
			</footer>
		</form>
	</div>
</section>
