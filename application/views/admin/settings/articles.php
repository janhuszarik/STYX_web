<div class="row">
	<!-- TABUĽKA NA CELOU ŠÍRKU -->
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Artikel in Kategorie</h3>
					<p class="card-subtitle">Kategorie ID: <?=$categoryId ?></p>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Titel</th>
							<th>Slug</th>
							<th class="text-center">Keywords</th>
							<th class="text-center">Beschreibung</th>
							<th class="text-center">Meta</th>
							<th class="text-center">Erstellt</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($articles)): ?>
						<?php foreach ($articles as $index => $article): ?>
						<tr>
							<td class="text-center"><?= $index + 1 ?></td>
							<td><?= htmlspecialchars($article->title_alt) ?></td>
							<td><?= $article->slug ?></td>
							<td class="text-center"><?= checkTextIcon($article->keywords) ?></td>
							<td class="text-center"><?= checkTextIcon($article->text) ?></td>
							<td class="text-center"><?= checkTextIcon($article->meta) ?></td>
							<td class="text-center"><?= date('d.m.Y', strtotime($article->created_at)) ?></td>
							<td class="text-center">
								<?= $article->active == 'J' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?>
							</td>
							<td class="text-center">
								<a href="<?= base_url('admin/edit_article/' . $article->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
								<a href="<?= base_url('admin/delete_article/' . $article->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php else: ?>
						<tr><td colspan="9" class="text-center">Keine Artikel gefunden.</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
