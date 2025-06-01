
<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<input type="text" class="form-control mb-3" id="searchInput" placeholder="Slider suchen...">

			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Slider Liste</h3>
					<p class="card-subtitle">Gesamt: <?= count($sliders) ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/slider/add') ?>" class="btn btn-sm btn-primary">+ Slider hinzufügen</a>
				</div>
			</header>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Sprache</th>
							<th class="text-center">Bild</th>
							<th>Titel</th>
							<th>Link</th>
							<th class="text-center">Sortierung</th>
							<th class="text-center">Status</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($sliders)): ?>
							<?php foreach ($sliders as $index => $slider): ?>
								<tr>
									<td class="text-center"><?= $index + 1 ?></td>
									<td class="text-center">
										<?php
										$langInfo = langInfo($slider->lang);
										?>
										<img src="<?= htmlspecialchars($langInfo['flag']) ?>" alt="<?= htmlspecialchars($langInfo['text']) ?>" title="<?= htmlspecialchars($langInfo['text']) ?>" style="width: 24px; height: 16px;">
									</td>
									<td class="text-center">
										<?php if ($slider->image): ?>
											<img src="<?= base_url('Uploads/sliders/' . $slider->image) ?>" style="width: 50px;">
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
									<td><?= htmlspecialchars($slider->title) ?></td>
									<td class="text-center"><?= htmlspecialchars($slider->button_link) ?></span></td>
									<td class="text-center"><?= $slider->orderBy ?></td>
									<td class="text-center"><?= active($slider->active) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/slider/edit/' . $slider->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/slider/del/' . $slider->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="8" class="text-center">Keine Slider gefunden.</td></tr>
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
