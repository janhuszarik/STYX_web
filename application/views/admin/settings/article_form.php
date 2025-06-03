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

// Debug: Vypíšeme hodnoty, aby sme skontrolovali, či sú načítané
log_message('debug', 'Category ID in view: ' . $categoryId);
log_message('debug', 'Category Name in view: ' . ($categoryName ?? 'Not set'));
log_message('debug', 'Article slug in view: ' . ($article->slug ?? 'Not set'));

$CI->load->helper('app_helper');
$menuItems = getMenu();
$menuOptions = [];

foreach ($menuItems as $menu) {
	$menuOptions[] = [
		'value' => $menu['url'],
		'label' => $menu['name']
	];
	foreach ($menu['children'] as $submenu) {
		$menuOptions[] = [
			'value' => $submenu['url'],
			'label' => ' - ' . $submenu['name']
		];
	}
}

$menuOptionsJson = json_encode($menuOptions);

// Nastavenie defaultMenuUrl pre select input
$defaultMenuUrl = '';
if (isset($article) && !empty($article->slug)) {
	$defaultMenuUrl = $article->slug;
	log_message('debug', 'Using article slug for defaultMenuUrl: ' . $defaultMenuUrl);
} elseif ($categoryId) {
	$category = $CI->db->get_where('article_categories', ['id' => $categoryId])->row();
	if ($category && (!empty($category->menu_id) || !empty($category->submenu_id))) {
		$menuId = $category->menu_id ?: $category->submenu_id;
		$menu = $CI->db->get_where('menu', ['id' => $menuId])->row();
		if ($menu && !empty($menu->url)) {
			$defaultMenuUrl = $menu->url;
			log_message('debug', 'Using category menu for defaultMenuUrl: ' . $defaultMenuUrl);
		}
	}
}
?>

<style>
	.current-image { max-width: 40%; height: auto; }
	.section-actions { display: flex; justify-content: flex-end; margin-top: 10px; }
	.form-group .col-form-label { font-weight: 500; margin-bottom: 0.25rem; }
	.form-group .form-control { margin-bottom: 0.5rem; }
