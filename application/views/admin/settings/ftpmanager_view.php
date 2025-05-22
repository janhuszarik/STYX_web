<section role="main" class="content-body">
	<header class="page-header">
		<h2>FTP Zoznam súborov</h2>
	</header>

	<?php if (isset($files['__error'])): ?>
		<div class="alert alert-danger">
			❌ <?= $files['__error'] ?>
		</div>
	<?php elseif (empty($files)): ?>
		<div class="alert alert-warning">
			⚠️ Žiadne záznamy.
		</div>
	<?php else: ?>
		<ul class="list-unstyled">
			<?php foreach ($files as $file): ?>
				<?php if ($file === '.' || $file === '..') continue; ?>
				<li>
					<?php if (str_ends_with($file, '/')): ?>
						<a href="<?= base_url('admin/ftpmanager?path=' . urlencode($file)) ?>">
							<strong>📁 <?= htmlspecialchars($file) ?></strong>
						</a>
					<?php else: ?>
						📄 <?= htmlspecialchars($file) ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
