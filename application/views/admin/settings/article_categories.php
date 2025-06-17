<form method="get" action="<?= base_url('admin/article_categories') ?>">
	<div class="row mb-3">
		<div class="col-md-6">
			<input type="text" id="categorySearch" name="search" value="<?= $this->input->get('search') ?>" class="form-control" placeholder="Suchen...">
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary">Suchen</button>
		</div>
	</div>
</form>


<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Kategorien Liste</h3>
					<p class="card-subtitle">Anzahl: <?= isset($articleCategories) && is_array($articleCategories) ? count($articleCategories) : 0 ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/article_category_form') ?>" class="btn btn-sm btn-primary">+ Kategorie hinzufügen</a>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<!-- ... predchádzajúci kód ... -->
					<table class="table table-hover table-bordered mb-0" id="categoryTable">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th></th>
							<th>Name</th>
							<th>URL-Adresse</th>
							<th class="text-center">Typ</th>
							<th class="text-center">Poradie</th> <!-- Nový stĺpec -->
							<th class="text-center">Artikel</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($articleCategories)): ?>
							<?php foreach ($articleCategories as $index => $cat): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td class="text-center"><img src="<?= langInfo($cat->lang)['flag'] ?>" width="24px" alt="flag"></td>
									<td><?= htmlspecialchars($cat->name) ?></td>
									<td><?= $cat->slug ?></td>
									<td class="text-center">
										<?php
										if (!empty($cat->menu_id)) {
											echo isset($cat->parent) && $cat->parent > 0 ? 'Submenu' : 'Hauptmenu';
										} elseif (!empty($cat->submenu_id)) {
											echo 'Submenu';
										} else {
											echo 'Eigene Kategorie';
										}
										?>
									</td>
									<td class="text-center"><?= $cat->orderBy ?></td> <!-- Zobrazenie poradia -->
									<td class="text-center align-middle">
										<a href="<?= base_url('admin/articles_in_category/' . $cat->id) ?>"
										   class="btn btn-outline-primary d-inline-flex justify-content-center align-items-center"
										   style="width: 30px; height: 30px; font-size: 12px; padding: 0;">
											<?= $cat->article_count ?? 0 ?>
										</a>
									</td>
									<td class="text-center"><?= active($cat->active) ?></td>
									<td class="text-center">
										<?php if (empty($cat->menu_id) && empty($cat->submenu_id)): ?>
											<a href="<?= base_url('admin/article_categories/edit/' . $cat->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
											<?php if ($cat->article_count == 0): ?>
												<a href="<?= base_url('admin/article_categories/del/' . $cat->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
											<?php endif; ?>
										<?php else: ?>
											<span class="text-muted">Generiert von Menü</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="10" class="text-center">Keine Daten</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
					<!-- ... nasledujúci kód ... -->				</div>
				<div class="mt-3">
					<?= $pagination ?? '' ?>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- Hľadanie v JS -->
<script>
	document.addEventListener("DOMContentLoaded", function () {
		const searchInput = document.getElementById("categorySearch");
		const rows = document.querySelectorAll("#categoryTable tbody tr");

		searchInput.addEventListener("input", function () {
			const val = this.value.toLowerCase();
			rows.forEach(row => {
				const visible = row.innerText.toLowerCase().includes(val);
				row.style.display = visible ? '' : 'none';
			});
		});
	});

</script>
