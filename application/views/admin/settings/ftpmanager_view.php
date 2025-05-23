<?php
$current_path = trim($current_path ?? '', '/');
$parent_path = dirname($current_path);
$parent_path = $parent_path === '.' ? '' : $parent_path;

$http_url_base = 'https://styx.styxnatur.at/';
?>

<section role="main" class="content-body">
	<header class="page-header">
		<h2>FTP Zoznam súborov</h2>
	</header>

	<p><i class="fas fa-folder-open"></i> <strong>Aktuálna cesta:</strong> <?= $current_path === '' ? '/' : htmlspecialchars($current_path) ?></p>

	<?php if (isset($files['__error'])): ?>
		<div class="alert alert-danger">❌ <?= $files['__error'] ?></div>
	<?php elseif (empty($files)): ?>
		<div class="alert alert-warning">⚠️ Žiadne záznamy.</div>
	<?php else: ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th>Typ</th>
					<th>Názov</th>
					<th>Cesta</th>
					<th>Veľkosť</th>
					<th>Akcia</th>
				</tr>
				</thead>
				<tbody>
				<?php if ($current_path !== ''): ?>
					<tr>
						<td>🔙</td>
						<td><a href="<?= base_url('admin/ftpmanager?path=' . urlencode($parent_path)) ?>"><em>Späť</em></a></td>
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
						<td><?= $is_dir ? '📁' : '📄' ?></td>
						<td>
							<?php if ($is_dir): ?>
								<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($full_path)) ?>">
									<strong><?= htmlspecialchars($name) ?></strong>
								</a>
							<?php else: ?>
								<?= htmlspecialchars($name) ?>
							<?php endif; ?>
						</td>
						<td><?= htmlspecialchars($full_path) ?></td>
						<td><?= $size !== null ? round($size / 1024, 2) . ' KB' : '-' ?></td>
						<td>
							<?php if (!$is_dir): ?>
								<?php if (preg_match('/\.(jpe?g|png|gif|webp)$/i', $name)): ?>
									<a href="<?= $url ?>" target="_blank" class="btn btn-sm btn-info">Zobraziť</a>
								<?php endif; ?>
								<a href="<?= base_url('admin/ftpmanager/download?path=' . urlencode($full_path)) ?>" class="btn btn-sm btn-success">Stiahnuť</a>
							<?php endif; ?>

						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</section>
