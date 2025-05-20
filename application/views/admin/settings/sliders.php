<div class="row">
	<!-- FORMULÁR VĽAVO -->
	<div class="col-lg-6">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($slider) ? 'Slider bearbeiten' : 'Slider hinzufügen' ?></h2>
				<p class="card-subtitle">Slider auf der Startseite verwalten.</p>
			</header>
			<div class="card-body">
				<?php echo form_open_multipart('admin/sliderSave/' . (isset($slider['id']) ? $slider['id'] : ''), ['id' => 'sliderForm']); ?>

				<div class="row form-group pb-3">
					<div class="col-lg-6">
						<label for="inputLang">Sprache</label>
						<select class="form-control" name="lang" id="inputLang">
							<option value="de" <?= isset($slider['lang']) && $slider['lang'] == 'de' ? 'selected' : '' ?>>Deutsch</option>
							<option value="en" <?= isset($slider['lang']) && $slider['lang'] == 'en' ? 'selected' : '' ?>>English</option>
						</select>
					</div>
					<div class="col-lg-6">
						<label for="active">Status</label>
						<select name="active" id="active" class="form-control">
							<option value="1" <?= isset($slider['active']) && $slider['active'] == 1 ? 'selected' : '' ?>>Aktiv</option>
							<option value="0" <?= isset($slider['active']) && $slider['active'] == 0 ? 'selected' : '' ?>>Inaktiv</option>
						</select>
					</div>
				</div>

				<div class="form-group pb-3">
					<label for="title">Titel für Inhalt</label>
					<input type="text" class="form-control" name="title" id="title" value="<?= isset($slider['title']) ? $slider['title'] : '' ?>">
				</div>

				<div class="form-group pb-3">
					<label for="name1">Hauptüberschrift</label>
					<input type="text" class="form-control" name="name1" id="name1" value="<?= isset($slider['name1']) ? $slider['name1'] : '' ?>">
				</div>

				<div class="form-group pb-3">
					<label for="name2">Unterüberschrift</label>
					<input type="text" class="form-control" name="name2" id="name2" value="<?= isset($slider['name2']) ? $slider['name2'] : '' ?>">
				</div>

				<div class="form-group pb-3">
					<label for="name3">Kleingeschriebener Text</label>
					<input type="text" class="form-control" name="name3" id="name3" value="<?= isset($slider['name3']) ? $slider['name3'] : '' ?>">
				</div>

				<div class="form-group pb-3">
					<label for="image">Slider Bild</label>
					<input type="file" class="form-control" name="image" id="image">
					<?php if (isset($slider['image'])): ?>
						<img src="<?= base_url('uploads/sliders/' . $slider['image']) ?>" width="100">
					<?php endif; ?>
				</div>

				<div class="form-group pb-3">
					<label for="button_link">Schaltflächenlink</label>
					<input type="text" class="form-control" name="button_link" id="button_link" value="<?= isset($slider['button_link']) ? $slider['button_link'] : '' ?>">
				</div>

				<div class="row form-group pb-3">
					<div class="col-md-6">
						<label for="bg_color">Hintergrundfarbe</label>
						<input type="color" class="form-control" style="height: 38px; padding: 4px 6px;" name="bg_color" id="bg_color" value="<?= isset($slider['bg_color']) ? htmlspecialchars($slider['bg_color']) : '#ffffff' ?>">
					</div>
					<div class="col-md-6">
						<label for="text_color">Textfarbe</label>
						<input type="color" class="form-control" style="height: 38px; padding: 4px 6px;" name="text_color" id="text_color" value="<?= isset($slider['text_color']) ? htmlspecialchars($slider['text_color']) : '#000000' ?>">
					</div>
				</div>

				<div class="form-group pb-3">
					<label for="orderBy">Sortierung</label>
					<input type="number" class="form-control" name="orderBy" id="orderBy" value="<?= isset($slider['orderBy']) ? $slider['orderBy'] : '' ?>" required>
				</div>

				<footer class="card-footer text-end">
					<?php if (isset($slider['id'])): ?>
						<input type="hidden" name="id" value="<?= $slider['id'] ?>">
						<button type="submit" class="btn btn-primary">Änderungen speichern</button>
					<?php else: ?>
						<button type="submit" class="btn btn-primary">Speichern</button>
					<?php endif; ?>
				</footer>
				<?php echo form_close(); ?>
			</div>
		</section>
	</div>

	<!-- TABUĽKA VPRAVO -->
	<div class="col-lg-6">
		<section class="card card-yellow">
			<header class="card-header">
				<h3 class="card-title">Slider Liste</h3>
				<p class="card-subtitle">
					Derzeit hinzugefügte Slider: <?= count($sliders) ?>
				</p>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0 text-center">
						<thead>
						<tr>
							<th>#</th>
							<th>Flagge</th>
							<th>Bild</th>
							<th>Inhalt</th>
							<th>Link</th>
							<th>Sort.</th>
							<th>Status</th>
							<th>Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($sliders)): ?>
							<?php foreach ($sliders as $index => $slider): ?>
								<tr>
									<td><?= $index + 1 ?></td>
									<td><img src="<?= langInfo($slider['lang'])['flag'] ?>" width="24" alt=""></td>
									<td><img src="<?= base_url('uploads/sliders/' . $slider['image']) ?>" width="50"></td>
									<td><?= $slider['title'] ?></td>
									<td><?= $slider['button_link'] ?></td>
									<td><?= $slider['orderBy'] ?></td>
									<td>
										<?php if ($slider['active']): ?>
											<i class="fa fa-check text-success"></i>
										<?php else: ?>
											<i class="fa fa-times text-danger"></i>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?= site_url('admin/sliderSave/' . $slider['id']) ?>" class="btn btn-success btn-sm">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="<?= site_url('admin/delete_slider/' . $slider['id']) ?>" class="btn btn-danger btn-sm">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="8" class="text-center"><h5>No sliders found.</h5></td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
