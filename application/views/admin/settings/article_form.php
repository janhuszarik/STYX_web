<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Určení URL akce a nadpisů
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
			<input type="file" class="form-control mb-1" name="image">
			<input type="hidden" name="old_image" value="<?= $article->image ?? '' ?>">
			<input type="hidden" name="ftp_image" id="ftp_image" value="<?= htmlspecialchars($article->ftp_image ?? '') ?>">
			<button type="button"
					class="btn btn-outline-secondary btn-sm ftp-picker mb-1"
					data-ftp-target="ftp_image"
					data-preview-target="ftpImagePreview">
				Bild aus FTP wählen
			</button>
			<div id="ftpImagePreview" class="mb-2">
				<?php if (!empty($article->ftp_image)): ?>
					<img src="<?= htmlspecialchars($article->ftp_image) ?>" style="max-width:150px;max-height:150px;object-fit:contain;">
				<?php endif; ?>
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
					<img src="<?= base_url('uploads/articles/' . $article->image) ?>" class="img-fluid">
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
				   value="<?= htmlspecialchars($article->keywords ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label for="meta">Meta-Beschreibung</label>
			<input type="text" class="form-control" name="meta"
				   value="<?= htmlspecialchars($article->meta ?? '') ?>">
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Empfohlene Produkte -->
	<div class="form-group pb-3">
		<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
			Sektion Empfohlene Produkte
		</h3>
		<small class="text-muted ms-3">
			Diese Sektion kann leer bleiben, falls nicht benötigt.
		</small>
		<div class="row mt-2">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4 mb-3">
					<input type="text" class="form-control mb-1"
						   name="product_name<?= $i ?>"
						   placeholder="Name"
						   value="<?= htmlspecialchars($article->{'product_name' . $i} ?? '') ?>">
					<textarea class="form-control mb-1"
							  name="product_description<?= $i ?>"
							  rows="2"
							  placeholder="Beschreibung"><?= htmlspecialchars($article->{'product_description' . $i} ?? '') ?></textarea>
					<input type="file" class="form-control mb-1"
						   name="product_image<?= $i ?>">
					<input type="hidden" name="ftp_product_image<?= $i ?>"
						   id="ftp_product_image<?= $i ?>"
						   value="<?= htmlspecialchars($article->{'ftp_product_image' . $i} ?? '') ?>">
					<button type="button"
							class="btn btn-outline-secondary btn-sm ftp-picker mb-1"
							data-ftp-target="ftp_product_image<?= $i ?>"
							data-preview-target="productImagePreview<?= $i ?>">
						Bild aus FTP wählen
					</button>
					<div id="productImagePreview<?= $i ?>" class="mb-2">
						<?php if (!empty($article->{'ftp_product_image' . $i})): ?>
							<img src="<?= htmlspecialchars($article->{'ftp_product_image' . $i}) ?>" style="max-width:150px;max-height:150px;object-fit:contain;">
						<?php endif; ?>
					</div>
					<input type="text" class="form-control"
						   name="product_url<?= $i ?>"
						   placeholder="URL"
						   value="<?= htmlspecialchars($article->{'product_url' . $i} ?? '') ?>">
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Das könnte Sie interessieren -->
	<div class="form-group pb-3">
		<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
			Sektion „Das könnte Sie interessieren“
		</h3>
		<small class="text-muted ms-3">
			Diese Sektion kann leer bleiben, falls nicht benötigt.
		</small>
		<div class="row mt-2">
			<?php for ($i = 1; $i <= 3; $i++): ?>
				<div class="col-md-4 mb-3">
					<input type="text" class="form-control mb-1"
						   name="empfohlen_name<?= $i ?>"
						   placeholder="Titel"
						   value="<?= htmlspecialchars($article->{'empfohlen_name' . $i} ?? '') ?>">
					<input type="text" class="form-control"
						   name="empfohlen_url<?= $i ?>"
						   placeholder="URL"
						   value="<?= htmlspecialchars($article->{'empfohlen_url' . $i} ?? '') ?>">
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<hr class="my-4 border-dark">

	<!-- Veröffentlichung -->
	<div class="mb-3">
		<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
			Veröffentlichungseinstellungen
		</h3>
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
				<option value="1" <?= (isset($article) && $article->active == '1') ? 'selected' : '' ?>>Aktiv</option>
				<option value="0" <?= (isset($article) && $article->active == '0') ? 'selected' : '' ?>>Inaktiv</option>
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

