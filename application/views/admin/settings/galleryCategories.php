<form method="get" action="<?= base_url('admin/galleryCategory') ?>">
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
					<h3 class="card-title mb-0">Galerie-Kategorien</h3>
					<p class="card-subtitle">Anzahl: <?= isset($categories) && is_array($categories) ? count($categories) : 0 ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/galleryCategory/form') ?>" class="btn btn-sm btn-primary">+ Kategorie hinzufügen</a>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0" id="categoryTable">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center"></th>
							<th>Name</th>
							<th class="text-center">Sprache</th>
							<th class="text-center">Keywords</th>
							<th class="text-center">Beschreibung</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>

						<tbody>
						<?php if (!empty($categories)): ?>
							<?php foreach ($categories as $index => $cat): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td class="text-center">
										<img src="<?= langInfo($cat->lang)['flag'] ?>" width="24px" alt="flag">
									</td>
									<td><?= htmlspecialchars($cat->name) ?></td>
									<td class="text-center"><?= strtoupper($cat->lang) ?></td>
									<td class="text-center"><?= checkTextIcon($cat->keywords) ?></td>
									<td class="text-center"><?= checkTextIcon($cat->description) ?></td>
									<td class="text-center"><?= active($cat->active) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/galleryCategory/edit/' . $cat->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/galleryCategory/delete/' . $cat->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="8" class="text-center">Keine Daten</td></tr>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
				<div class="mt-3">
					<?= $pagination ?? '' ?>
				</div>
			</div>
		</section>
	</div>
</div>

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