</style>

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
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Bestimmt die Sprache des Artikels. Wählen Sie zwischen Deutsch oder Englisch. Der Artikel wird in der gewählten Sprache gespeichert und angezeigt."></i>
							<select name="lang" id="lang" class="form-control" required>
								<option value="de" <?= (isset($article) && $article->lang == 'de') ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= (isset($article) && $article->lang == 'en') ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-md-5">
							<label for="title" class="col-form-label">Titel</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Haupttitel des Artikels. Dieser wird auf der Webseite angezeigt und ist für SEO relevant. Erforderliches Feld."></i>
							<input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($article->title ?? '') ?>" required>
						</div>
						<div class="col-md-5">
							<label for="subtitle" class="col-form-label">Untertitel</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ein optionaler Untertitel, der zusätzliche Informationen zum Artikel bereitstellt. Wird unter dem Haupttitel angezeigt."></i>
							<input type="text" class="form-control" name="subtitle" id="subtitle" value="<?= htmlspecialchars($article->subtitle ?? '') ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="category_name" class="col-form-label">Kategorie</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Zeigt die Kategorie des Artikels an. Dieses Feld ist schreibgeschützt und basiert auf der ausgewählten Kategorie-ID."></i>
							<?php if ($categoryName === 'Kategorie nicht gefunden'): ?>
								<input type="text" class="form-control is-invalid" id="category_name" name="category_name" value="Kategorie nicht gefunden (ID: <?= htmlspecialchars($categoryId) ?>) - Bitte wählen Sie eine gültige Kategorie" readonly>
								<?php if ($this->session->flashdata('error')): ?>
									<div class="invalid-feedback">
										<?= $this->session->flashdata('error') ?>
									</div>
								<?php endif; ?>
							<?php else: ?>
								<input type="text" class="form-control" id="category_name" name="category_name" value="<?= htmlspecialchars($categoryName) ?>" readonly>
							<?php endif; ?>
						</div>
						<div class="col-md-6">
							<label for="menu_select" class="col-form-label">Menu oder Submenu</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Verknüpfen Sie den Artikel mit einer Menü- oder Submenüpunkt, um den Slug automatisch zu übernehmen."></i>
							<select class="form-control" id="menuSelect" name="menu_select">
								<option value="">-- Kein Menü --</option>
								<?php foreach ($menuOptions as $option): ?>
									<option value="<?= htmlspecialchars($option['value']) ?>"
										<?= ($defaultMenuUrl === $option['value']) ? 'selected' : '' ?>>
										<?= htmlspecialchars($option['label']) ?>
									</option>
								<?php endforeach; ?>
							</select>
							<input type="hidden" name="slug" id="slug" value="<?= htmlspecialchars($article->slug ?? $defaultMenuUrl) ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="slug_display" class="col-form-label">Slug</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL-freundliche Adresse des Artikels. Wird automatisch aus dem Menü übernommen, wenn ein Menüpunkt ausgewählt ist."></i>
							<input type="text" class="form-control" id="slug_display" value="<?= htmlspecialchars($article->slug ?? $defaultMenuUrl) ?>" readonly>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-8">
							<label for="image" class="col-form-label">Hauptbild hochladen</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht das Hochladen eines Hauptbildes für den Artikel. Das Bild wird in der Artikelansicht angezeigt. Unterstützte Formate: JPG, PNG, GIF, WEBP."></i>
							<input type="file" class="form-control mb-1" name="image" id="image">
							<label for="image_title" class="col-form-label">Titel des Bildes (SEO)</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der SEO-Titel des Hauptbildes. Wird als Alt-Text verwendet, um die Suchmaschinenoptimierung zu verbessern."></i>
							<input type="text" class="form-control mb-1" name="image_title" id="image_title" placeholder="Titel des Bildes (SEO)" value="<?= htmlspecialchars($article->image_title ?? '') ?>">
							<input type="hidden" name="old_image" value="<?= htmlspecialchars($article->image ?? '') ?>">
							<input type="hidden" name="ftp_image" id="ftp_image" value="<?= htmlspecialchars($article->ftp_image ?? '') ?>">
							<button type="button" class="btn btn-outline-secondary btn-sm ftp-picker mb-1" data-ftp-target="ftp_image" data-preview-target="ftpImagePreview">
								Bild aus FTP wählen
							</button>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht die Auswahl eines Bildes aus einem FTP-Verzeichnis. Das ausgewählte Bild wird als Hauptbild des Artikels gespeichert."></i>
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
							<input type="text" class="form-control" name="keywords" id="keywords" value="<?= htmlspecialchars($article->keywords ?? '') ?>">
						</div>
						<div class="col-md-6">
							<label for="meta" class="col-form-label">Meta-Beschreibung</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Eine kurze Beschreibung des Artikels für Suchmaschinen. Wird in den Suchergebnissen angezeigt und sollte 50-160 Zeichen lang sein."></i>
							<textarea class="form-control" name="meta" id="meta" rows="3"><?= htmlspecialchars($article->meta ?? '') ?></textarea>
						</div>
					</div>
					<hr class="my-4 border-dark">

					<div class="form-group pb-3">
						<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
							Sektion Empfohlene Produkte
						</h3>
						<small class="text-muted ms-3">Diese Sektion kann leer bleiben, falls nicht benötigt.</small>
						<div class="row mt-2">
							<?php for ($i = 1; $i <= 3; $i++): ?>
								<?php
								$ftpProductImage = $article->{'ftp_product_image' . $i} ?? '';
								if (empty($ftpProductImage) && !empty($article->{'product_image' . $i})) {
									$ftpProductImage = base_url($article->{'product_image' . $i});
								}
								?>
								<div class="col-md-4 mb-3">
									<div class="mb-2">
										<label for="product_name<?= $i ?>" class="col-form-label">Produktname</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Name des empfohlenen Produkts. Wird in der Sektion ‚Empfohlene Produkte‘ angezeigt. Kann leer bleiben, wenn nicht benötigt."></i>
										<input type="text" class="form-control" id="product_name<?= $i ?>" name="product_name<?= $i ?>" placeholder="Name" value="<?= htmlspecialchars($article->{'product_name' . $i} ?? '') ?>">
									</div>
									<div class="mb-2">
										<label for="product_description<?= $i ?>" class="col-form-label">Beschreibung</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Eine kurze Beschreibung des empfohlenen Produkts. Wird unter dem Produktnamen angezeigt. Kann leer bleiben, wenn nicht benötigt."></i>
										<textarea class="form-control" id="product_description<?= $i ?>" name="product_description<?= $i ?>" rows="2" placeholder="Beschreibung"><?= htmlspecialchars($article->{'product_description' . $i} ?? '') ?></textarea>
									</div>
									<div class="mb-2">
										<label for="product_image<?= $i ?>" class="col-form-label">Produktbild hochladen</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht das Hochladen eines Bildes für das empfohlene Produkt. Wird in der Sektion ‚Empfohlene Produkte‘ angezeigt. Unterstützte Formate: JPG, PNG, GIF, WEBP."></i>
										<input type="file" class="form-control" id="product_image<?= $i ?>" name="product_image<?= $i ?>">
									</div>
									<div class="mb-2">
										<label for="product_image<?= $i ?>_title" class="col-form-label">Titel des Bildes (SEO)</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der SEO-Titel des Produktbildes. Wird als Alt-Text verwendet, um die Suchmaschinenoptimierung zu verbessern."></i>
										<input type="text" class="form-control" id="product_image<?= $i ?>_title" name="product_image<?= $i ?>_title" placeholder="Titel des Bildes (SEO)" value="<?= htmlspecialchars($article->{'product_image' . $i . '_title'} ?? '') ?>">
									</div>
									<input type="hidden" name="ftp_product_image<?= $i ?>" id="ftp_product_image<?= $i ?>" value="<?= htmlspecialchars($ftpProductImage) ?>">
									<input type="hidden" name="old_product_image<?= $i ?>" value="<?= htmlspecialchars($article->{'product_image' . $i} ?? '') ?>">
									<div class="mb-2">
										<button type="button" class="btn btn-outline-secondary btn-sm ftp-picker" data-ftp-target="ftp_product_image<?= $i ?>" data-preview-target="productImagePreview<?= $i ?>">
											Bild aus FTP wählen
										</button>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht die Auswahl eines Bildes aus einem FTP-Verzeichnis für das empfohlene Produkt. Das ausgewählte Bild wird in der Sektion ‚Empfohlene Produkte‘ angezeigt."></i>
									</div>
									<div id="productImagePreview<?= $i ?>" class="mb-2">
										<?php if (!empty($ftpProductImage)): ?>
											<img src="<?= htmlspecialchars($ftpProductImage) ?>" style="max-width:150px;max-height:150px;object-fit:contain;">
										<?php endif; ?>
									</div>
									<div class="mb-2">
										<label for="product_url<?= $i ?>" class="col-form-label">Produkt-URL</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL, zu der das empfohlene Produkt verlinkt. Kann eine interne oder externe Seite sein. Kann leer bleiben, wenn kein Link benötigt wird."></i>
										<input type="text" class="form-control" id="product_url<?= $i ?>" name="product_url<?= $i ?>" placeholder="URL" value="<?= htmlspecialchars($article->{'product_url' . $i} ?? '') ?>">
									</div>
								</div>
							<?php endfor; ?>
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
										<input type="text" class="form-control" id="empfohlen_name<?= $i ?>" name="empfohlen_name<?= $i ?>" placeholder="Titel" value="<?= htmlspecialchars($article->{'empfohlen_name' . $i} ?? '') ?>">
									</div>
									<div class="mb-2">
										<label for="empfohlen_url<?= $i ?>" class="col-form-label">URL</label>
										<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL des empfohlenen Artikels oder der Unterseite. Kann eine interne oder externe Seite sein. Kann leer bleiben, wenn nicht benötigt."></i>
										<input type="text" class="form-control" id="empfohlen_url<?= $i ?>" name="empfohlen_url<?= $i ?>" placeholder="URL" value="<?= htmlspecialchars($article->{'empfohlen_url' . $i} ?? '') ?>">
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
						<small class="text-muted ms-3">Legen Sie Start- und Enddatum fest. Aktiv/Inaktiv erfolgt automatisch.</small>
					</div>
					<div class="row form-group pb-3">
						<div class="col-md-4">
							<label for="start_date_from" class="col-form-label">Startdatum</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Legt das Startdatum des Artikels fest. Der Artikel wird ab diesem Datum um 00:00 Uhr automatisch aktiviert. Ohne Datum wird der Artikel sofort nach dem Speichern angezeigt."></i>
							<input type="date" class="form-control" name="start_date_from" id="start_date_from" value="<?= htmlspecialchars($article->start_date_from ?? '') ?>">
						</div>
						<div class="col-md-4">
							<label for="end_date_to" class="col-form-label">Enddatum</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Legt das Enddatum des Artikels fest. Der Artikel wird am angegebenen Datum um 23:59 Uhr automatisch deaktiviert. Der Status muss ‚Aktiv‘ sein, damit das Datum wirksam ist."></i>
							<input type="date" class="form-control" name="end_date_to" id="end_date_to" value="<?= htmlspecialchars($article->end_date_to ?? '') ?>">
						</div>
						<div class="col-md-4">
							<label for="active" class="col-form-label">Status</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Bestimmt, ob der Artikel aktiv (sichtbar) oder inaktiv (verborgen) ist. Inaktive Artikel sind für die Öffentlichkeit nicht sichtbar, unabhängig von Start- und Enddatum."></i>
							<select name="active" id="active" class="form-control">
								<option value="1" <?= (isset($article) && $article->active == '1') ? 'selected' : '' ?>>Aktiv</option>
								<option value="0" <?= (isset($article) && $article->active == '0') ? 'selected' : '' ?>>Inaktiv</option>
							</select>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary">Speichern</button>
						<a href="<?= base_url('admin/articles_in_category/' . ($categoryId ?? 0)) ?>" class="btn btn-secondary">Zurück</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>

