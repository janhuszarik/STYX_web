<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<input type="text" class="form-control mb-3" id="searchInput" placeholder="Artikel suchen...">

			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Artikel in Kategorie</h3>
					<p class="card-subtitle">Kategorie ID: <?= $categoryId ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/add_article/' . $categoryId) ?>" class="btn btn-sm btn-primary">+ Artikel hinzufügen</a>
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
									<td><?= $article->title?></td>
									<td><?= $article->slug ?></td>
									<td class="text-center"><?= checkTextIcon($article->keywords) ?></td>
									<td class="text-center"><?= checkTextIcon($article->text) ?></td>
									<td class="text-center"><?= checkTextIcon($article->meta) ?></td>
									<td class="text-center"><?= date('d.m.Y', strtotime($article->created_at)) ?></td>
									<td class="text-center">
										<?= $article->active == 'J' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?>
									</td>
									<td class="text-center">
										<a href="<?= base_url('admin/article_save/edit/' . $article->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/article_save/del/' . $article->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="9" class="text-center">Keine Artikel gefunden.</td></tr>
						<?php endif; ?>
						</tbody>
						<tfoot>
						<tr>
							<td colspan="9" class="text-center">
								<?= $pagination ?? '' ?>
							</td>
						</tr>
						</tfoot>

					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
	document.getElementById('searchInput').addEventListener('keyup', function () {
		const filter = this.value.toLowerCase();
		const rows = document.querySelectorAll('table tbody tr');
		rows.forEach(row => {
			row.style.display = [...row.cells].some(cell =>
				cell.textContent.toLowerCase().includes(filter)
			) ? '' : 'none';
		});
	});
</script>
