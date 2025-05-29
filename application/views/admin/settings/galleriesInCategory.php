<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Galerien in Kategorie: <?= htmlspecialchars($category->name) ?></h3>
					<p class="card-subtitle">Anzahl: <?= isset($galleries) && is_array($galleries) ? count($galleries) : 0 ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/gallery/form/category/' . $category->id) ?>" class="btn btn-sm btn-primary">+ Galerie hinzufügen</a>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0" id="galleryTable">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Name</th>
							<th class="text-center">Bilder</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($galleries)): ?>
							<?php foreach ($galleries as $index => $gallery): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td><?= htmlspecialchars($gallery->name) ?></td>
									<td class="text-center align-middle">
										<a href="<?= base_url('admin/image/form/gallery/' . $gallery->id) ?>"
										   class="btn btn-outline-primary d-inline-flex justify-content-center align-items-center"
										   style="width: 30px; height: 30px; font-size: 12px; padding: 0;">
											<?= $gallery->image_count ?? 0 ?>
										</a>
									</td>
									<td class="text-center"><?= active($gallery->active) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/gallery/edit/' . $gallery->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/gallery/delete/' . $gallery->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="5" class="text-center">Keine Galerien in dieser Kategorie</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
