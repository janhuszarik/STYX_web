<?php
$actionUrl = isset($article) ? 'admin/article_save/edit/' . $article->id : 'admin/article_save';
?>

<form method="post" action="<?= base_url($actionUrl) ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $article->id ?? '' ?>">

	<!-- Titel & Subtitle -->
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

	<!-- Kategorie & Slug (readonly) -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="category_id">Kategorie</label>
			<select name="category_id" class="form-control">
				<?php foreach ($articleCategories as $cat): ?>
					<option value="<?= $cat->id ?>" <?= (isset($article) && $article->category_id == $cat->id) ? 'selected' : '' ?>>
						<?= htmlspecialchars($cat->name) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-6">
			<label for="slug">Slug</label>
			<input type="text" class="form-control" id="slug" value="<?= isset($article) ? $article->slug : '' ?>" readonly>
		</div>
	</div>

	<!-- Hauptbild -->
	<div class="row form-group pb-3">
		<div class="col-md-8">
			<label for="image">Hauptbild hochladen</label>
			<input type="file" class="form-control" name="image">
			<input type="hidden" name="old_image" value="<?= $article->image ?? '' ?>">
		</div>
		<div class="col-md-4">
			<?php if (!empty($article->image)): ?>
				<label>Aktuelles Bild</label>
				<div><img src="<?= base_url('uploads/articles/' . $article->image) ?>" class="img-fluid"></div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Dynamischer Inhalt (Sektionen) -->
	<div class="form-group pb-3">
		<label>Inhalt-Sektionen</label>
		<div id="sections-container"></div>
		<button type="button" class="btn btn-sm btn-success mt-2" id="add-section">+ Sektion hinzufügen</button>
	</div>

	<!-- Keywords & Meta -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="keywords">Keywords</label>
			<input type="text" class="form-control" name="keywords" value="<?= $article->keywords ?? '' ?>">
		</div>
		<div class="col-md-6">
			<label for="meta">Meta</label>
			<input type="text" class="form-control" name="meta" value="<?= $article->meta ?? '' ?>">
		</div>
	</div>

	<!-- Datum & Status -->
	<div class="row form-group pb-3">
		<div class="col-md-4">
			<label for="start_date_from">Startdatum</label>
			<input type="date" class="form-control" name="start_date_from" value="<?= $article->start_date_from ?? '' ?>">
		</div>
		<div class="col-md-4">
			<label for="end_date_to">Enddatum</label>
			<input type="date" class="form-control" name="end_date_to" value="<?= $article->end_date_to ?? '' ?>">
		</div>
		<div class="col-md-4">
			<label for="active">Status</label>
			<select name="active" class="form-control">
				<option value="1" <?= isset($article) && $article->active == '1' ? 'selected' : '' ?>>Aktiv</option>
				<option value="0" <?= isset($article) && $article->active == '0' ? 'selected' : '' ?>>Inaktiv</option>
			</select>
		</div>
	</div>

	<!-- Submit -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Speichern</button>
		<a href="<?= base_url('admin/articles_in_category/' . $categoryId) ?>" class="btn btn-secondary">Zurück</a>
	</div>
</form>

<script>
let sectionCount = 0;
const maxSections = 6;
const sectionsData = <?= isset($sections) ? json_encode($sections) : '[]' ?>;

function addSection(content = '', imagePath = null) {
	if (sectionCount >= maxSections) return;
	sectionCount++;

	const sectionHtml = `
	<div class="row align-items-start border p-2 mb-2" data-section="${sectionCount}">
		<div class="col-md-9">
			<textarea name="sections[]" class="form-control summernote" rows="3">${content}</textarea>
		</div>
		<div class="col-md-3">
			<input type="file" name="section_images[]" class="form-control mb-1">
			${imagePath ? `<div><img src="${imagePath}" class="img-fluid mt-2"></div>` : ''}
			<button type="button" class="btn btn-sm btn-danger remove-section w-100">– Entfernen</button>
		</div>
	</div>`;

	document.querySelector('#sections-container').insertAdjacentHTML('beforeend', sectionHtml);
}

document.addEventListener('DOMContentLoaded', function () {
	// Inicializuj summernote pre dynamicky vložené sekcie
	function reinitSummernote() {
		$('.summernote').summernote({
			height: 200
		});
	}

	// Pridať novú sekciu
	document.getElementById('add-section').addEventListener('click', function () {
		addSection();
		reinitSummernote();
	});

	// Odstrániť sekciu
	document.getElementById('sections-container').addEventListener('click', function (e) {
		if (e.target.classList.contains('remove-section')) {
			e.target.closest('[data-section]').remove();
			sectionCount--;
		}
	});

	// Načítaj existujúce sekcie
	if (sectionsData.length) {
		sectionsData.forEach(sec => {
			const imagePath = sec.image ? "<?= base_url('uploads/articles/sections/') ?>" + sec.image : null;
			addSection(sec.content, imagePath);
		});
		reinitSummernote();
	}
});
</script>
