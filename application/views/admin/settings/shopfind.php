<?php
// application/views/admin/shopfind/index.php
?>

<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<input type="text" class="form-control mb-3" id="searchInput" placeholder="Standort suchen...">

			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Alle Standorte</h3>
					<p class="card-subtitle">Diese Standorte erscheinen später im Shopfinder auf der Karte</p>
				</div>
				<div>
					<a href="<?= base_url('admin/shopfind/add') ?>" class="btn btn-sm btn-primary">+ Standort hinzufügen</a>
				</div>
			</header>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Name</th>
							<th>Adresse</th>
							<th>PLZ</th>
							<th>Stadt</th>
							<th>Land</th>
							<th>Status</th>
							<th>Erstellt</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($locations)): ?>
							<?php foreach ($locations as $index => $loc): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td><?= htmlspecialchars($loc->name) ?></td>
									<td><?= htmlspecialchars($loc->address) ?></td>
									<td><?= htmlspecialchars($loc->zip_code) ?></td>
									<td><?= htmlspecialchars($loc->city) ?></td>
									<td><?= htmlspecialchars($loc->website) ?></td>
									<td class="text-center"><?= active($loc->active) ?></td>
									<td class="text-center"><?= date('d.m.Y', strtotime($loc->created_at)) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/shopfind/edit/' . $loc->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/shopfind/del/' . $loc->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="9" class="text-center">Keine Standorte gefunden.</td></tr>
						<?php endif; ?>
						</tbody>
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
