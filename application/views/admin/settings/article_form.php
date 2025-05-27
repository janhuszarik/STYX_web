<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Určenie URL akcie a nadpisov na základe toho, či ide o úpravu alebo vytvorenie článku
$actionUrl = isset($article)
	? 'admin/article_save/edit/' . $article->id
	: 'admin/article_save';
$titleHeadline = isset($article)
	? 'Artikel bearbeiten: ' . htmlspecialchars($article->title)
	: 'Neuen Artikel erstellen';
$titleSub = isset($article)
	? 'Bestehenden Artikel nach Bedarf anpassen.'
	: 'Neuen Artikel nach Bedarf erstellen.';
?>

<form method="post" action="<?= base_url($actionUrl) ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $article->id ?? '' ?>">

	<!-- Überschrift -->
	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
			<?= $titleHeadline ?>
		</h3>
		<small class="text-muted ms-3"><?= $titleSub ?></small>
	</div>

	<!-- Titel / Untertitel -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="title">Titel</label>
			<input type="text" class="form-control" name="title" id="title"
				   value="<?= htmlspecialchars($article->title ?? '') ?>" required>
		</div>
		<div class="col-md-6">
			<label for="subtitle">Untertitel</label>
			<input type="text" class="form-control" name="subtitle" id="subtitle"
				   value="<?= htmlspecialchars($article->subtitle ?? '') ?>">
		</div>
	</div>

	<!-- Kategorie / Slug -->
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="category_id">Kategorie</label>
			<select name="category_id" class="form-control" required>
				<?php foreach ($articleCategories as $cat): ?>
					<option value="<?= $cat->id ?>"
						<?= (isset($article) && $article->category_id == $cat->id) ? 'selected' : '' ?>>
						<?= htmlspecialchars($cat->name) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-6">
			<label for="slug">Slug</label>
			<input type="text" class="form-control" id="slug"
				   value="<?= $article->slug ?? '' ?>" readonly>
		</div>
	</div>

	<!-- Hauptbild + FTP-Auswahl -->
	<div class="row form-group pb-3">
		<div class="col-md-8">
			<label for="image">Hauptbild hochladen</label>
			<input type="file" class="form-control" name="image">
			<input type="hidden" name="old_image" value="<?= $article->image ?? '' ?>">

			<div class="mt-2">
				<button type="button" class="btn btn-secondary btn-sm" id="chooseFtpImage">
					Bild aus FTP wählen
				</button>
				<div id="ftpImagePreview" class="mt-2"></div>
				<input type="hidden" name="ftp_image" id="ftpImageInput">
			</div>

			<!-- FTP-Modal -->
			<div class="modal fade" id="ftpModal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Wählen Sie ein Bild aus FTP</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
						</div>
						<div class="modal-body" id="ftpModalBody">
							<?php $this->load->view('admin/settings/ftp_modal'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<?php if (!empty($article->image)): ?>
				<label>Aktuelles Bild (Upload)</label>
				<div>
					<img src="<?= base_url('Uploads/articles/' . $article->image) ?>" class="img-fluid">
				</div>
			<?php endif; ?>
		</div>
	</div>

	<!-- Inhaltssektionen -->
	<div class="form-group pb-3">
		<label>Inhaltssektionen</label>
		<div id="sections-container"></div>
		<button type="button" class="btn btn-sm btn-success mt-2" id="add-section">
			+ Sektion hinzufügen
		</button>
	</div>
	<hr class="my-4 border-dark">

	<!-- SEO -->
	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
			SEO-Einstellungen des Artikels
		</h3>
		<small class="text-muted ms-3">
			Geben Sie Keywords und Meta-Titel durch Kommas getrennt ein.
		</small>
	</div>
	<div class="row form-group pb-3">
		<div class="col-md-6">
			<label for="keywords">Schlüsselwörter</label>
			<input type="text" class="form-control" name="keywords"
				   value="<?= $article->keywords ?? '' ?>">
		</div>
		<div class="col-md-6">
			<label for="meta">Meta-Beschreibung</label>
			<input type="text" class="form-control" name="meta"
				   value="<?= $article->meta ?? '' ?>">
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Empfohlene Produkte -->
	<div class="form-group pb-3">
		<h3 class="fw-bold mb-1"
			style="border-left:4px solid #28a745; padding-left:10px;">Sektion Empfohlene Produkte</h3>
		<small class="text-muted ms-3">
			Diese Sektion kann leer bleiben, falls nicht benötigt.
		</small>
		<div class="row mt-2">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4">
					<input type="text" class="form-control mb-1"
						   name="product_name<?= $i ?>"
						   placeholder="Name"
						   value="<?= $article->{'product_name' . $i} ?? '' ?>">
					<textarea class="form-control mb-1"
							  name="product_description<?= $i ?>"
							  rows="2"
							  placeholder="Beschreibung"><?= $article->{'product_description' . $i} ?? '' ?></textarea>
					<input type="file" class="form-control mb-1"
						   name="product_image<?= $i ?>">
					<?php if (!empty($article->{'product_image' . $i})): ?>
						<img src="<?= base_url('Uploads/articles/products/' . $article->{'product_image' . $i}) ?>"
							 class="img-fluid mb-1">
					<?php endif; ?>
					<input type="text" class="form-control"
						   name="product_url<?= $i ?>"
						   placeholder="URL"
						   value="<?= $article->{'product_url' . $i} ?? '' ?>">
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Das könnte Sie interessieren -->
	<div class="form-group pb-3">
		<h3 class="fw-bold mb-1"
			style="border-left:4px solid #28a745; padding-left:10px;">Sektion „Das könnte Sie interessieren“</h3>
		<small class="text-muted ms-3">
			Diese Sektion kann leer bleiben, falls nicht benötigt.
		</small>
		<div class="row mt-2">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4">
					<input type="text" class="form-control mb-1"
						   name="empfohlen_name<?= $i ?>"
						   placeholder="Titel"
						   value="<?= $article->{'empfohlen_name' . $i} ?? '' ?>">
					<input type="text" class="form-control"
						   name="empfohlen_url<?= $i ?>"
						   placeholder="URL"
						   value="<?= $article->{'empfohlen_url' . $i} ?? '' ?>">
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Veröffentlichung -->
	<div class="mb-3">
		<h3 class="fw-bold mb-1"
			style="border-left:4px solid #28a745; padding-left:10px;">Veröffentlichungseinstellungen</h3>
		<small class="text-muted ms-3">
			Legen Sie Start- und Enddatum fest. Aktiv/Inaktiv erfolgt automatisch.
		</small>
	</div>
	<div class="row form-group pb-3">
		<div class="col-md-4">
			<label for="start_date_from">Startdatum</label>
			<input type="date" class="form-control" name="start_date_from"
				   value="<?= $article->start_date_from ?? '' ?>">
		</div>
		<div class="col-md-4">
			<label for="end_date_to">Enddatum</label>
			<input type="date" class="form-control" name="end_date_to"
				   value="<?= $article->end_date_to ?? '' ?>">
		</div>
		<div class="col-md-4">
			<label for="active">Status</label>
			<select name="active" class="form-control">
				<option value="1" <?= (isset($article) && $article->active == '1') ? 'selected' : '' ?>>
					Aktiv
				</option>
				<option value="0" <?= (isset($article) && $article->active == '0') ? 'selected' : '' ?>>
					Inaktiv
				</option>
			</select>
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Submit -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Speichern</button>
		<a href="<?= base_url('admin/articles_in_category/' . $categoryId) ?>"
		   class="btn btn-secondary">Zurück</a>
	</div>
</form>

<script>
	const BASE_URL = "<?= base_url() ?>";
</script>

<!-- Sektionen + Summernote -->
<script>
	let sectionCount = 0,
		maxSections = 6,
		sectionsData = <?= json_encode($sections ?? []) ?>;

	function addSection(content = '', img = null) {
		if (sectionCount >= maxSections) return;
		sectionCount++;
		const html = `
        <div class="row align-items-start border p-2 mb-2" data-section="${sectionCount}">
            <div class="col-md-9">
                <textarea name="sections[]" class="form-control summernote" rows="3">${content}</textarea>
            </div>
            <div class="col-md-3">
                <input type="file" name="section_images[]" class="form-control mb-1">
                ${img ? `<div><img src="${img}" class="img-fluid mb-1"></div>` : ''}
                <button type="button" class="btn btn-sm btn-danger remove-section w-100">– Entfernen</button>
            </div>
        </div>`;
		document.querySelector('#sections-container').insertAdjacentHTML('beforeend', html);
	}

	document.addEventListener('DOMContentLoaded', () => {
		function initSummer() {
			$('.summernote').summernote({ height: 200 });
		}
		document.getElementById('add-section').onclick = () => {
			addSection();
			initSummer();
		};
		document.getElementById('sections-container').onclick = e => {
			if (e.target.classList.contains('remove-section')) {
				e.target.closest('[data-section]').remove();
				sectionCount--;
			}
		};
		sectionsData.forEach(sec => {
			let img = sec.image
				? BASE_URL + 'Uploads/articles/sections/' . sec.image
				: null;
			addSection(sec.content, img);
		});
		initSummer();
	});
</script>
