<h2>Obsah FTP priečinka</h2>
<ul>
	<?php foreach ($files as $file): ?>
		<li><?= htmlspecialchars($file) ?></li>
	<?php endforeach; ?>
</ul>