<script>const BASE_URL = "<?= base_url() ?>";</script>
<script>
	let sectionCount = 0, maxSections = 6, sectionsData = <?= json_encode($sections ?? []) ?>;
	const menuOptions = <?= $menuOptionsJson ?>;

	function addSection(content = '', img = null, ftpImage = '', imageTitle = '', buttonName = '', subpage = '', externalUrl = '', oldImage = '') {
		if (sectionCount >= maxSections) return;
		sectionCount++;
		const id = sectionCount;
		let optionsHtml = '<option value="">-- Unterseite auswählen --</option>';
		menuOptions.forEach(opt => {
			const selected = opt.value === subpage ? 'selected' : '';
			optionsHtml += `<option value="${opt.value}" ${selected}>${opt.label}</option>`;
		});

		const html = `
			<div class="row align-items-start border p-2 mb-2" data-section="${id}">
				<div class="col-md-9">
					<label for="section_content${id}" class="col-form-label">Inhalt</label>
					<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Hauptinhalt der Sektion. Verwenden Sie den Texteditor, um formatierten Text, Bilder oder Links hinzuzufügen. Jede Sektion wird im Artikel als separater Abschnitt angezeigt."></i>
					<textarea name="sections[]" id="section_content${id}" class="form-control summernote" rows="3">${content}</textarea>
				</div>
				<div class="col-md-3">
					<div class="mb-2">
						<label for="section_image${id}" class="col-form-label">Bild hochladen</label>
						<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht das Hochladen eines Bildes für diese Sektion. Das Bild wird neben dem Inhalt der Sektion angezeigt. Unterstützte Formate: JPG, PNG, GIF, WEBP."></i>
						<input type="file" name="section_images[]" id="section_image${id}" class="form-control">
					</div>
					<div class="mb-2">
						<label for="section_image_title${id}" class="col-form-label">Titel des Bildes (SEO)</label>
						<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der SEO-Titel des Sektionsbildes. Wird als Alt-Text verwendet, um die Suchmaschinenoptimierung zu verbessern."></i>
						<input type="text" name="section_image_titles[]" id="section_image_title${id}" class="form-control" placeholder="Titel des Bildes (SEO)" value="${imageTitle}">
					</div>
					<input type="hidden" name="ftp_section_image[]" id="ftp_section_image${id}" value="${ftpImage}">
					<input type="hidden" name="old_section_image[]" id="old_section_image${id}" value="${oldImage}">
					<div class="mb-2">
						<button type="button" class="btn btn-outline-secondary btn-sm ftp-picker" data-ftp-target="ftp_section_image${id}" data-preview-target="sectionImagePreview${id}">
							Bild aus FTP wählen
						</button>
						<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht die Auswahl eines Bildes aus einem FTP-Verzeichnis für diese Sektion. Das ausgewählte Bild wird in der Sektion angezeigt."></i>
					</div>
					<div id="sectionImagePreview${id}" class="mb-2">
						${ftpImage ? `<img src="${ftpImage}" style="max-width:150px;max-height:150px;object-fit:contain;">` : ''}
						${img && !ftpImage ? `<img src="${img}" style="max-width:150px;max-height:150px;object-fit:contain;">` : ''}
					</div>
				</div>
				<div class="col-md-12 mt-2">
					<div class="row">
						<div class="col-md-4">
							<label for="button_name${id}" class="col-form-label">Button-Name</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Text des Buttons in dieser Sektion. Wenn angegeben, wird ein Button angezeigt, der mit einer Unterseite oder externen URL verknüpft werden kann."></i>
							<input type="text" name="button_names[]" class="form-control button-name" id="button_name${id}" placeholder="Name des Buttons" value="${buttonName}">
						</div>
						<div class="col-md-4">
							<label for="subpage${id}" class="col-form-label">Unterseite</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Verknüpft den Button mit einer internen Unterseite aus dem Menü. Aktiviert, wenn ein Button-Name angegeben ist. Hat Vorrang vor einer externen URL."></i>
							<select name="subpages[]" class="form-control subpage" id="subpage${id}" ${!buttonName ? 'disabled' : ''}>
								${optionsHtml}
							</select>
						</div>
						<div class="col-md-4">
							<label for="external_url${id}" class="col-form-label">Externe URL</label>
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Verknüpft den Button mit einer externen URL. Aktiviert, wenn ein Button-Name angegeben ist. Wird ignoriert, wenn eine Unterseite ausgewählt ist."></i>
							<input type="url" name="external_urls[]" class="form-control external-url" id="external_url${id}" placeholder="Externe URL" value="${externalUrl}" ${!buttonName ? 'disabled' : ''}>
						</div>
					</div>
					<div class="section-actions">
						<button type="button" class="btn btn-sm btn-danger remove-section">Entfernen</button>
					</div>
				</div>
			</div>`;
		document.querySelector('#sections-container').insertAdjacentHTML('beforeend', html);

		$(`[data-section="${id}"] .summernote`).summernote({ height: 200 });

		const buttonNameInput = document.getElementById(`button_name${id}`);
		const subpageInput = document.getElementById(`subpage${id}`);
		const externalUrlInput = document.getElementById(`external_url${id}`);

		buttonNameInput.addEventListener('input', function () {
			const hasValue = this.value.trim() !== '';
			subpageInput.disabled = !hasValue;
			externalUrlInput.disabled = !hasValue;
			if (!hasValue) {
				subpageInput.value = '';
				externalUrlInput.value = '';
			}
		});

		subpageInput.addEventListener('change', function () {
			if (this.value) {
				externalUrlInput.value = '';
			}
		});

		externalUrlInput.addEventListener('input', function () {
			if (this.value.trim()) {
				subpageInput.value = '';
			}
		});
	}

	document.addEventListener('DOMContentLoaded', () => {
		function initSummer() {
			$('.summernote').summernote({ height: 200 });
		}

		document.getElementById('add-section').onclick = () => addSection();

		document.getElementById('sections-container').onclick = e => {
			if (e.target.classList.contains('remove-section')) {
				e.target.closest('[data-section]').remove();
				sectionCount--;
			}
		};

		sectionsData.forEach(sec => {
			const img = sec.image ? BASE_URL + sec.image : null;
			const ftpImage = sec.ftp_image || '';
			const imageTitle = sec.image_title || '';
			const buttonName = sec.button_name || '';
			const subpage = sec.subpage || '';
			const externalUrl = sec.external_url || '';
			const oldImage = sec.image || '';
			addSection(sec.content, img, ftpImage, imageTitle, buttonName, subpage, externalUrl, oldImage);
		});

		const categorySelect = document.getElementById('gallery_category_id');
		const gallerySelect = document.getElementById('gallery_id');
		if (categorySelect && gallerySelect) {
			categorySelect.addEventListener('change', function () {
				const categoryId = this.value;
				if (!categoryId) {
					gallerySelect.innerHTML = '<option value="">-- Zuerst Kategorie auswählen --</option>';
					return;
				}
				fetch(BASE_URL + 'admin/article/getGalleriesByCategory', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: new URLSearchParams({ category_id: categoryId })
				})
					.then(response => response.json())
					.then(data => {
						gallerySelect.innerHTML = data.success ? data.options : '<option value="">-- Keine Galerien verfügbar --</option>';
					})
					.catch(error => {
						console.error('Error:', error);
						gallerySelect.innerHTML = '<option value="">-- Fehler beim Laden --</option>';
					});
			});
		}

		const menuSelect = document.getElementById('menuSelect');
		const slugInput = document.getElementById('slug');
		const slugDisplay = document.getElementById('slug_display');

		if (menuSelect && slugInput && slugDisplay) {
			menuSelect.addEventListener("change", function () {
				const selectedValue = this.value;
				if (selectedValue) {
					const parts = selectedValue.split('/').filter(part => part && !['de', 'en'].includes(part));
					const newSlug = parts.join('/');
					slugInput.value = newSlug;
					slugDisplay.value = newSlug;
					console.log('Slug updated to:', newSlug);
				} else {
					slugInput.value = '';
					slugDisplay.value = '';
					console.log('Slug cleared');
				}
			});

			const initialSlug = "<?= htmlspecialchars($article->slug ?? $defaultMenuUrl) ?>";
			if (initialSlug) {
				const matchingOption = Array.from(menuSelect.options).find(option => {
					const optionParts = option.value.split('/').filter(part => part && !['de', 'en'].includes(part));
					const optionSlug = optionParts.join('/');
					return optionSlug === initialSlug;
				});
				if (matchingOption) {
					menuSelect.value = matchingOption.value;
					slugInput.value = initialSlug;
					slugDisplay.value = initialSlug;
					console.log('Initial slug set to:', initialSlug);
				} else {
					console.log('No matching menu option found for slug:', initialSlug);
				}
			}
		} else {
			console.error('Menu select, slug input, or slug display not found');
		}

		document.getElementById('articleForm').addEventListener('submit', function (e) {
			const formData = new FormData(this);
			const formDataObject = {};
			formData.forEach((value, key) => {
				if (!formDataObject[key]) {
					formDataObject[key] = value;
				} else {
					if (!Array.isArray(formDataObject[key])) {
						formDataObject[key] = [formDataObject[key]];
					}
					formDataObject[key].push(value);
				}
			});
			console.log('Form data being submitted:', formDataObject);
		});
	});

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
			const parent = currentPath.includes('/') ? currentPath.substring(0, currentPath.lastIndexOf('/')) : '';
			loadFolder(parent);
		};
	});
</script>
