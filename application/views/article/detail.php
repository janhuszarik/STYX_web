<?php if (empty($article)): ?>
	<div class="container py-5 text-center" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
		<h2 class="text-danger fw-bold mb-3">Diese Unterseite wird gerade überarbeitet</h2>
		<p>Na tejto podstránke sa aktuálne pracuje, alebo je v procese aktualizácie.<br>
			Prejdite späť a vráťte sa neskôr. Ospravedlňujeme sa za zdržanie.</p>
	</div>
	<?php return; ?>
<?php endif; ?>
<?php
$this->load->view('partials/article_assets');
?>

<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
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

<div class="container py-5" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<?php if (!empty(trim($article->title))): ?>
		<div class="content mb-5">
			<?= $article->content ?>
		</div>
	<?php else: ?>
		<p class="text-muted">Für diesen Artikel ist kein Inhalt verfügbar.</p>
	<?php endif; ?>

	<?php if (!empty($sections)): ?>
		<?php foreach ($sections as $section): ?>
			<div class="row align-items-center mb-5 flex-column-reverse flex-lg-row text-center text-lg-start">
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
					<div class="col-lg-4 text-center mb-3 mb-lg-0">
						<img src="<?= base_url($section->image) ?>" alt="<?= htmlspecialchars($section->image_title ?? 'STYX Webimage section') ?>" class="img-fluid rounded section-img">
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<?php
$hasProducts = false;
for ($set = 1; $set <= 2; $set++) {
	for ($i = 1; $i <= 3; $i++) {
		if (!empty($article->{'product_set' . $set . '_product' . $i . '_name'}) || !empty($article->{'product_set' . $set . '_product' . $i . '_image'})) {
			$hasProducts = true;
			break 2;
		}
	}
}
?>

<?php if ($hasProducts): ?>
	<section class="recommended-products py-5 bg-light" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
		<div class="container">
			<div class="text-center mb-4">
				<h2 class="fw-bold">Empfohlene Produkte</h2>
			</div>

			<?php for ($set = 1; $set <= 2; $set++): ?>
				<div class="row justify-content-center row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-4">
					<?php for ($i = 1; $i <= 3; $i++): ?>
						<?php
						$prefix = "product_set{$set}_product{$i}_";
						$name = $article->{$prefix . 'name'} ?? '';
						$desc = $article->{$prefix . 'description'} ?? '';
						$url = $article->{$prefix . 'url'} ?? '';
						$img = $article->{$prefix . 'image'} ?? '';
						$alt = $article->{$prefix . 'image_title'} ?? '';

						if (empty($name) && empty($img)) continue;
						if (!empty($url) && !preg_match('#^https?://#', $url)) {
							$url = 'https://' . ltrim($url, '/');
						}
						$target = (strpos($url, 'http') === 0) ? 'target="_blank" rel="noopener"' : '';
						?>
						<div class="col">
							<a href="<?= htmlspecialchars($url ?: '#') ?>" class="text-decoration-none text-dark d-block h-100" <?= $target ?>>
								<div class="card border-0 shadow-sm h-100">
									<?php if (!empty($img)): ?>
										<img src="<?= base_url($img) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($alt) ?>" title="<?= htmlspecialchars($alt) ?>">
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
			<?php endfor; ?>
		</div>
	</section>
<?php endif; ?>

<?php
$interessierenLinks = [];
for ($i = 1; $i <= 3; $i++) {
	$name = $article->{'empfohlen_name' . $i} ?? '';
	$url  = $article->{'empfohlen_url' . $i} ?? '';
	if (!empty($name) && !empty($url)) {
		if (!preg_match('#^https?://#', $url)) {
			$url = 'https://' . ltrim($url, '/');
		}
		$interessierenLinks[] = ['name' => $name, 'url' => $url];
	}
}
?>

<?php if (!empty($interessierenLinks)): ?>
	<section class="related-articles py-5" style="background-color: #f0faf3; border-top: 1px solid #dee2e6; font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
		<div class="container">
			<div class="text-center mb-4">
				<h3 class="fw-bold mb-2">DAS KÖNNTE SIE INTERESSIEREN</h3>
				<p class="text-muted mb-4">Entdecken Sie weitere Inhalte, die für Sie von Interesse sein könnten – spannende Themen, verwandte Angebote und mehr.</p>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<ul class="list-unstyled">
						<?php foreach ($interessierenLinks as $link): ?>
							<li class="mb-2">
								<a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener" class="text-decoration-none text-success fw-semibold">
									<i class="fas fa-angle-right me-2"></i> <?= htmlspecialchars($link['name']) ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if (!empty($galleryImages)): ?>
	<section class="article-gallery py-5" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
		<div class="container">
			<div class="text-center mb-4">
				<h2 class="fw-bold">Galerie</h2>
				<p class="text-muted">In dieser Galerie finden Sie weitere Bilder zum Thema.</p>
			</div>
			<div class="row g-4">
				<?php foreach ($galleryImages as $image): ?>
					<?php
					$fullImg = base_url($image->image_path);
					$thumbImg = preg_replace('/(\.\w+)$/', '_thumb$1', $image->image_path);
					$thumbPath = base_url($thumbImg);
					?>
					<div class="col-6 col-sm-4 col-md-3">
						<img src="<?= $thumbPath ?>" alt="Galerie Bild" class="img-fluid rounded shadow-sm w-100 gallery-thumb" style="object-fit:cover; aspect-ratio: 4/3;" data-full="<?= $fullImg ?>">
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
	<div id="lightbox-modal" class="lightbox-modal" style="display:none;">
		<span class="lightbox-close" onclick="closeLightbox()">&times;</span>
		<img class="lightbox-content" id="lightbox-img" src="" alt="Vollbild">
	</div>






