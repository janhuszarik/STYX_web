<div class="container py-5">
	<h1><?= htmlspecialchars($article->title) ?></h1>

	<?php if (!empty(trim($article->content))): ?>
		<div class="content">
			<?= $article->content ?>
		</div>
	<?php else: ?>
		<p class="text-muted">Für diesen Artikel ist kein Inhalt verfügbar.</p>
	<?php endif; ?>
</div>


