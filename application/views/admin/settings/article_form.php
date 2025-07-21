<?php
$CI =& get_instance();

$actionUrl = isset($article)
	? 'admin/article_save/edit/' . $article->id
	: 'admin/article_save';

$titleHeadline = isset($article)
	? 'Artikel bearbeiten: ' . htmlspecialchars($article->title ?? '')
	: 'Neuen Artikel erstellen';

$titleSub = isset($article)
	? 'Bestehenden Artikel nach Bedarf anpassen.'
	: 'Neuen Artikel nach Bedarf erstellen.';

$categoryId = isset($article) ? $article->category_id : ($categoryId ?? $CI->uri->segment(3));

$CI->load->helper('app_helper');

$CI->load->model('Article_model');
$articles = $CI->Article_model->getAllArticlesExcept($article->id ?? null);
$articleOptions = [];
foreach ($articles as $art) {
	$articleOptions[] = [
		'value' => $art->id,
		'label' => $art->title,
		'slug' => $art->slug,
		'lang' => $art->lang
	];
}
$articleOptionsJson = json_encode($articleOptions);

$defaultMenuUrl = '';
if (isset($article) && !empty($article->slug)) {
	$defaultMenuUrl = $article->slug;
} elseif ($categoryId) {
	$category = $CI->db->get_where('article_categories', ['id' => $categoryId])->row();
	if ($category && (!empty($category->menu_id) || !empty($category->submenu_id))) {
		$menuId = $category->menu_id ?: $category->submenu_id;
		$menu = $CI->db->get_where('menu', ['id' => $menuId])->row();
		if ($menu && !empty($menu->url)) {
			$defaultMenuUrl = $menu->url;
		}
	}
}

$subcategories = [];
if (in_array($categoryId, [100, 102])) {
	$subcategories = $CI->Article_model->getSubcategoriesByCategory($categoryId);
}

$startDate = $endDate = $startTime = $endTime = '';
if (isset($article->start_date_from) && !empty($article->start_date_from)) {
	$startDateTime = new DateTime($article->start_date_from);
	$startDate = $startDateTime->format('Y-m-d');
	$startTime = $startDateTime->format('H:i');
}
if (isset($article->end_date_to) && !empty($article->end_date_to)) {
	$endDateTime = new DateTime($article->end_date_to);
	$endDate = $endDateTime->format('Y-m-d');
	$endTime = $endDateTime->format('H:i');
}
?>

<style>
	.current-image { max-width: 40%; height: auto; }
	.section-actions { display: flex; justify-content: flex-end; margin-top: 10px; }
	.form-group .col-form-label { font-weight: 500; margin-bottom: 0.25rem; }
	.form-group .form-control { margin-bottom: 0.5rem; }
	.file-info {
		font-size: 0.9rem;
	}
	.file-info p {
		margin: 0.25rem 0;
	}
	.file-info .text-warning {
		color: #b80000;
		font-weight: 500;
	}
	.file-info .text-danger {
		color: #d60015;
		font-weight: 500;
	}
	.subcategory-modal-table th, .subcategory-modal-table td {
		padding: 8px;
		vertical-align: middle;
	}
	.subcategory-modal-table {
		width: 100%;
		margin-top: 10px;
	}
	.input-group .btn {
		height: 38px;
		padding: 6px 12px;
		margin-left: -1px;
	}
	.time-select {
		display: flex;
		gap: 10px;
	}
	.product-image-preview {
		max-width: 150px;
		max-height: 150px;
		object-fit: contain;
	}
</style>

