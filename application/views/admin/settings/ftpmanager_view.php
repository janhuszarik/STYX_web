<h2>Obsah FTP priečinka</h2>
<ul>
	<?php if (!empty($files) && is_array($files)): ?>
		<?php foreach ($files as $file): ?>
			<li><?= htmlspecialchars($file) ?></li>
		<?php endforeach; ?>
	<?php else: ?>
		<li>Žiadne súbory alebo chyba pri načítaní.</li>
	<?php endif; ?>
</ul>
