<?php
if (!function_exists('ends_with')) {
	function ends_with($haystack, $needle) {
		return substr($haystack, -strlen($needle)) === $needle;
	}
}
$current_path = $current_path ?? '';
?>

<section role="main" class="content-body">
	<header class="page-header">
		<h2>FTP Zoznam súborov</h2>
	</header>

	<p><i class="fas fa-folder"></i> <strong>Aktuálna cesta:</strong> <?= htmlspecialchars($current_path) ?></p>

	<?php if (isset($files['__error'])): ?>
		<div class="alert alert-danger">❌ <?= $files['__error'] ?></div>
	<?php elseif (empty($files)): ?>
		<div class="alert alert-warning">⚠️ Žiadne záznamy.</div>
	<?php else: ?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead><tr><th style="width:50px;">Typ</th><th>Názov</th></tr></thead>
				<tbody>
				<?php foreach ($files as $file): ?>
					<?php
					$is_dir = substr($file, -1) === '/';
					$label = htmlspecialchars(trim(basename($file), '/'));
					$next_path = ($current_path !== '') ? $current_path . '/' . $label : $label;
					?>
					<tr>
						<td><?= $is_dir ? '📁' : '📄' ?></td>
						<td>
							<?php if ($is_dir): ?>
								<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($next_path)) ?>">
									<strong><?= $label ?></strong>
								</a>
							<?php else: ?>
								<?= $label ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</section>
