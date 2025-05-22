<?php
$actionUrl = isset($article) ? 'admin/article_save/edit/' . $article->id : 'admin/article_save';
$titleHeadline = isset($article) ? 'Artikel bearbeiten: ' . htmlspecialchars($article->title) : 'Neuen Artikel erstellen';
$titleSub = isset($article) ? 'Bestehenden Artikel nach Bedarf anpassen.' : 'Neuen Artikel nach Bedarf erstellen.';
?>

<form method="post" action="<?= base_url($actionUrl) ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $article->id ?? '' ?>">

	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left: 4px solid #28a745; padding-left: 10px;">
			<?= $titleHeadline ?>
		</h3>
		<small class="text-muted ms-3"><?= $titleSub ?></small>
	</div>
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
					<option value="<?= $cat->id ?>" <?= (isset($article) && $article->category_id == $cat->id) ? 'selected' : '' ?> required>
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
		<label>Inhaltssektionen</label>
		<div id="sections-container"></div>
		<button type="button" class="btn btn-sm btn-success mt-2" id="add-section">+ Sektion hinzufügen</button>
	</div>
	<hr class="my-4 border border-dark">
	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left: 4px solid #28a745; padding-left: 10px;">SEO-Einstellungen des Artikels</h3>
		<small class="text-muted ms-3">Geben Sie Keywords und Meta-Titel durch Kommas getrennt ein. Das System fügt diese Daten automatisch in den Code ein, um die korrekten Einstellungen und Anzeigen für Google zu gewährleisten.</small>
	</div>
	<!-- Keywords & Meta -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="keywords">Schlüsselwörter</label>
			<input type="text" class="form-control" name="keywords" value="<?= $article->keywords ?? '' ?>">
		</div>
		<div class="col-md-6">
			<label for="meta">Meta-Beschreibung</label>
			<input type="text" class="form-control" name="meta" value="<?= $article->meta ?? '' ?>">
		</div>
	</div>

	<hr class="my-4 border border-dark">

	<div class="form-group pb-3">
		<div class="mb-3">
			<h3 class="fw-bold mb-1" style="border-left: 4px solid #28a745; padding-left: 10px;">Sektion Empfohlene Produkte</h3>
			<small class="text-muted ms-3">Diese Sektion wird unter dem Artikel als empfohlene Produkte zum Thema angezeigt. Die Sektion kann, falls nicht benötigt, leer bleiben.</small>
		</div>
		<div class="row">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4">
					<div class="mb-2">
						<label for="product_name<?= $i ?>">Produktname <?= $i ?></label>
						<input type="text" class="form-control" name="product_name<?= $i ?>" value="<?= $article->{'product_name'.$i} ?? '' ?>">
					</div>
					<div class="mb-2">
						<label for="product_description<?= $i ?>">Beschreibung <?= $i ?></label>
						<textarea class="form-control" name="product_description<?= $i ?>" rows="2"><?= $article->{'product_description'.$i} ?? '' ?></textarea>
					</div>
					<div class="mb-2">
						<label for="product_image<?= $i ?>">Bild <?= $i ?></label>
						<input type="file" class="form-control" name="product_image<?= $i ?>">
						<?php if (!empty($article->{'product_image'.$i})): ?>
							<div class="mt-1"><img src="<?= base_url('uploads/articles/products/' . $article->{'product_image'.$i}) ?>" class="img-fluid"></div>
						<?php endif; ?>
					</div>
					<div class="mb-2">
						<label for="product_url<?= $i ?>">Produkt-URL <?= $i ?></label>
						<input type="text" class="form-control" name="product_url<?= $i ?>" value="<?= $article->{'product_url'.$i} ?? '' ?>">
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border border-dark">
	<div class="form-group pb-3">
		<div class="mb-3">
			<h3 class="fw-bold mb-1" style="border-left: 4px solid #28a745; padding-left: 10px;">Sektion „Das könnte Sie interessieren“</h3>
			<small class="text-muted ms-3">Diese Sektion wird unter den empfohlenen Produkten angezeigt. Falls die Sektion nicht benötigt wird, muss sie nicht ausgefüllt werden.</small>
		</div>
		<div class="row">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4">
					<div class="mb-2">
						<label for="empfohlen_name<?= $i ?>">Titel <?= $i ?></label>
						<input type="text" class="form-control" name="empfohlen_name<?= $i ?>" value="<?= $article->{'empfohlen_name'.$i} ?? '' ?>">
					</div>
					<div class="mb-2">
						<label for="empfohlen_url<?= $i ?>">URL <?= $i ?></label>
						<input type="text" class="form-control" name="empfohlen_url<?= $i ?>" value="<?= $article->{'empfohlen_url'.$i} ?? '' ?>">
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border border-dark">
	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left: 4px solid #28a745; padding-left: 10px;">Veröffentlichungseinstellungen</h3>
		<small class="text-muted ms-3">In dieser Sektion können Sie das Start- und Enddatum für die Veröffentlichung des Artikels festlegen. Die Aktivierung bzw. Deaktivierung erfolgt automatisch um Mitternacht. Beispiel: Wird das Enddatum auf den 25.01.2025 gesetzt, wird der Artikel in der Nacht vom 24.01. auf den 25.01. deaktiviert. Der Artikel muss unabhängig von den Zeiteinstellungen den Status „Aktiv“ haben. Bei Status „Inaktiv“ wird der Artikel auch am angegebenen Startdatum nicht veröffentlicht.</small>
	</div>

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
	<hr class="my-4 border border-dark">

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
		function reinitSummernote() {
			$('.summernote').summernote({
				height: 200
			});
		}

		document.getElementById('add-section').addEventListener('click', function () {
			addSection();
			reinitSummernote();
		});

		document.getElementById('sections-container').addEventListener('click', function (e) {
			if (e.target.classList.contains('remove-section')) {
				e.target.closest('[data-section]').remove();
				sectionCount--;
			}
		});

		if (sectionsData.length) {
			sectionsData.forEach(sec => {
				const imagePath = sec.image ? "<?= base_url('uploads/articles/sections/') ?>" + sec.image : null;
				addSection(sec.content, imagePath);
			});
			reinitSummernote();
		}
	});
</script>
