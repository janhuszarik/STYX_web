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
					<h3 class="card-title mb-0">Menü Liste</h3>
					<p class="card-subtitle">Anzahl: <?= count($menus) ?></p>
				</div>
				<div>
					<a href="<?= base_url('admin/menu/create') ?>" class="btn btn-sm btn-primary">+ Menü hinzufügen</a>
				</div>
			</header>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0 menu-table" id="menuTable">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th></th>
							<th>Menü</th>
							<th class="text-center">URL</th>
							<th class="text-center">Position</th>
							<th class="text-center">Aktiv</th>
							<th class="text-center">Aktionen</th>
						</tr>
						</thead>
						<tbody>
						<?php if (!empty($menus)): ?>
							<?php foreach ($menus as $i => $m): ?>
								<tr class="<?= $m->parent == 0 ? 'main-menu' : '' ?>">
									<td class="text-center"><?= $i + 1 ?></td>
									<td class="text-center">
										<img src="<?= langInfo($m->lang)['flag'] ?>" width="24px" alt="lang">
									</td>
									<td><?= $m->parent == 0 ? '<strong>' . $m->name . '</strong>' : '– ' . $m->name ?></td>
									<td class="text-center" title="<?= $m->url ?>"><?= substr($m->url, 0, 12) ?>...</td>
									<td class="text-center"><?= $m->orderBy ?></td>
									<td class="text-center"><?= active($m->active) ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/menu/edit/' . $m->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
										<a href="<?= base_url('admin/menu/del/' . $m->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
									</td>
								</tr>

								<?php if (!empty($m->submenu)): ?>
									<?php foreach ($m->submenu as $s): ?>
										<tr>
											<td class="text-center">–</td>
											<td class="text-center">
												<img src="<?= langInfo($s->lang)['flag'] ?>" width="24px" alt="lang">
											</td>
											<td>– <?= $s->name ?></td>
											<td class="text-center" title="<?= $s->url ?>"><?= substr($s->url, 0, 12) ?>...</td>
											<td class="text-center"><?= $s->orderBy ?></td>
											<td class="text-center"><?= active($s->active) ?></td>
											<td class="text-center">
												<a href="<?= base_url('admin/menu/edit/' . $s->id) ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
												<a href="<?= base_url('admin/menu/del/' . $s->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Möchten Sie wirklich löschen?')"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else: ?>
							<tr><td colspan="7" class="text-center">Keine Daten</td></tr>
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
