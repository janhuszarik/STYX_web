<?php
$actionUrl = isset($article) ? 'admin/article_save/edit/' . $article->id : 'admin/article_save';
?>

<form method="post" action="<?= base_url($actionUrl) ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $article->id ?? '' ?>">

	<!-- Riadok: Title + Subtitle -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="title">Titel</label>
			<input type="text" class="form-control" name="title" id="title" value="<?= isset($article) ? htmlspecialchars($article->title) : '' ?>" required>
		</div>
		<div class="col-md-6">
			<label for="subtitle">Untertitel</label>
			<input type="text" class="form-control" name="subtitle" id="subtitle" value="<?= isset($article) ? htmlspecialchars($article->subtitle) : '' ?>">
		</div>
	</div>

	<!-- Riadok: Slug (disabled) + Kategorie -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="slug">Slug</label>
			<input type="text" class="form-control" id="slug" value="<?= isset($article) ? $article->slug : '' ?>" disabled>
		</div>
		<div class="col-md-6">
			<label for="category_id">Kategorie</label>
			<select name="category_id" class="form-control" id="category_id">
				<?php foreach ($articleCategories as $cat): ?>
					<option value="<?= $cat->id ?>" <?= (isset($article) && $article->category_id == $cat->id) ? 'selected' : '' ?>>
						<?= htmlspecialchars($cat->name) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<!-- Riadok: Hauptbild (upload) + aktuálny obrázok -->
	<div class="row form-group pb-3">
		<div class="col-md-8">
			<label for="image">Hauptbild hochladen</label>
			<input type="file" class="form-control" name="image" id="image">
			<input type="hidden" name="old_image" value="<?= $article->image ?? '' ?>">
		</div>
		<div class="col-md-4">
			<?php if (!empty($article->image)): ?>
				<label>Aktuelles Bild</label>
				<div class="mt-1">
					<img src="<?= base_url('uploads/articles/' . $article->image) ?>" alt="Artikelbild" class="img-fluid" style="max-width: 50%;">
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Vorlage -->
	<div class="form-group pb-3">
		<label for="templatePicker">Vorlage auswählen</label>
		<select id="templatePicker" class="form-control mb-3">
			<option value="">– Bitte wählen –</option>
		</select>
	</div>

	<!-- Inhalt -->
	<div class="row form-group pb-3">
		<div class="col-lg-12">
			<label for="text">Inhalt</label>
			<div id="summernote"><?= !empty($article->text) ? htmlspecialchars_decode($article->text) : '' ?></div>
			<input type="hidden" name="text" id="text">
		</div>
	</div>

	<!-- Keywords + Meta -->
	<div class="form-group pb-3">
		<div class="col-md-12">
			<label for="keywords">Keywords</label>
			<input type="text" class="form-control" name="keywords" id="keywords" value="<?= isset($article) ? htmlspecialchars($article->keywords) : '' ?>">
		</div>
	</div>
	<div class="form-group pb-3">
		<div class="col-md-12">
			<label for="meta">Meta</label>
			<input type="text" class="form-control" name="meta" id="meta" value="<?= isset($article) ? htmlspecialchars($article->meta) : '' ?>">
		</div>
	</div>


	<!-- Startdatum + Enddatum + Status -->
	<div class="row form-group pb-3">
		<div class="col-md-4">
			<label for="start_date_from">Startdatum</label>
			<input type="date" class="form-control" name="start_date_from" id="start_date_from" value="<?= isset($article->start_date_from) ? $article->start_date_from : '' ?>">
		</div>
		<div class="col-md-4">
			<label for="end_date_to">Enddatum</label>
			<input type="date" class="form-control" name="end_date_to" id="end_date_to" value="<?= isset($article->end_date_to) ? $article->end_date_to : '' ?>">
		</div>
		<div class="col-md-4">
			<label for="active">Status</label>
			<select name="active" class="form-control" id="active">
				<option value="1" <?= isset($article) && $article->active == '1' ? 'selected' : '' ?>>Aktiv</option>
				<option value="0" <?= isset($article) && $article->active == '0' ? 'selected' : '' ?>>Inaktiv</option>
			</select>
		</div>
	</div>

	<!-- Buttons -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Speichern</button>
		<a href="<?= base_url('admin/articles_in_category/' . $categoryId) ?>" class="btn btn-secondary">Zurück</a>
	</div>
</form>
<script>
	const BASE_URL = '<?= base_url() ?>';
</script>
