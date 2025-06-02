
<?php
$categoryName = 'Neznáma kategória';
foreach ($articleCategories as $category) {
    if ($category->id == $categoryId) {
        $categoryName = $category->name;
        break;
    }
}
?>

<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<input type="text" class="form-control mb-3" id="searchInput" placeholder="Artikel suchen...">

			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Artikel in Kategorie</h3>
					<a href="<?=BASE_URL.'admin/article_categories'?>"><p class="card-subtitle">Kategorie ID: <?= htmlspecialchars($categoryId) ?> | <strong style="color: green"><?= htmlspecialchars($categoryName) ?></strong> </p></a>
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
							<th class="text-center">Sprache</th> <!-- New column for language flag -->
							<th>Titel</th>
							<th>Slug</th>
							<th class="text-center">Keywords</th>
							<th class="text-center">Meta</th>
							<th class="text-center">Status</th>
							<th class="text-center">Erstellt</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($articles)): ?>
							<?php foreach ($articles as $index => $article): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td class="text-center">
										<?php
										// Get language info using the langInfo helper
										$langInfo = langInfo($article->lang);
										?>
										<img src="<?= htmlspecialchars($langInfo['flag']) ?>" alt="<?= htmlspecialchars($langInfo['text']) ?>" title="<?= htmlspecialchars($langInfo['text']) ?>" style="width: 24px; height: 16px;">
									</td>
									<td><?= $article->title ?></td>
									<td><?= $article->slug ?></td>
									<td class="text-center"><?= checkTextIcon($article->keywords) ?></td>
									<td class="text-center"><?= checkTextIcon($article->meta) ?></td>
									<td class="text-center"><?= active($article->active)?></td>
									<td class="text-center"><?= date('d.m.Y', strtotime($article->created_at)) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/article_save/edit/' . $article->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/article_save/del/' . $article->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="10" class="text-center">Keine Artikel gefunden.</td></tr>
						<?php endif; ?>
						</tbody>
						<tfoot>
						<tr>
							<td colspan="10" class="text-center">
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
