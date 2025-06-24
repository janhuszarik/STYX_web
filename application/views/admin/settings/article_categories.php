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

			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0" id="categoryTable">
						<thead>
						<tr>
							<th class="text-center"></th>
							<th class="text-center">#</th>
							<th></th>
							<th>Name</th>
							<th>URL-Adresse</th>
							<th class="text-center">Typ</th>
							<th class="text-center">die Reihenfolge</th>
							<th class="text-center">Artikel</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($articleCategories)): ?>
							<?php $index = 1; $current_parent = null; ?>
							<?php foreach ($articleCategories as $cat): ?>
								<?php
								$is_main_menu = $cat->parent == 0 && $cat->menu_id;
								$is_submenu = $cat->parent != 0;
								$is_custom = !$cat->menu_id && !$cat->submenu_id;
								?>
								<?php if ($is_main_menu && $current_parent != $cat->menu_id): ?>
									<?php $current_parent = $cat->menu_id; ?>
									<tr class="main-menu" data-toggle="collapse" data-target=".submenu-<?= $cat->menu_id ?>" style="background-color: #f8f9fa; cursor: pointer;">
										<td class="text-center">
											<i class="fa fa-chevron-down"></i>
										</td>
										<td class="text-center"></td>
										<td class="text-center"><img src="<?= langInfo($cat->lang)['flag'] ?>" width="24px" alt="flag"></td>
										<td><strong><?= htmlspecialchars($cat->name) ?></strong></td>
										<td><?= $cat->slug ?></td>
										<td class="text-center">Hauptmenu</td>
										<td class="text-center"><?= $cat->orderBy ?></td>
										<td class="text-center">-</td>
										<td class="text-center"><?= active($cat->active) ?></td>
										<td class="text-center">
											<span class="text-muted">Generiert von Menü</span>
										</td>
									</tr>
								<?php endif; ?>
								<?php if ($is_submenu || $is_custom): ?>
									<tr class="submenu submenu-<?= $cat->parent ?>" style="display: <?= $is_submenu ? 'none' : '' ?>;">
										<td class="text-center"></td>
										<td class="text-center"><?= $index++ ?></td>
										<td class="text-center"><img src="<?= langInfo($cat->lang)['flag'] ?>" width="24px" alt="flag"></td>
										<td><?= $is_submenu ? '– ' : '' ?><?= htmlspecialchars($cat->name) ?></td>
										<td><?= $cat->slug ?></td>
										<td class="text-center">
											<?= $is_submenu ? 'Submenu' : 'Eigene Kategorie' ?>
										</td>
										<td class="text-center"><?= $cat->orderBy ?></td>
										<td class="text-center">
											<a href="<?= base_url('admin/articles_in_category/' . $cat->id) ?>"
											   class="btn btn-outline-primary d-inline-flex justify-content-center align-items-center"
											   style="width: 30px; height: 30px; font-size: 12px; padding: 0;">
												<?= $cat->article_count ?? 0 ?>
											</a>
										</td>
										<td class="text-center"><?= active($cat->active) ?></td>
										<td class="text-center">
											<?php if ($is_custom): ?>
												<a href="<?= base_url('admin/article_categories/edit/' . $cat->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
												<?php if ($cat->article_count == 0): ?>
													<a href="<?= base_url('admin/article_categories/del/' . $cat->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
												<?php endif; ?>
											<?php else: ?>
												<span class="text-muted">Generiert von Menü</span>
											<?php endif; ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="10" class="text-center">Keine Daten</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>


<script>
	document.addEventListener("DOMContentLoaded", function () {
		const mainMenus = document.querySelectorAll('.main-menu');
		mainMenus.forEach(menu => {
			menu.addEventListener('click', function () {
				const target = this.getAttribute('data-target');
				document.querySelectorAll(target).forEach(submenu => {
					submenu.style.display = submenu.style.display === 'none' ? '' : 'none';
				});
				const icon = this.querySelector('i');
				icon.classList.toggle('fa-chevron-down');
				icon.classList.toggle('fa-chevron-up');
			});
		});

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
