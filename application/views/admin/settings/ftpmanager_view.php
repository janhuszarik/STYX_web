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
	<div id="ftpContent">
		<!-- sem sa cez JS načíta zoznam súborov AJAX-om -->
	</div>
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
<script>
	function loadFolder(path = '') {
		// Zobraz loading hlášku ešte pred načítaním
		$('#ftpContent').html('<p>🔄 Načítavam...</p>');

		$.post('<?= base_url('admin/ftpmanager/ajax_list') ?>', { path }, function(response) {
			if (response.__error) {
				$('#ftpContent').html('<div class="alert alert-danger">' + response.__error + '</div>');
			} else {
				let html = '<p><i class="fas fa-folder-open"></i> <strong>Aktuálna cesta:</strong> ' + (path || '/') + '</p>';
				html += '<table class="table table-bordered"><thead><tr><th>Typ</th><th>Názov</th></tr></thead><tbody>';
				if (path) {
					let parent = path.split('/').slice(0, -1).join('/');
					html += `<tr><td>🔙</td><td><a href="#" onclick="loadFolder('${parent}'); return false;"><em>Späť</em></a></td></tr>`;
				}
				response.forEach(file => {
					let isDir = !file.includes('.');
					let next = path ? path + '/' + file : file;
					if (isDir) {
						html += `<tr><td>📁</td><td><a href="#" onclick="loadFolder('${next}'); return false;"><strong>${file}</strong></a></td></tr>`;
					} else {
						html += `<tr><td>📄</td><td>${file}</td></tr>`;
					}
				});
				html += '</tbody></table>';
				$('#ftpContent').html(html);
			}
		}, 'json');
	}

</script>


