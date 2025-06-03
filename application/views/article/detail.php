<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3"><?= htmlspecialchars($article->title) ?></h1>
				<?php if (!empty($article->subtitle)): ?>
					<p class="text-muted lead mb-0"><?= htmlspecialchars($article->subtitle) ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<div class="container py-5">
	<?php if (!empty(trim($article->title))): ?>
		<div class="content mb-5">
			<?= $article->content ?>
		</div>
	<?php else: ?>
		<p class="text-muted">Für diesen Artikel ist kein Inhalt verfügbar.</p>
	<?php endif; ?>

	<?php if (!empty($sections)): ?>
		<?php foreach ($sections as $section): ?>
			<div class="row align-items-center mb-5">
				<div class="col-lg-8">
					<div class="section-content">
						<?= $section->content ?>
					</div>

					<?php if (!empty($section->button_name)): ?>
						<?php
						$btnLink = !empty($section->subpage)
							? base_url($section->subpage)
							: (!empty($section->external_url) ? $section->external_url : '#');
						?>
						<a href="<?= $btnLink ?>" class="btn btn-success mt-3" <?= strpos($btnLink, 'http') === 0 ? 'target="_blank"' : '' ?>>
							<?= htmlspecialchars($section->button_name) ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if (!empty($section->image)): ?>
					<div class="col-lg-4 text-center">
						<img src="<?= base_url($section->image) ?>" alt="<?= htmlspecialchars($section->image_title ?? 'STYX Webimage section') ?>" class="img-fluid rounded shadow-sm" style="max-width: 250px;">
					</div>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
