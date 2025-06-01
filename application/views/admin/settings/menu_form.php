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
							<label class="col-form-label">Sprache</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($menu->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($menu->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Aktiv?</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($menu->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($menu->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">Name des Menüelements</label>
						<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($menu->name ?? '') ?>">
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">URL (interne oder externe)</label>
						<input type="text" name="url" class="form-control" value="<?= htmlspecialchars($menu->url ?? '') ?>" readonly>
						<small class="text-muted">Für externe Links das gesamte https:// angeben</small>
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
