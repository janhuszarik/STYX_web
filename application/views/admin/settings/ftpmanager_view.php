<?php
if (!function_exists('ends_with')) {
	function ends_with($haystack, $needle) {
		return substr($haystack, -strlen($needle)) === $needle;
	}
}
$current_path = trim($current_path ?? '', '/');
$parent_path = dirname($current_path);
$parent_path = $parent_path === '.' ? '' : $parent_path;
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
				<thead><tr><th style="width:50px;">Typ</th><th>Názov</th></tr></thead>
				<tbody>

				<?php if ($current_path !== ''): ?>
					<tr>
						<td>🔙</td>
						<td>
							<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($parent_path)) ?>"><em>Späť</em></a>
						</td>
					</tr>
				<?php endif; ?>

				<?php foreach ($files as $file): ?>
					<?php
					$is_dir = false;
					$name = basename($file);
					$next_path = $current_path !== '' ? $current_path . '/' . $name : $name;

					// Rozpoznaj priečinok podľa FTP typu (ak sa dá)
					if (!str_contains($name, '.')) $is_dir = true;
					?>

					<tr>
						<td><?= $is_dir ? '📁' : '📄' ?></td>
						<td>
							<?php if ($is_dir): ?>
								<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($next_path)) ?>">
									<strong><?= htmlspecialchars($name) ?></strong>
								</a>
							<?php else: ?>
								<?= htmlspecialchars($name) ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>
		</div>
	<?php endif; ?>
</section>
