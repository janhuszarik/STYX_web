<?php /* bestProduct_list.php */ ?>
<style>
	.menu-table tr {
		background-color: white;
	}
	.menu-table tr.main-menu:hover {
		background-color: #f5f5f5;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Produktliste</h3>
					<p class="card-subtitle">Anzahl: <?= count($products) ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/bestProduct/create') ?>" class="btn btn-sm btn-primary">+ Produkt hinzufügen</a>
				</div>
			</header>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0 menu-table">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Bild</th>
							<th>Produkt</th>
							<th class="text-center">URL</th>
							<th class="text-center">ab:</th>
							<th class="text-center">bis:</th>
							<th class="text-center">Position</th>
							<th class="text-center">Aktiv</th>
							<th class="text-center">Aktion</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($products)): ?>
							<?php $mainIndex = 1; ?>
							<?php foreach ($products as $p): ?>
								<tr class="<?= $p->active ? 'main-menu' : '' ?>">
									<td class="text-center"><?= $mainIndex ?></td>
									<td class="text-center">
										<img src="<?= langInfo($p->lang)['flag'] ?>" width="24px" alt="lang">
									</td>
									<td><strong><?= $p->name ?></strong></td>
									<td class="text-center"><?= $p->url ?></td>
									<td class="text-center"><?= $p->start_date ?></td>
									<td class="text-center"><?= $p->end_date ?></td>
									<td class="text-center"><?= $p->orderBy ?></td>
									<td class="text-center"><?= active($p->active) ?></td>
									<td class="text-center"><?= $p->action ? 'Ja' : 'Nein' ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/bestProduct/edit/' . $p->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/bestProduct/del/' . $p->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								<?php $mainIndex++; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="10" class="text-center">Keine Daten</td></tr>
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
