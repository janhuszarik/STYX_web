<div class="container-fluid"> <!-- pridané pre istotu okolo všetkého -->
	<div class="row">
		<!-- FORMULÁR VĽAVO -->
		<div class="col-lg-6">
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
								<label class="col-form-label">Sprache</label>
								<select class="form-control" name="lang" id="inputLang">
									<option value="de" <?php echo ($menu->lang == 'de') ? 'selected' : ''; ?>>Deutsch</option>
									<option value="en" <?php echo ($menu->lang == 'en') ? 'selected' : ''; ?>>English</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label class="col-form-label">Aktiv?</label>
								<select name="active" class="form-control">
									<option value="1" <?= isset($articleCategory) && $articleCategory->active ? 'selected' : '' ?>>Ja</option>
									<option value="0" <?= isset($articleCategory) && !$articleCategory->active ? 'selected' : '' ?>>Nein</option>
								</select>
							</div>
						</div>

						<div class="form-group pb-3">
							<label class="col-form-label">Kategoriename</label>
							<input type="text" name="name" class="form-control" required value="<?= isset($articleCategory) ? htmlspecialchars($articleCategory->name) : '' ?>">
						</div>

						<button type="submit" class="btn btn-primary">
							<?= isset($articleCategory->id) ? 'Änderungen speichern' : 'Speichern' ?>
						</button>


					</form>
				</div>
			</section>
		</div>

		<!-- TABUĽKA VPRAVO -->
		<div class="col-lg-6">
			<section class="card card-yellow">
				<header class="card-header">
					<h3 class="card-title">Liste der Kategorien</h3>
					<p class="card-subtitle">
						Anzahl: <?= isset($articleCategories) && is_array($articleCategories) ? count($articleCategories) : 0 ?>
					</p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered mb-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Slug</th>
								<th>Sprache</th>
								<th>Aktiv</th>
								<th>Aktion</th>
							</tr>
							</thead>
							<tbody>
							<?php if (empty($articleCategories)): ?>
								<tr><td colspan="6" class="text-center">Keine Daten</td></tr>
							<?php else: foreach ($articleCategories as $k => $r): ?>
								<tr>
									<td><?= ++$k ?></td>
									<td><?= htmlspecialchars($r->name) ?></td>
									<td><?= $r->slug ?></td>
									<td><?= strtoupper($r->lang) ?></td>
									<td><?= $r->active ? 'Ja' : 'Nein' ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/article_categories/edit/' . $r->id) ?>"><i class="fa fa-edit text-success"></i></a>
										 
										<a href="<?= base_url('admin/article_categories/del/' . $r->id) ?>" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash text-danger"></i></a>
									</td>
								</tr>
							<?php endforeach; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div> <!-- zatvorený container -->