<div id="global-status"
	 style="
        position: fixed;
        top: 15px;
        right: 18px;
        z-index: 2100;
        min-width: 800px;
        max-width: 1200px;
        font-size: 15px;
        padding: 12px 18px 10px 18px;
        color: #fff;
        border: none;
        display: none;
        pointer-events: none;
        background: #28a745;
     ">
	<span id="global-status-text"></span>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= $titleHeadline ?></h2>
				<p class="card-subtitle"><?= $titleSub ?></p>
			</header>
			<div class="card-body">
				<form method="post" action="<?= base_url($actionUrl) ?>" enctype="multipart/form-data" id="articleForm">
					<input type="hidden" name="id" value="<?= htmlspecialchars($article->id ?? '') ?>">
					<input type="hidden" name="category_id" value="<?= htmlspecialchars($categoryId) ?>">

					<div class="section-heading mb-3">
						<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
							Allgemeine Titel und Benennungen
						</h3>
						<small class="text-muted ms-3">
							Grundlegende Überschriften und Bezeichnungen für den Artikel
						</small>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-2">
							<label for="lang" class="col-form-label">Sprache</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wählen Sie die Sprache des Artikels aus. Dies bestimmt, in welcher Sprache der Artikel angezeigt wird."></i>
							<select name="lang" id="lang" class="form-control" required>
								<option value="de" <?= (isset($article) && $article->lang == 'de') ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= (isset($article) && $article->lang == 'en') ? 'selected' : '' ?>>Englisch</option>
							</select>
						</div>
						<div class="col-md-5">
							<label for="title" class="col-form-label">Titel</label>
							<input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($article->title ?? '') ?>" required data-label="Titel">
						</div>
						<div class="col-md-5">
							<label for="subtitle" class="col-form-label">Untertitel</label>
							<input type="text" class="form-control" name="subtitle" id="subtitle" value="<?= htmlspecialchars($article->subtitle ?? '') ?>" data-label="Untertitel">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-3">
							<label for="category_name" class="col-form-label">Kategorie</label>
							<input type="text" class="form-control" id="category_name" name="category_name" value="<?= htmlspecialchars($categoryName) ?>" readonly>
						</div>
						<div class="col-md-3">
							<label for="slug_display" class="col-form-label">URL-Adresse
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL-Adresse wird automatisch generiert und setzt sich aus der gewählten Sprache, dem Hauptmenüpunkt und dem letzten Menüpunkt zusammen, unter dem dieser Artikel gespeichen wird."></i>
							</label>
							<input type="text" class="form-control" id="slug_display" name="slug_display" value="https://www.styx.at/<?= htmlspecialchars($article->slug ?? $defaultMenuUrl) ?>" readonly>
							<input type="hidden" name="slug" id="slug" value="<?= htmlspecialchars($article->slug ?? $defaultMenuUrl) ?>">
						</div>
						<?php if (in_array($categoryId, [100, 102])): ?>
							<div class="col-md-3">
								<label for="subcategory_id" class="col-form-label">Unterkategorie (nur bei Tipps & Neuigkeiten)
									<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wählen Sie eine Unterkategorie für den Artikel aus oder erstellen Sie eine neue. Dies ermöglicht eine detaillierte Filterung der Artikel, z. B. nach Themen wie ‚Schokolade‘."></i>
								</label>
								<div class="input-group">
									<select name="subcategory_id" id="subcategory_id" class="form-control">
										<option value="">-- Unterkategorie auswählen --</option>
										<option value="new">+ Neue Unterkategorie erstellen</option>
										<?php foreach ($subcategories as $sub): ?>
											<option value="<?= htmlspecialchars($sub->id) ?>" <?= isset($article->subcategory_id) && $article->subcategory_id == $sub->id ? 'selected' : '' ?>>
												<?= htmlspecialchars($sub->name) ?>
											</option>
										<?php endforeach; ?>
									</select>
									<button type="button" class="btn btn-outline-primary" id="manageSubcategoriesBtn" data-bs-toggle="modal" data-bs-target="#subcategoryModal">
										<i class="fas fa-cog"></i> Verwalten
									</button>
								</div>
							</div>
						<?php endif; ?>
						<div class="col-md-3">
							<label for="is_main" class="col-form-label">Hauptartikel
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Dieser Abschnitt legt fest, ob dieser Artikel als Hauptartikel bestimmt ist oder ob er zur Artikelliste gehören soll, in der die Artikel den Benutzern als Liste angezeigt werden. Wenn „Ja“ gewählt ist, handelt es sich um einen eigenständigen / einzigen Artikel in dieser Kategorie."></i>
							</label>
							<select name="is_main" id="is_main" class="form-control">
								<option value="1" <?= (isset($article) && $article->is_main == '1') ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= (isset($article) && $article->is_main == '0') || !isset($article) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-md-8">
							<label for="image" class="col-form-label">Hauptbild hochladen</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht das Hochladen eines Hauptbildes für den Artikel. Das Bild wird in der Artikelansicht angezeigt. Unterstützte Formate: JPG, PNG, GIF, WEBP."></i>
							<input type="file" class="form-control mb-1" name="image" id="image">
							<label for="image_title" class="col-form-label">Titel des Bildes (SEO) <span class="text-danger">*</span></label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der SEO-Titel des Hauptbildes. Wird als Alt-Text verwendet, um die Suchmaschinenoptimierung zu verbessern. Pflichtfeld für neue Bilder."></i>
							<input type="text" class="form-control mb-1" name="image_title" id="image_title" placeholder="Titel des Bildes (SEO)" value="<?= htmlspecialchars($article->image_title ?? '') ?>" data-label="Bildtitel (SEO)">
							<input type="hidden" name="old_image" value="<?= htmlspecialchars($article->image ?? '') ?>">
							<input type="hidden" name="ftp_image" id="ftp_image" value="<?= htmlspecialchars($article->ftp_image ?? '') ?>">
							<button type="button" class="btn btn-outline-secondary btn-sm ftp-picker mb-1" data-ftp-target="ftp_image" data-preview-target="ftpImagePreview">
								Bild aus FTP wählen
							</button>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht die Auswahl eines Bildes aus einem FTP-Verzeichnis. Das ausgewählte Bild wird als Hauptbild des Artikels gespeichen."></i>
							<div id="ftpImagePreview" class="mb-2">
								<?php if (!empty($article->ftp_image)): ?>
									<img src="<?= htmlspecialchars($article->ftp_image) ?>" style="max-width:150px;max-height:150px;object-fit:contain;">
								<?php endif; ?>
							</div>
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
								<label class="col-form-label">Aktuelles Bild (Upload)</label>
								<div>
									<img src="<?= base_url(htmlspecialchars($article->image)) ?>" class="img-fluid current-image">
								</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="form-group pb-3">
						<div class="section-heading mb-3">
							<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
								Inhaltsbereich
							</h3>
							<small class="text-muted ms-3">
								Durch das Ausfüllen der Angaben in diesem Bereich wird ein Abschnitt als ‚SEKTION‘ zum Beitrag hinzugefügt.
							</small>
						</div>
						<div id="sections-container" style="margin-top:20px;"></div>
						<button type="button" class="btn btn-sm btn-success mt-2" id="add-section">+ Sektion hinzufügen</button>
					</div>

					<hr class="my-4 border-dark">

					<div class="form-group pb-3">
						<?php $this->load->view('admin/settings/article_products_dynamic', ['article' => $article]); ?>
					</div>
					<hr class="my-4 border-dark">

					<div class="mb-3">
						<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
							SEO-Einstellungen des Artikels
						</h3>
						<small class="text-muted ms-3">Geben Sie Keywords und Meta-Titel durch Kommas getrennt ein.</small>
					</div>
					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="keywords" class="col-form-label">Schlüsselwörter</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Durch Kommas getrennte Schlüsselwörter für die SEO des Artikels. Diese verbessern die Auffindbarkeit in Suchmaschinen."></i>
							<input type="text" class="form-control" name="keywords" id="keywords" value="<?= htmlspecialchars($article->keywords ?? '') ?>" data-label="Schlüsselwörter">
						</div>
						<div class="col-md-6">
							<label for="meta" class="col-form-label">Meta-Beschreibung</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Eine kurze Beschreibung des Artikels für Suchmaschinen. Wird in den Suchergebnissen angezeigt und sollte 50-160 Zeichen lang sein."></i>
							<textarea class="form-control" name="meta" id="meta" rows="3" data-label="Meta-Beschreibung"><?= htmlspecialchars($article->meta ?? '') ?></textarea>
						</div>
					</div>
					<hr class="my-4 border-dark">

					<div class="form-group pb-3">
						<div class="section-heading mb-3">
							<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
								Sektion „Das könnte Sie interessieren“
							</h3>
							<small class="text-muted ms-3">
								Diese Sektion kann leer bleiben, falls nicht benötigt.
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Abschnitt, in dem Verlinkungen zu verwandten Artikeln oder Unterseiten angezeigt werden sollen, die inhaltlich an den aktuellen Artikel anknüpfen."></i>
							</small>
						</div>
						<div class="row mt-2">
							<?php for ($i = 1; $i <= 3; $i++): ?>
								<div class="col-md-4 mb-3">
									<div class="mb-2">
										<label for="empfohlen_name<?= $i ?>" class="col-form-label">Titel</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Titel des empfohlenen Artikels oder der Unterseite in der Sektion ‚Das könnte Sie interessieren‘. Kann leer bleiben, wenn nicht benötigt."></i>
										<input type="text" class="form-control" id="empfohlen_name<?= $i ?>" name="empfohlen_name<?= $i ?>" placeholder="Titel" value="<?= htmlspecialchars($article->{'empfohlen_name' . $i} ?? '') ?>" data-label="Das könnte Sie interessieren - Titel <?= $i ?>">
									</div>
									<div class="mb-2">
										<label for="empfohlen_url<?= $i ?>" class="col-form-label">URL</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL des empfohlenen Artikels oder der Unterseite. Kann eine interne oder externe Seite sein. Kann leer bleiben, wenn nicht benötigt."></i>
										<input type="text" class="form-control" id="empfohlen_url<?= $i ?>" name="empfohlen_url<?= $i ?>" placeholder="URL" value="<?= htmlspecialchars($article->{'empfohlen_url' . $i} ?? '') ?>" data-label="Das könnte Sie interessieren - URL <?= $i ?>">
									</div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
					<hr class="my-4 border-dark">

					<div class="mb-3">
						<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
							Verknüpfte Galerie
						</h3>
						<small class="text-muted ms-3">Wählen Sie eine Galerie aus, die mit diesem Artikel verknüpft werden soll.</small>
					</div>
					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="gallery_category_id" class="col-form-label">Galerie-Kategorie</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wählt die Kategorie der Galerie aus, aus der Bilder für den Artikel ausgewählt werden sollen. Bestimmt die verfügbaren Galerien im nächsten Feld."></i>
							<select name="gallery_category_id" id="gallery_category_id" class="form-control">
								<option value="">-- Kategorie auswählen --</option>
								<?php foreach ($galleryCategories as $cat): ?>
									<option value="<?= htmlspecialchars($cat->id) ?>" <?= isset($article->gallery_id) && $galleryCategoryId == $cat->id ? 'selected' : '' ?>>
										<?= htmlspecialchars($cat->name) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-6">
							<label for="gallery_id" class="col-form-label">Galerie</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wählt eine konkrete Galerie aus, die diesem Artikel zugewiesen wird. Nur eine Galerie pro Artikel möglich. Für Bilder aus verschiedenen Kategorien muss eine neue Galerie erstellt werden, die alle benötigten Bilder enthält."></i>
							<select name="gallery_id" id="gallery_id" class="form-control">
								<option value="">-- Zuerst Kategorie auswählen --</option>
								<?php if (isset($article->gallery_id) && !empty($selectedGalleries)) { ?>
									<?php foreach ($selectedGalleries as $gal) { ?>
										<option value="<?= htmlspecialchars($gal->id) ?>" <?= $article->gallery_id == $gal->id ? 'selected' : '' ?>>
											<?= htmlspecialchars($gal->name) ?>
										</option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<hr class="my-4 border-dark">

					<div class="mb-3">
						<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
							Veröffentlichungseinstellungen
						</h3>
						<small class="text-muted ms-3">Legen Sie Start- und Enddatum sowie Uhrzeit fest. Aktiv/Inaktiv erfolgt automatisch.</small>
					</div>
					<div class="row form-group pb-3">
						<div class="col-md-3">
							<label for="start_date_from" class="col-form-label">Startdatum</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Legt das Startdatum und die Uhrzeit des Artikels fest. Der Artikel wird ab diesem Zeitpunkt angezeigt, wenn er aktiv ist."></i>
							<input type="date" class="form-control mb-1" name="start_date_from_date" id="start_date_from_date" value="<?= htmlspecialchars($startDate) ?>">
							<div class="time-select">
								<select name="start_date_from_time" id="start_date_from_time" class="form-control">
									<option value="">-- Uhrzeit auswählen --</option>
									<?php
									$times = ['00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'];
									foreach ($times as $time) {
										$selected = ($startTime === $time) ? 'selected' : '';
										echo "<option value=\"$time\" $selected>$time</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<label for="end_date_to" class="col-form-label">Enddatum</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Legt das Enddatum und die Uhrzeit des Artikels fest. Der Artikel wird nach diesem Zeitpunkt nicht mehr angezeigt, wenn er aktiv ist. Ohne Enddatum bleibt der Artikel dauerhaft aktiv."></i>
							<input type="date" class="form-control mb-1" name="end_date_to_date" id="end_date_to_date" value="<?= htmlspecialchars($endDate) ?>">
							<div class="time-select">
								<select name="end_date_to_time" id="end_date_to_time" class="form-control">
									<option value="">-- Uhrzeit auswählen --</option>
									<?php
									foreach ($times as $time) {
										$selected = ($endTime === $time) ? 'selected' : '';
										echo "<option value=\"$time\" $selected>$time</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<label for="created_at" class="col-form-label">Erstellungsdatum</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Bestimmt die Reihenfolge, in der der Artikel in der Liste der Artikel in der Kategorie angezeigt wird. Neuere Daten erscheinen weiter oben. Wenn nicht angegeben, wird das heutige Datum verwendet."></i>
							<input type="date" class="form-control" name="created_at" id="created_at" value="<?= htmlspecialchars(isset($article->created_at) ? date('Y-m-d', strtotime($article->created_at)) : '') ?>">
						</div>
						<div class="col-md-3">
							<label for="active" class="col-form-label">Status</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Legt fest, ob der Artikel aktiv ist. Wenn ‚Inaktiv‘, wird der Artikel nicht angezeigt, unabhängig von Datum und Uhrzeit."></i>
							<select name="active" id="active" class="form-control">
								<option value="1" <?= (isset($article) && $article->active == '1') ? 'selected' : '' ?>>Aktiv</option>
								<option value="0" <?= (isset($article) && $article->active == '0') || !isset($article) ? 'selected' : '' ?>>Inaktiv</option>
							</select>
						</div>
					</div>

					<div class="form-group mt-4">
						<button type="submit" class="btn btn-primary">Speichern</button>
						<a href="<?= base_url('admin/articles_in_category/' . $categoryId) ?>" class="btn btn-secondary">Zurück</a>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>

<div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="subcategoryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="subcategoryModalLabel">Unterkategorien verwalten</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="subcategoryForm">
					<input type="hidden" name="category_id" value="<?= htmlspecialchars($categoryId) ?>">
					<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
					<input type="hidden" name="id" id="subcategory_id">
					<div class="mb-3">
						<label for="subcategory_name" class="form-label">Name der Unterkategorie</label>
						<input type="text" class="form-control" id="subcategory_name" name="name" required>
					</div>
					<div class="mb-3">
						<label for="subcategory_lang" class="form-label">Sprache</label>
						<select class="form-control" id="subcategory_lang" name="lang">
							<option value="de">Deutsch</option>
							<option value="en">Englisch</option>
						</select>
					</div>
					<div class="mb-3">
						<label class="form-label">Status</label>
						<div>
							<input type="checkbox" id="subcategory_active" name="active" value="1" checked>
							<label for="subcategory_active">Aktiv</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Speichern</button>
				</form>
				<hr>
				<h6>Bestehende Unterkategorien</h6>
				<table class="table subcategory-modal-table">
					<thead>
					<tr>
						<th>Name</th>
						<th>Slug</th>
						<th>Sprache</th>
						<th>Status</th>
						<th>Aktionen</th>
					</tr>
					</thead>
					<tbody id="subcategoryTableBody"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
			</div>
		</div>
	</div>
</div>
<script>
	const base_url = "<?= base_url() ?>";
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		const articleOptions = <?= $articleOptionsJson ?>;
		const langSelect = document.getElementById('lang');
		const titleInput = document.getElementById('title');
		const slugInput = document.getElementById('slug');
		const slugDisplay = document.getElementById('slug_display');
		const isMainSelect = document.getElementById('is_main');
		const subcategorySelect = document.getElementById('subcategory_id');
		const manageSubcategoriesBtn = document.getElementById('manageSubcategoriesBtn');
		const subcategoryForm = document.getElementById('subcategoryForm');
		const subcategoryTableBody = document.getElementById('subcategoryTableBody');
		const categoryId = '<?= htmlspecialchars($categoryId) ?>';
		const allowedCategoryIds = ['100', '102'];

		let inputStates = {};
		let wasProblematic = false;
		let successTimer;

		function showAlert(message, type = 'success') {
			const alertDiv = document.createElement('div');
			alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
			alertDiv.style.zIndex = '1050';
			alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
			document.body.appendChild(alertDiv);
			setTimeout(() => alertDiv.remove(), 3000);
		}

		function showWarning(element, message) {
			let warning = element.parentElement.querySelector('.text-danger');
			if (!warning) {
				warning = document.createElement('p');
				warning.className = 'text-danger file-info';
				element.parentElement.appendChild(warning);
			}
			warning.textContent = message;
		}

		function hideWarning(element) {
			const warning = element.parentElement.querySelector('.text-danger');
			if (warning) warning.remove();
		}

		function getImageUploadPath() {
			const categoryId = '<?= htmlspecialchars($categoryId) ?>';
			const subcategoryId = document.getElementById('subcategory_id')?.value || '';
			const title = document.getElementById('title')?.value || 'article';

			let baseDir = '';
			let suffix = '';

			if (categoryId == '100') {
				baseDir = 'uploads/neuigkeiten/';
				suffix = '_neuigkeiten';
			} else if (categoryId == '102') {
				baseDir = 'uploads/tipps/';
				suffix = '_tipps';
			} else if (categoryId == '104') {
				baseDir = 'uploads/Jobs/';
				suffix = '_Jobs';
			} else {
				baseDir = 'uploads/neuigkeiten/';
			}

			if (subcategoryId && subcategoryId !== 'new' && (categoryId == '100' || categoryId == '102')) {
				const subcategoryName = document.querySelector(`#subcategory_id option[value="${subcategoryId}"]`)?.text || '';
				if (subcategoryName) {
					baseDir += urlOprava(subcategoryName) + '/';
				}
			}

			return {
				baseDir,
				suffix,
				title: urlOprava(title)
			};
		}


		function urlOprava(str) {
			return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
		}

		document.getElementById('articleForm').addEventListener('submit', function (e) {
			const startDate = document.getElementById('start_date_from_date').value;
			const startTime = document.getElementById('start_date_from_time').value;
			const endDate = document.getElementById('end_date_to_date').value;
			const endTime = document.getElementById('end_date_to_time').value;
			const imageInput = document.getElementById('image');
			const imageTitle = document.getElementById('image_title').value.trim();
			const sectionImageInputs = document.querySelectorAll('input[name^="section_images"]');
			const sectionImageTitles = document.querySelectorAll('input[name^="section_image_titles"]');
			const productImageInputs = document.querySelectorAll('input[name^="product_image"]');
			const productImageTitles = document.querySelectorAll('input[name^="product_image_title"]');

			if (imageInput.files.length > 0 && !imageTitle) {
				const title = document.getElementById('title')?.value.trim();
				if (title) {
					document.getElementById('image_title').value = title;
					hideWarning(document.getElementById('image_title'));
				} else {
					e.preventDefault();
					showAlert('Bitte geben Sie einen Bildtitel (SEO) ein oder füllen Sie den Titel des Artikels aus.', 'error');
					return;
				}
			}


			for (let i = 0; i < sectionImageInputs.length; i++) {
				if (sectionImageInputs[i].files.length > 0 && !sectionImageTitles[i].value.trim()) {
					e.preventDefault();
					showAlert(`Bitte geben Sie einen Bildtitel (SEO) für die Sektion ${i + 1} ein.`, 'error');
					return;
				}
			}

			for (let i = 0; i < productImageInputs.length; i++) {
				if (productImageInputs[i].files.length > 0 && !productImageTitles[i].value.trim()) {
					e.preventDefault();
					showAlert(`Bitte geben Sie einen Bildtitel (SEO) für Produktbild ${i + 1} ein.`, 'error');
					return;
				}
			}

			if (startDate && !startTime) {
				e.preventDefault();
				showAlert('Bitte wählen Sie eine Startzeit aus, wenn ein Startdatum angegeben ist.', 'error');
				return;
			}
			if (endDate && !endTime) {
				e.preventDefault();
				showAlert('Bitte wählen Sie eine Endzeit aus, wenn ein Enddatum angegeben ist.', 'error');
				return;
			}
			if (startDate && endDate) {
				const startDateTime = new Date(startDate + 'T' + (startTime || '00:00'));
				const endDateTime = new Date(endDate + 'T' + (endTime || '00:00'));
				if (endDateTime <= startDateTime) {
					e.preventDefault();
					showAlert('Das Enddatum und die Endzeit müssen nach dem Startdatum und der Startzeit liegen.', 'error');
					return;
				}
			}
			// const warnings = document.querySelectorAll('.text-danger');
			// if (warnings.length > 0) {
			// 	e.preventDefault();
			// 	showAlert('Das Formular enthält ungültigen Text oder Dateien! Korrigieren Sie sie vor dem Speichern.', 'error');
			// }
		});

		if (allowedCategoryIds.includes(categoryId)) {
			function loadSubcategories() {
				fetch('<?= base_url('admin/article/getSubcategories') ?>', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
					body: 'category_id=' + encodeURIComponent(categoryId)
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) { subcategorySelect.innerHTML = data.options; }
						else { showAlert(data.message || 'Fehler beim Laden der Unterkategorien.', 'error'); }
					})
					.catch(error => showAlert('Fehler beim Laden der Unterkategorien.', 'error'));
			}

			function loadSubcategoriesForManagement() {
				fetch('<?= base_url('admin/article/getSubcategoriesForManagement') ?>', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
					body: 'category_id=' + encodeURIComponent(categoryId) + '&<?= $this->security->get_csrf_token_name() ?>=' + '<?= $this->security->get_csrf_hash() ?>'
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							subcategoryTableBody.innerHTML = data.html;
							bindSubcategoryActions();
						} else {
							subcategoryTableBody.innerHTML = '<tr><td colspan="5">Fehler beim Laden der Unterkategorien.</td></tr>';
							showAlert(data.message || 'Fehler beim Laden der Unterkategorien.', 'error');
						}
					})
					.catch(error => {
						subcategoryTableBody.innerHTML = '<tr><td colspan="5">Fehler beim Laden der Unterkategorien.</td></tr>';
						showAlert('Fehler beim Laden der Unterkategorien.', 'error');
					});
			}

			function resetSubcategoryForm() {
				subcategoryForm.reset();
				document.getElementById('subcategory_id').value = '';
				document.getElementById('subcategory_name').value = '';
				document.getElementById('subcategory_lang').value = 'de';
				document.getElementById('subcategory_active').checked = true;
				subcategoryForm.removeAttribute('data-submitting');
			}

			const subcategoryModal = document.getElementById('subcategoryModal');
			subcategoryModal.addEventListener('hidden.bs.modal', function () { resetSubcategoryForm(); });

			subcategoryForm.addEventListener('submit', function (e) {
				e.preventDefault();
				if (this.dataset.submitting) return;
				this.dataset.submitting = true;
				const formData = new FormData(this);
				const data = new URLSearchParams();
				for (let [key, value] of formData.entries()) { data.append(key, value); }
				data.append('category_id', categoryId);
				data.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
				fetch('<?= base_url('admin/article/manageSubcategory') ?>', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
					body: data
				})
					.then(response => { if (!response.ok) { throw new Error('Network response was not ok'); } return response.json(); })
					.then(data => {
						this.dataset.submitting = false;
						if (data.success) {
							showAlert(data.message || 'Unterkategorie erfolgreich gespeichert.', 'success');
							const modalEl = document.getElementById('subcategoryModal');
							const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
							modalInstance.hide();
							loadSubcategories();
							loadSubcategoriesForManagement();
							if (data.subcategory && data.subcategory.id) {
								setTimeout(() => { subcategorySelect.value = data.subcategory.id; }, 150);
							}
							resetSubcategoryForm();
						} else { showAlert(data.message || 'Fehler beim Speichern der Unterkategorie.', 'error'); }
					})
					.catch(error => { this.dataset.submitting = false; showAlert('Fehler beim Speichern der Unterkategorie: ' + error.message, 'error'); });
			});

			function bindSubcategoryActions() {
				document.querySelectorAll('.edit-subcategory').forEach(button => {
					button.addEventListener('click', function () {
						const id = this.getAttribute('data-id');
						const name = this.getAttribute('data-name');
						const lang = this.closest('tr').querySelector('select[name^="lang_"]').value;
						const active = this.closest('tr').querySelector('input[name^="active_"]').checked;
						subcategoryForm.querySelector('input[name="id"]').value = id;
						document.getElementById('subcategory_name').value = name;
						document.getElementById('subcategory_lang').value = lang;
						document.getElementById('subcategory_active').checked = active;
					});
				});
				document.querySelectorAll('.delete-subcategory').forEach(button => {
					button.addEventListener('click', function () {
						if (!confirm('Sind Sie sicher, dass Sie diese Unterkategorie löschen möchten?')) return;
						const id = this.getAttribute('data-id');
						fetch('<?= base_url('admin/article/deleteSubcategory') ?>', {
							method: 'POST',
							headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
							body: 'id=' + encodeURIComponent(id) + '&category_id=' + encodeURIComponent(categoryId) + '&<?= $this->security->get_csrf_token_name() ?>=' + '<?= $this->security->get_csrf_hash() ?>'
						})
							.then(response => { if (!response.ok) { throw new Error('Network response was not ok'); } return response.json(); })
							.then(data => {
								if (data.success) {
									showAlert(data.message || 'Unterkategorie erfolgreich gelöscht.', 'success');
									loadSubcategories();
									loadSubcategoriesForManagement();
									resetSubcategoryForm();
									const modalElement = document.getElementById('subcategoryModal');
									const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
									modalInstance.hide();
								} else { showAlert(data.message || 'Fehler beim Löschen der Unterkategorie.', 'error'); }
							})
							.catch(error => showAlert('Fehler beim Löschen der Unterkategorie: ' + error.message, 'error'));
					});
				});
			}
			subcategorySelect.addEventListener('change', function () {
				if (this.value === 'new') {
					resetSubcategoryForm();
					new bootstrap.Modal(document.getElementById('subcategoryModal')).show();
					this.value = '';
				}
			});
			manageSubcategoriesBtn.addEventListener('click', loadSubcategoriesForManagement);
		} else {
			const subcategoryField = document.querySelector('#subcategory_id')?.closest('.col-md-3');
			if (subcategoryField) { subcategoryField.style.display = 'none'; }
		}

		function isBadText(text) {
			const badPatterns = [/<\o:p>/i, /<v:shape>/i, /<w:>/i, /mso-/i, /( ){5,}/i];
			return badPatterns.some(pattern => pattern.test(text));
		}

		function cleanText(text) {
			let cleaned = text.replace(/<\o:p>.*?<\/\o:p>/gi, '').replace(/mso-[\w-]+/gi, '').replace(/( ){3,}/gi, ' ');
			return cleaned;
		}

		function updateGlobalStatus() {
			const globalStatus = document.getElementById('global-status');
			const statusText = document.getElementById('global-status-text');
			clearTimeout(successTimer);

			let errors = [];
			let fixes = [];
			Object.entries(inputStates).forEach(([id, state]) => {
				if (state.status === 'error') { errors.push(state.label); }
				if (state.status === 'fixed') { fixes.push(state.label); }
			});

			let message = '';
			if (errors.length > 0) {
				globalStatus.style.background = '#d60015';
				message = `<b>Achtung!</b> In folgenden Feldern wurden fehlerhafte Formatierungen erkannt:<br><b>${errors.join(', ')}</b>.<br>Bitte überprüfen und korrigieren Sie die markierten Texte, bevor Sie den Artikel speichern.`;
				statusText.innerHTML = message.trim();
				globalStatus.style.display = 'block';
				wasProblematic = true;
			} else if (fixes.length > 0) {
				globalStatus.style.background = '#ffc107';
				message = `<b>Hinweis:</b> In folgenden Feldern wurden fehlerhafte Formatierungen <b>automatisch korrigiert</b>:<br><b>${fixes.join(', ')}</b>.<br>Bitte überprüfen Sie, ob der Text wie gewünscht übernommen wurde.`;
				statusText.innerHTML = message.trim();
				globalStatus.style.display = 'block';
				wasProblematic = true;
			} else {
				if (wasProblematic) {
					globalStatus.style.background = '#28a745';
					message = `Alle Texte sind in Ordnung und wurden erfolgreich korrigiert.`;
					statusText.innerHTML = message.trim();
					globalStatus.style.display = 'block';
					successTimer = setTimeout(() => { globalStatus.style.display = 'none'; }, 8000);
				} else {
					globalStatus.style.display = 'none';
				}
				wasProblematic = false;
			}
		}

		function validateInput(element, text) {
			const label = element.dataset.label || 'Unbekannt';
			const id = element.id || label;
			if (text.trim() === '') {
				delete inputStates[id];
				updateGlobalStatus();
				return;
			}
			let cleaned = cleanText(text);
			if (isBadText(text)) {
				if (isBadText(cleaned)) {
					inputStates[id] = {status: 'error', label};
				} else {
					element.value = cleaned;
					inputStates[id] = {status: 'fixed', label};
				}
			} else {
				inputStates[id] = {status: 'ok', label};
			}
			updateGlobalStatus();
		}

		function initSummernote(selector) {
			if (typeof jQuery === 'undefined') { return; }
			$(selector).summernote({
				height: 300,
				lang: 'de-DE',
				toolbar: [
					['style', ['style']],
					['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear', 'fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph', 'height', 'blockquote']],
					['table', ['table']],
					['insert', ['link', 'picture', 'video', 'hr']],
					['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']]
				],
				callbacks: {
					onPaste: function (e) {
						const bufferText = (e.originalEvent || e).clipboardData.getData('Text');
						e.preventDefault();
						let cleanedText = cleanText(bufferText);
						document.execCommand('insertText', false, cleanedText);
						validateInput(this, cleanedText);
					},
					onChange: function(contents) { validateInput(this, contents); },
					onImageUpload: function (files) {
						const { baseDir, suffix, title } = getImageUploadPath();
						const data = new FormData();
						data.append('image', files[0]);
						data.append('category_id', categoryId);
						data.append('subcategory_id', document.getElementById('subcategory_id')?.value || '');
						data.append('title', title);
						$.ajax({
							url: '<?= base_url('admin/article/upload_image') ?>',
							method: 'POST',
							data: data,
							contentType: false,
							processData: false,
							success: function (resp) {
								let response = resp;

								// Ak je odpoveď string, parsuj ako JSON
								if (typeof resp === 'string') {
									try {
										response = JSON.parse(resp);
									} catch (e) {
										showAlert('Neplatná odpoveď zo servera.', 'error');
										return;
									}
								}

								if (response.success && response.image_url) {
									$(selector).summernote('insertImage', response.image_url);
								} else {
									showAlert(response.error || 'Obrázok sa nepodarilo vložiť.', 'error');
								}
							}
							,
							error: function () {
								showAlert('Fehler beim Hochladen des Bildes.', 'error');
							}
						});
					},
					onMediaDelete: function ($target) {
						const imageUrl = $target.attr('src');
						$.ajax({
							url: '<?= base_url('admin/article/delete_image') ?>',
							method: 'POST',
							data: { image_url: imageUrl },
							success: function (response) {
								if (!response.success) {
									showAlert(response.error || 'Fehler beim Löschen des Bildes.', 'error');
								}
							}
						});
					}
				}
			});
		}

		const addSection = (content = '', image = '', imageTitle = '', imageDescription = '', buttonName = '', subpage = '', externalUrl = '', index) => {
			content = content.replace(/\r\n/g, '\n').replace(/\r/g, '\n').trim();
			const sectionHtml = `<div class="section mb-4 p-3 border rounded"><input type="hidden" name="sections[${index}]" value="section-${index}"><div class="row"><div class="col-md-9"><label class="col-form-label">Inhalt</label><textarea class="form-control section-content" name="sections[${index}]" rows="5" data-label="Sektion ${index + 1}">${content}</textarea></div><div class="col-md-3"><label class="col-form-label">Bild hochladen</label><input type="file" class="form-control mb-1" name="section_images[${index}]"><input type="hidden" name="old_section_image[${index}]" id="old_section_image_${index}" value="${image}"><input type="hidden" name="ftp_section_image[${index}]" id="ftp_section_image_${index}" value="${image}"><button type="button" class="btn btn-outline-secondary btn-sm ftp-picker mb-1" data-ftp-target="ftp_section_image_${index}" data-preview-target="ftpSectionImagePreview_${index}">Bild aus FTP wählen</button><div id="ftpSectionImagePreview_${index}" class="mb-2 position-relative">${image ? `<img src="${base_url}${image}" style="max-width:150px;max-height:150px;object-fit:contain;"><button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" style="padding: 2px 6px;" onclick="document.getElementById('ftpSectionImagePreview_${index}').innerHTML='';document.getElementById('old_section_image_${index}').value='';document.getElementById('ftp_section_image_${index}').value='';">×</button>` : ''}</div><label class="col-form-label">Bildtitel (SEO) <span class="text-danger">*</span></label><input type="text" class="form-control mb-1" name="section_image_titles[${index}]" value="${imageTitle}" data-label="Sektion ${index + 1} - Bildtitel (SEO)"><label class="col-form-label">Bildbeschreibung in der Sektion <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Beschreibung des Bildes in der Sektion, die im Frontend angezeigt werden kann."></i></label><input type="text" class="form-control mb-1" name="section_image_descriptions[${index}]" value="${imageDescription}" data-label="Sektion ${index + 1} - Bildbeschreibung"></div></div><div class="row mt-3"><div class="col-md-4"><label class="col-form-label">Button-Text</label><input type="text" class="form-control mb-1" name="button_names[${index}]" value="${buttonName}" data-label="Sektion ${index + 1} - Button-Text"></div><div class="col-md-4"><label class="col-form-label">Unterseite</label><select class="form-control mb-1 subpage-select" name="subpages[${index}]"><option value="">-- Unterseite auswählen --</option>${articleOptions.map(opt => `<option value="${opt.slug}" ${subpage === opt.slug ? 'selected' : ''}>${opt.label} (${opt.lang})</option>`).join('')}</select></div><div class="col-md-4"><label class="col-form-label">Externe URL</label><input type="text" class="form-control mb-1" name="external_urls[${index}]" value="${externalUrl}" data-label="Sektion ${index + 1} - Externe URL"></div></div><div class="section-actions mt-3"><button type="button" class="btn btn-sm btn-danger remove-section">Entfernen</button></div></div>`;
			const sectionsContainer = document.getElementById('sections-container');
			if (sectionsContainer) {
				sectionsContainer.insertAdjacentHTML('beforeend', sectionHtml);
				const textarea = sectionsContainer.querySelector('.section:last-child .section-content');
				if (textarea) { try { initSummernote(textarea); } catch (err) { textarea.value = textarea.value.replace(/<[^>]*>/g, ''); initSummernote(textarea); } }
				bindRemoveSection();
				bindFtpPicker();
				const newSection = document.querySelector('#sections-container .section:last-child');
				newSection.querySelectorAll('input[type="text"], textarea').forEach(el => {
					el.addEventListener('input', function() { validateInput(this, this.value); });
					el.addEventListener('paste', function(e) { const pasted = e.clipboardData.getData('Text'); e.preventDefault(); let cleaned = cleanText(pasted); this.value = (this.value || '') + cleaned; validateInput(this, this.value); });
					validateInput(el, el.value);
				});
				newSection.querySelectorAll('input[type="file"]').forEach(el => {
					el.addEventListener('change', function() {
						const file = this.files[0];
						if (file) {
							const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
							if (!allowedTypes.includes(file.type)) { showWarning(this, 'Achtung: Ungültiger Dateityp! Unterstützt: JPG, PNG, GIF, WEBP.'); this.value = ''; }
							else if (file.size > 5 * 1024 * 1024) { showWarning(this, 'Achtung: Die Datei ist zu groß (max 5MB)!'); this.value = ''; }
							else { hideWarning(this); }
							const imageTitleInput = newSection.querySelector(`input[name="section_image_titles[${index}]"]`);
							if (file && !imageTitleInput.value.trim()) {
								const title = document.getElementById('title')?.value.trim();
								if (title) {
									imageTitleInput.value = title;
									hideWarning(imageTitleInput);
								} else {
									showWarning(imageTitleInput, 'Bitte geben Sie einen Bildtitel (SEO) ein.');
									imageTitleInput.focus();
								}
							}

						}
					});
				});
			}
		};

		const bindRemoveSection = () => {
			document.querySelectorAll('.remove-section').forEach(button => {
				button.addEventListener('click', function () {
					if (confirm('Sind Sie sicher, dass Sie diese Sektion entfernen möchten?')) {
						const section = this.closest('.section');
						section.querySelectorAll('input[type="text"], textarea').forEach(el => { delete inputStates[el.id || el.dataset.label]; });
						section.remove();
						updateGlobalStatus();
					}
				});
			});
		};

		const bindFtpPicker = () => {
			document.querySelectorAll('.ftp-picker').forEach(button => {
				button.addEventListener('click', function () {
					const target = this.getAttribute('data-ftp-target');
					const previewTarget = this.getAttribute('data-preview-target');
					const modal = new bootstrap.Modal(document.getElementById('ftpModal'));
					modal.show();
					document.getElementById('ftpModal').dataset.ftpTarget = target;
					document.getElementById('ftpModal').dataset.previewTarget = previewTarget;
				});
			});
		};

		<?php if (!empty($sections)): ?>
		<?php foreach ($sections as $index => $section): ?>
		addSection(
			<?= json_encode($section->content, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
			'<?= htmlspecialchars($section->image ?? '') ?>', '<?= htmlspecialchars($section->image_title ?? '') ?>',
			'<?= htmlspecialchars($section->image_description ?? '') ?>', '<?= htmlspecialchars($section->button_name ?? '') ?>',
			'<?= htmlspecialchars($section->subpage ?? '') ?>', '<?= htmlspecialchars($section->external_url ?? '') ?>',
			<?= $index ?>
		);
		<?php endforeach; ?>
		<?php endif; ?>

		document.getElementById('add-section').addEventListener('click', function () {
			const sections = document.querySelectorAll('#sections-container .section').length;
			addSection('', '', '', '', '', '', '', sections);
		});

		document.getElementById('gallery_category_id').addEventListener('change', function () {
			const categoryId = this.value;
			const gallerySelect = document.getElementById('gallery_id');
			if (!categoryId) { gallerySelect.innerHTML = '<option value="">-- Zuerst Kategorie auswählen --</option>'; return; }
			fetch('<?= base_url('admin/article/getGalleriesByCategory') ?>', {
				method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
				body: 'category_id=' + encodeURIComponent(categoryId)
			})
				.then(response => { if (!response.ok) { throw new Error('Network response was not ok'); } return response.json(); })
				.then(data => {
					if (data.success) { gallerySelect.innerHTML = data.options; }
					else { showAlert(data.message || 'Fehler beim Laden der Galerien.', 'error'); }
				})
				.catch(error => { showAlert('Fehler beim Laden der Galerien: ' + error.message, 'error'); });
		});

		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		tooltipTriggerList.forEach(function (tooltipTriggerEl) { new bootstrap.Tooltip(tooltipTriggerEl); });

		document.querySelectorAll('input[type="text"], textarea:not(.section-content)').forEach(input => {
			input.addEventListener('input', function() { validateInput(this, this.value); });
			input.addEventListener('paste', function(e) {
				const pasted = e.clipboardData.getData('Text');
				e.preventDefault();
				let cleaned = cleanText(pasted);
				this.value = (this.value || '') + cleaned;
				validateInput(this, this.value);
			});
			validateInput(input, input.value);
		});

		document.querySelectorAll('input[type="file"]').forEach(fileInput => {
			fileInput.addEventListener('change', function() {
				const file = this.files[0];
				if (file) {
					const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
					if (!allowedTypes.includes(file.type)) { showWarning(this, 'Achtung: Ungültiger Dateityp! Unterstützt: JPG, PNG, GIF, WEBP.'); this.value = ''; }
					else if (file.size > 5 * 1024 * 1024) { showWarning(this, 'Achtung: Die Datei ist zu groß (max 5MB)!'); this.value = ''; }
					else { hideWarning(this); }
				}
				// Validácia titulov pre obrázky
				if (this.name === 'image' && file && !document.getElementById('image_title').value.trim()) {
					showWarning(document.getElementById('image_title'), 'Bitte geben Sie einen Bildtitel (SEO) ein.');
					document.getElementById('image_title').focus();
				}
				if (this.name.startsWith('section_images') && file) {
					const index = this.name.match(/\d+/)[0];
					const titleInput = document.querySelector(`input[name="section_image_titles[${index}]"]`);
					if (!titleInput.value.trim()) {
						showWarning(titleInput, 'Bitte geben Sie einen Bildtitel (SEO) ein.');
						titleInput.focus();
					}
				}
				if (this.name.startsWith('product_image') && file) {
					const index = this.name.match(/\d+/)[0] - 1;
					const titleInput = document.querySelector(`input[name="product_image_title${index + 1}"]`);
					if (!titleInput.value.trim()) {
						showWarning(titleInput, 'Bitte geben Sie einen Bildtitel (SEO) ein.');
						titleInput.focus();
					}
				}
			});
		});

		setTimeout(() => {
			document.querySelectorAll('.section-content').forEach(textarea => {
				if (!$(textarea).hasClass('note-editor')) { initSummernote(textarea); }
			});
		}, 500);
	});
</script>
