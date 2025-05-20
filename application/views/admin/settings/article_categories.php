<div class="row">
	<!-- TABUĽKA NA CELOU ŠÍRKU -->
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Kategorien Liste</h3>
					<p class="card-subtitle">Anzahl: <?= isset($articleCategories) && is_array($articleCategories) ? count($articleCategories) : 0 ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/article_categories/add') ?>" class="btn btn-sm btn-primary">+ Kategorie hinzufügen</a>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th></th>
							<th>Name</th>
							<th>Slug</th>
							<th class="text-center">Keywords</th>
							<th class="text-center">Description</th>
							<th class="text-center">Artikel im Kategorie</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($articleCategories)): ?>
							<?php foreach ($articleCategories as $index => $cat): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td class="text-center"><img src="<?=langInfo($cat->lang)['flag']?>" width="24px" alt="<?='country'.' '.$r->lang?>"></td>
									<td><?= htmlspecialchars($cat->name) ?></td>
									<td><?= $cat->slug ?></td>
									<td class="text-center"><?= checkTextIcon($cat->keywords) ?></td>
									<td class="text-center"><?= checkTextIcon($cat->description) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/articles_in_category/' . $cat->id) ?>" class="btn btn-sm btn-outline-primary px-2 py-0" style="font-size: 13px; line-height: 1.2;">
											<?= $cat->article_count ?? 0 ?>
										</a>
									</td>
									<td class="text-center">
										<?= $cat->active ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?>
									</td>
									<td class="text-center">
										<a href="<?= base_url('admin/article_categories/edit/' . $cat->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<?php if ($cat->article_count == 0): ?>
											<a href="<?= base_url('admin/article_categories/del/' . $cat->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="8" class="text-center">Keine Daten</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
