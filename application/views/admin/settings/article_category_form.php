<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($articleCategory) ? 'Kategorie bearbeiten' : 'Kategorie hinzufügen' ?></h2>
				<p class="card-subtitle">Geben Sie die Daten für die Artikelkategorie ein</p>
			</header>
			<div class="card-body">
				<form action="<?= base_url('admin/article_categories') ?>" method="post">
					<?php if (isset($articleCategory->id)): ?>
						<input type="hidden" name="id" value="<?= $articleCategory->id ?>">
					<?php endif; ?>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Sprache
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Sprache, unter der der Inhalt angezeigt wird."></i>
							</label>
							<select class="form-control" name="lang">
								<option value="de" <?= isset($articleCategory->lang) && $articleCategory->lang == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= isset($articleCategory->lang) && $articleCategory->lang == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Kategoriename
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Name der Kategorie, die für die gesamte Filterung und Kategorisierung verwendet wird."></i>
							</label>
							<input type="text" name="name" class="form-control" required value="<?= isset($articleCategory->name) ? htmlspecialchars($articleCategory->name) : '' ?>">
						</div>
					</div>



					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Keywords
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Schlüsselwörter für Kategorien. Diese werden auf der Website verwendet, um innerhalb der Artikelkategorien suchen zu können."></i>
							</label>
							<input type="text" name="keywords" class="form-control" value="<?= isset($articleCategory->keywords) ? htmlspecialchars($articleCategory->keywords) : '' ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Description
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Die **Description** bzw. **SEO-Metadaten** werden von der Website angezeigt und an die **Google Search Console** übermittelt – also an die Suchmaschine zur Indexierung und Darstellung in den Suchergebnissen."></i>
							</label>
							<input name="description" class="form-control" rows="3"><?= isset($articleCategory->description) ? htmlspecialchars($articleCategory->description) : '' ?>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-4">
							<label class="col-form-label">Aktiv?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Auswahl, ob der Menüpunkt aktiv sein soll oder verborgen bleibt und für die Öffentlichkeit nicht sichtbar ist."></i>
							</label>
							<select name="active" class="form-control">
								<option value="1" <?= isset($articleCategory->active) && $articleCategory->active ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= isset($articleCategory->active) && !$articleCategory->active ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
						<div class="col-lg-8"></div>
					</div>
					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($articleCategory->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/article_categories') ?>" class="btn btn-secondary">Zurück</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>
