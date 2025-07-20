<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php elseif ($this->session->flashdata('success')): ?>
	<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<?php
$current_path = trim($current_path ?? '', '/');
$parent_path = dirname($current_path) === '.' ? '' : trim(dirname($current_path), '/');
$parent_path = $parent_path === '' ? 'Uploads' : $parent_path;
$http_url_base = 'https://styx.styxnatur.at/';
?>

<style>
	.table-responsive table {
		table-layout: auto;
		width: 100%;
		border-collapse: collapse;
	}
	.table-responsive th,
	.table-responsive td {
		border: 1px solid #dee2e6;
		padding: 8px;
	}
	.table-responsive th.col-name,
	.table-responsive td.col-name,
	.table-responsive th.col-path,
	.table-responsive td.col-path {
		width: 1%;
		white-space: normal;
	}
	.table-responsive th.col-type,
	.table-responsive td.col-type {
		white-space: nowrap;
		width: 50px;
		min-width: 50px;
		max-width: 50px;
		text-align: center;
	}
	.table-responsive th.col-size,
	.table-responsive td.col-size {
		white-space: nowrap;
		width: 100px;
		min-width: 100px;
		max-width: 100px;
	}
	.table-responsive th.action-buttons,
	.table-responsive td.action-buttons {
		white-space: nowrap;
		width: 150px;
		min-width: 150px;
		max-width: 150px;
	}
	.table-responsive tbody tr:hover {
		background-color: #f5f5f5;
	}
	.action-buttons .btn-group .btn {
		margin-right: 5px;
	}
	.action-buttons .btn-group .btn:last-child {
		margin-right: 0;
	}
</style>

<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<section class="card">
				<header class="card-header d-flex justify-content-between align-items-start flex-wrap">
					<div class="mb-2">
						<h3 class="card-title mb-0">Dateiverwaltung via FTP | <a href="https://www.hostcreators.sk" target="_blank">Hostcreators</a></h3>
						<p class="card-subtitle">Aktueller Pfad: <?= $current_path === '' ? '/Uploads' : htmlspecialchars($current_path) ?></p>
					</div>

					<div class="d-flex flex-column flex-md-row align-items-start gap-3 text-end">
						<form action="<?= base_url('admin/ftpmanager/upload') ?>" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-2">
							<input type="hidden" name="path" value="<?= htmlspecialchars($current_path) ?>">
							<input type="file" name="image" class="form-control form-control-sm" id="imageUpload" accept="image/*,.pdf" required>
							<button type="submit" class="btn btn-sm btn-primary">Datei hochladen</button>
						</form>

						<form action="<?= base_url('admin/ftpmanager/create_folder') ?>" method="post" class="d-flex flex-column gap-2">
							<input type="hidden" name="current_path" value="<?= htmlspecialchars($current_path) ?>">
							<input type="text" name="folder_name" class="form-control form-control-sm" placeholder="Neuer Ordner name" required>
							<button type="submit" class="btn btn-sm btn-danger">Ordner erstellen</button>
						</form>
					</div>
				</header>

				<div class="card-body border-bottom">
					<form action="<?= base_url('admin/ftpmanager') ?>" method="get" class="mb-0">
						<input type="hidden" name="path" value="<?= htmlspecialchars($current_path) ?>">
						<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Suchen im aktuellen Verzeichnis..." value="<?= htmlspecialchars($this->input->get('q') ?? '') ?>">
							<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Suchen</button>
							<?php if (!empty($this->input->get('q'))): ?>
								<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($current_path)) ?>" class="btn btn-secondary">Filter löschen</a>
							<?php endif; ?>
						</div>
					</form>
				</div>

				<div class="card-body">
					<?php if (is_array($files) && isset($files['__error'])): ?>
						<div class="alert alert-danger">❌ <?= htmlspecialchars($files['__error']) ?></div>
					<?php elseif (empty($files) || (is_array($files) && count($files) === 0)): ?>
						<div class="alert alert-warning">
							<?php if (!empty($this->input->get('q'))): ?>
								⚠️ Für "<?= htmlspecialchars($this->input->get('q')) ?>" wurden keine Ergebnisse gefunden.
							<?php else: ?>
								⚠️ Leer | Keine Data.
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table table-responsive-md table-hover table-bordered mb-0">
							<thead>
							<tr>
								<th class="col-type">Typ</th>
								<th class="col-name">Name</th>
								<th class="col-path">Pfad</th>
								<th class="col-size">Größe</th>
								<th class="action-buttons">Aktion</th>
							</tr>
							</thead>
							<tbody>
							<?php if (strtolower($current_path) !== 'uploads' && $current_path !== ''): ?>
								<tr>
									<td class="col-type">
										<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($parent_path)) ?>">
											<strong style="color: green">
												<i class="fa fa-arrow-left" aria-hidden="true"></i> Zurück
											</strong>
										</a>
									</td>
									<td></td>
									<td colspan="3"></td>
								</tr>
							<?php endif; ?>
							<?php if (!empty($files) && is_array($files)): ?>
								<?php foreach ($files as $file): ?>
									<?php
									$is_dir = $file['type'] === 'dir';
									$name = $file['name'];
									$full_path = $file['path'];
									$size = $file['size'];
									$url = $http_url_base . $full_path;
									?>
									<tr>
										<td class="col-type" style="font-size: 25px" data-title="Type">
											<?php
											if ($is_dir) {
												echo '<i class="fa fa-folder" style="color: #f0ad4e;"></i>';
											} elseif (preg_match('/\.(jpe?g|png|gif|webp)$/i', $name)) {
												echo '<i class="fa fa-file-image" style="color: #5bc0de;"></i>';
											} elseif (preg_match('/\.pdf$/i', $name)) {
												echo '<i class="fa fa-file-pdf" style="color: #d9534f;"></i>';
											} else {
												echo '<i class="fa fa-file" style="color: #999;"></i>';
											}
											?>
										</td>
										<td class="col-name" data-title="Name">
											<?php if ($is_dir): ?>
												<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($full_path)) ?>">
													<strong><?= htmlspecialchars($name) ?></strong>
												</a>
											<?php else: ?>
												<?= htmlspecialchars($name) ?>
											<?php endif; ?>
										</td>
										<td class="col-path" data-title="Path">
											<a href="<?= htmlspecialchars($http_url_base . $full_path) ?>" target="_blank">
												<?= htmlspecialchars($http_url_base . $full_path) ?>
											</a>
										</td>
										<td class="col-size" data-title="Size"><?= $size !== null ? round($size / 1024, 2) . ' KB' : '-' ?></td>
										<td data-title="Action" class="action-buttons">
											<?php if (!$is_dir): ?>
												<div class="btn-group" role="group">
													<?php if (preg_match('/\.(jpe?g|png|gif|webp|pdf)$/i', $name)): ?>
														<a href="<?= $url ?>" target="_blank" class="btn btn-sm btn-info" title="Zobraziť">
															<i class="fa fa-eye"></i>
														</a>
													<?php endif; ?>
													<a href="<?= base_url('admin/ftpmanager/download?path=' . urlencode($full_path)) ?>" class="btn btn-sm btn-success" title="Stiahnuť">
														<i class="fa fa-download"></i>
													</a>
													<a href="<?= base_url('admin/ftpmanager/delete?path=' . urlencode($full_path)) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Naozaj vymazať?')" title="Vyhodit">
														<i class="fa fa-trash"></i>
													</a>
												</div>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
