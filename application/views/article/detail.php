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
<?php
// Over, či existuje aspoň jeden produkt s názvom alebo obrázkom
$hasProducts = false;
for ($i = 1; $i <= 3; $i++) {
	if (!empty($article->{'product_name' . $i}) || !empty($article->{'product_image' . $i})) {
		$hasProducts = true;
		break;
	}
}
?>

<?php if ($hasProducts): ?>
	<section class="recommended-products py-5 bg-light">
		<div class="container">
			<div class="text-center mb-4">
				<h2 class="fw-bold">Empfohlene Produkte</h2>
			</div>
			<div class="row justify-content-center row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
				<?php for ($i = 1; $i <= 3; $i++): ?>
					<?php
					$name = $article->{'product_name' . $i} ?? '';
					$desc = $article->{'product_description' . $i} ?? '';
					$url  = $article->{'product_url' . $i} ?? '';
					$img  = $article->{'product_image' . $i} ?? '';
					$alt  = $article->{'product_image' . $i . '_title'} ?? '';

					if (empty($name) && empty($img)) continue;

					// Úprava URL: ak nie je http/https, pridáme https://
					if (!empty($url) && !preg_match('#^https?://#', $url)) {
						$url = 'https://' . ltrim($url, '/');
					}
					$target = (strpos($url, 'http') === 0) ? 'target="_blank" rel="noopener"' : '';
					?>
					<div class="col">
						<a href="<?= htmlspecialchars($url ?: '#') ?>" class="text-decoration-none text-dark d-block h-100" <?= $target ?>>
							<div class="card border-0 shadow-sm h-100">
								<?php if (!empty($img)): ?>
									<img src="<?= base_url($img) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($alt) ?>" title="<?= htmlspecialchars($alt) ?>" style="max-width: 100%; height: auto;">
								<?php endif; ?>
								<div class="card-body">
									<h4 class="card-title mb-2"><?= htmlspecialchars($name) ?></h4>
									<?php if (!empty($desc)): ?>
										<p class="card-text"><?= htmlspecialchars($desc) ?></p>
									<?php endif; ?>
								</div>
								<div class="card-footer bg-transparent border-0 text-end pe-3">
									<div class="text-success fw-bold">...jetzt SHOPEN!</div>
								</div>


							</div>
						</a>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>
<?php endif; ?>