<script>const BASE_URL = "<?= base_url() ?>";</script>
<!-- Dynamické sekce + Summernote -->
<script>
	let sectionCount = 0, maxSections = 6, sectionsData = <?= json_encode($sections ?? []) ?>;

	function addSection(content = '', img = null, ftpImage = '') {
		if (sectionCount >= maxSections) return;
		sectionCount++;
		const id = sectionCount;
		const html = `
    <div class="row align-items-start border p-2 mb-2" data-section="${id}">
      <div class="col-md-9">
        <textarea name="sections[]" class="form-control summernote" rows="3">${content}</textarea>
      </div>
      <div class="col-md-3">
        <input type="file" name="section_images[]" class="form-control mb-1">
        <input type="hidden" name="ftp_section_image[]" id="ftp_section_image${id}" value="${ftpImage}">
        <button type="button" class="btn btn-outline-secondary btn-sm ftp-picker mb-1"
                data-ftp-target="ftp_section_image${id}"
                data-preview-target="sectionImagePreview${id}">
          Bild aus FTP wählen
        </button>
        <div id="sectionImagePreview${id}" class="mb-2">
          ${ftpImage ? `<img src="${ftpImage}" style="max-width:150px;max-height:150px;object-fit:contain;">` : ''}
          ${img ? `<img src="${img}" style="max-width:150px;max-height:150px;object-fit:contain;">` : ''}
        </div>
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
			const img = sec.image ? BASE_URL + 'uploads/articles/sections/' + sec.image : null;
			const ftpImage = sec.ftp_image || ''; // Predpokladáme, že sekcie majú pole ftp_image
			addSection(sec.content, img, ftpImage);
		});
		initSummer();
	});
</script>

<!-- FTP–Picker (statické i dynamické) -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const modalEl = document.getElementById('ftpModal'),
			modal = new bootstrap.Modal(modalEl),
			tableBody = document.getElementById('ftp-table-body'),
			currentFolder = document.getElementById('current-folder'),
			backBtn = document.getElementById('ftp-back-btn');
		let lastTarget = '', lastPreview = '', currentPath = '';

		function loadFolder(path = '') {
			currentPath = path;
			currentFolder.textContent = '/' + path;
			backBtn.style.display = path ? 'inline-block' : 'none';
			fetch(BASE_URL + 'admin/ftpmanager/load_folder', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams({ folder: path })
			})
				.then(r => r.json())
				.then(data => {
					if (data.error) {
						tableBody.innerHTML = `<tr><td colspan="5">${data.error}</td></tr>`;
						return;
					}
					let html = '';
					data.forEach(item => {
						let icon = item.type === 'dir'
							? '<i class="bi bi-folder-fill text-warning"></i>'
							: /\.(jpe?g|png|gif|webp)$/i.test(item.name)
								? `<img src="${item.url}" style="width:60px;height:60px;object-fit:cover">`
								: '<i class="bi bi-file-earmark-fill text-primary"></i>';
						const size = item.size > 0 ? (item.size / 1024).toFixed(1) + ' KB' : '-';
						const action = item.type === 'dir'
							? `<a href="#" class="ftp-folder" data-path="${item.path}">Öffnen</a>`
							: /\.(jpe?g|png|gif|webp)$/i.test(item.name)
								? `<a href="#" class="ftp-image-choose" data-path="${item.url}">Auswählen</a>`
								: '-';
						html += `<tr>
                    <td class="text-center">${icon}</td>
                    <td>${item.name}</td>
                    <td>${item.path}</td>
                    <td>${size}</td>
                    <td>${action}</td>
                </tr>`;
					});
					tableBody.innerHTML = html || '<tr><td colspan="5">Ordner ist leer.</td></tr>';
					tableBody.querySelectorAll('.ftp-folder').forEach(a => {
						a.onclick = e => { e.preventDefault(); loadFolder(a.dataset.path); };
					});
					tableBody.querySelectorAll('.ftp-image-choose').forEach(a => {
						a.onclick = e => {
							e.preventDefault();
							const targetInput = document.getElementById(lastTarget);
							const previewDiv = document.getElementById(lastPreview);
							targetInput.value = a.dataset.path;
							previewDiv.innerHTML = `<img src="${a.dataset.path}" style="max-width:150px;max-height:150px;object-fit:contain;">`;
							modal.hide();
						};
					});
				})
				.catch(err => {
					tableBody.innerHTML = `<tr><td colspan="5">Fehler: ${err.message}</td></tr>`;
				});
		}

		document.body.addEventListener('click', function (e) {
			if (!e.target.matches('.ftp-picker')) return;
			lastTarget = e.target.dataset.ftpTarget;
			lastPreview = e.target.dataset.previewTarget;
			modal.show();
			loadFolder(currentPath);
		});

		backBtn.onclick = () => {
			const parent = currentPath.includes('/')
				? currentPath.substring(0, currentPath.lastIndexOf('/'))
				: '';
			loadFolder(parent);
		};
	});
</script>
