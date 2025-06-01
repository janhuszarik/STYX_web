<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<input type="text" class="form-control mb-3" id="searchInput" placeholder="Suche Aktuell...">
			<header class="card-header d-flex justify-content-between align-items-center">
				<h3 class="card-title mb-0">NEWS Liste</h3>
				<a href="<?= base_url('admin/news/add') ?>" class="btn btn-sm btn-primary">+ Aktuell hinzufügen</a>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Überschrift</th>
							<th>Kurztext</th>
							<th>Link</th>
							<th>Von</th>
							<th>Bis</th>
							<th>Sprache</th>
							<th>Aktiv</th>
							<th>Bild</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($newss)): ?>
							<?php foreach ($newss as $index => $news): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td><?= htmlspecialchars($news->name) ?></td>
									<td><?= htmlspecialchars($news->name1) ?></td>
									<td><a href="<?= htmlspecialchars($news->buttonUrl) ?>" target="_blank"><?= htmlspecialchars($news->buttonUrl) ?></a></td>
									<td><?= $news->start_date ? date('d.m.Y', strtotime($news->start_date)) : '-' ?></td>
									<td><?= $news->end_date ? date('d.m.Y', strtotime($news->end_date)) : 'Unbegrenzt' ?></td>
									<td class="text-center">
										<?= strtoupper($news->lang) ?>
									</td>
									<td class="text-center"><?= active($news->active) ?></td>
									<td class="text-center">
										<?php if ($news->image): ?>
											<img src="<?= base_url('uploads/news/' . htmlspecialchars($news->image)) ?>" style="width: 50px;" alt="Bild">
										<?php else: ?>
											–
										<?php endif; ?>
									</td>
									<td class="text-center">
										<a href="<?= base_url('admin/news/edit/' . $news->id) ?>" class="btn btn-success btn-sm" title="Bearbeiten"><i class="fa fa-edit"></i></a>
										<a href="<?= base_url('admin/news/del/' . $news->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')" title="Löschen"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="10" class="text-center">Keine News gefunden.</td></tr>
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
