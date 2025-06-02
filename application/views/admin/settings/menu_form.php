

<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($menu->id) ? 'Menüpunkt bearbeiten: ' . htmlspecialchars($menu->name) : 'Menüpunkt hinzufügen' ?></h2>
				<p class="card-subtitle">
					<?= isset($menu->id) ? 'Bearbeiten Sie bestehendes Menüelement nach Bedarf.' : 'Geben Sie die Daten für das Menüelement ein' ?>
				</p>
			</header>

			<div class="card-body">
				<form method="post" action="<?= base_url(isset($menu->id) ? 'admin/menu/edit/' . $menu->id : 'admin/menuSave') ?>">
					<?php if (!empty($menu->id)): ?>
						<input type="hidden" name="id" value="<?= $menu->id ?>">
					<?php endif; ?>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Sprache
							<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Sprachauswahl, in der dieser Menüpunkt angezeigt wird."></i>
							</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($menu->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($menu->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Aktiv?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Auswahl, ob der Menüpunkt aktiv sein soll oder verborgen bleibt und für die Öffentlichkeit nicht sichtbar ist."></i>
							</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($menu->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($menu->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Name des Menüpunkt
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Hauptname des Menüpunktes. Aus diesem Namen wird auch die URL generiert, auf die der Benutzer nach dem Klick weitergeleitet wird. Daher bitte korrekt und ohne Sonderzeichen ausfüllen!"></i>
							</label>
							<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($menu->name ?? '') ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">URL (interne oder externe)
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Wenn dieses Feld leer bleibt, wird die URL automatisch generiert. Falls eine externe URL hinzugefügt werden soll, muss sie im Format https://www.styx.at eingegeben werden. Das Wichtigste ist, dass die URL mit https:// beginnt."></i>
							</label>
							<input type="text" name="url" class="form-control" value="<?= htmlspecialchars($menu->url ?? '') ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Hauptmenüpunkt?</label>
							<select name="parent" class="form-control">
								<option value="0" <?= ($menu->parent ?? 0) == 0 ? 'selected' : '' ?>>Ja, Hauptmenü</option>
								<?php foreach ($menuparent as $parentItem): ?>
									<?php if ($parentItem->parent == 0): ?>
										<option value="<?= $parentItem->id ?>" <?= ($menu->parent ?? 0) == $parentItem->id ? 'selected' : '' ?>>
											<?= htmlspecialchars($parentItem->name) ?>
										</option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Position</label>
							<input type="number" name="orderBy" class="form-control" min="0" value="<?= htmlspecialchars($menu->orderBy ?? '') ?>">
						</div>
					</div>

					<div class="form-group pb-3">
						<div class="checkbox-custom checkbox-primary">
							<input type="checkbox" id="base" name="base" value="1" <?= !empty($menu->base) ? 'checked' : '' ?>>
							<label for="base">Leerer Menü-Button (nicht klickbar)</label>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($menu->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/menu') ?>" class="btn btn-danger">Zurück zur Liste</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>

