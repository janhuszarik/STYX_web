<?php
$current_path = trim($current_path ?? '', '/');
$parent_path = dirname($current_path);
$parent_path = $parent_path === '.' ? '' : $parent_path;

$http_url_base = 'https://styx.styxnatur.at/';
?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<section class="card">
				<header class="card-header d-flex justify-content-between align-items-center">
					<div>
						<h3 class="card-title">File Management via FTP | <a href="https://www.hostcreators.sk">Hostcreators</a></h3>
						<p class="card-subtitle">Current Path: <?= $current_path === '' ? '/' : htmlspecialchars($current_path) ?></p>
					</div>
					<div class="text-end">
						<form action="<?= base_url('admin/ftpmanager/upload') ?>" method="post" enctype="multipart/form-data">
							<input type="file" name="image" class="form-control mb-2" id="imageUpload" accept="image/*">
							<button type="submit" class="btn btn-primary btn-sm">Upload Image</button>
						</form>
					</div>
				</header>
				<div class="card-body">
					<?php if (isset($files['__error'])): ?>
						<div class="alert alert-danger">❌ <?= $files['__error'] ?></div>
					<?php elseif (empty($files)): ?>
						<div class="alert alert-warning">⚠️ No records.</div>
					<?php else: ?>
						<div class="table-responsive">
							<table class="table table-responsive-md table-hover table-bordered mb-0">
								<thead>
								<tr>
									<th>Type</th>
									<th>Name</th>
									<th>Path</th>
									<th>Size</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								<?php if ($current_path !== ''): ?>
									<tr>
										<td>
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
								<?php foreach ($files as $file): ?>
									<?php
									$is_dir = $file['type'] === 'dir';
									$name = $file['name'];
									$full_path = $file['path'];
									$size = $file['size'];
									$url = $http_url_base . $full_path;
									?>
									<tr>
										<td data-title="Type"><?= $is_dir ? '📁' : '📄' ?></td>
										<td data-title="Name">
											<?php if ($is_dir): ?>
												<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($full_path)) ?>">
													<strong><?= htmlspecialchars($name) ?></strong>
												</a>
											<?php else: ?>
												<?= htmlspecialchars($name) ?>
											<?php endif; ?>
										</td>
										<td data-title="Path"><?= htmlspecialchars($full_path) ?></td>
										<td data-title="Size"><?= $size !== null ? round($size / 1024, 2) . ' KB' : '-' ?></td>
										<td data-title="Action">
											<?php if (!$is_dir): ?>
												<?php if (preg_match('/\.(jpe?g|png|gif|webp)$/i', $name)): ?>
													<a href="<?= $url ?>" target="_blank" class="btn btn-sm btn-info">View</a>
												<?php endif; ?>
												<a href="<?= base_url('admin/ftpmanager/download?path=' . urlencode($full_path)) ?>" class="btn btn-sm btn-success">Download</a>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
</div>
