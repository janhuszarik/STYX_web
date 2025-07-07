<?php
$this->load->view('partials/article_list_assets');
?>

<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3"><?= $title ?></h1>
				<p class="text-muted lead mb-0"><?= htmlspecialchars($description) ?></p>
			</div>
		</div>
	</div>
</section>
<div style="margin-bottom: 50px;"></div>

<?php if ($category->id == 100): ?>
	<div class="container mb-3">
		<p class="text-left">
			Unter dieser Rubrik werden Sie über alle wichtigen Neuigkeiten aus unserem Hause informiert.
			Ob Veranstaltungen, Messeberichte, Tipps und Tricks zum Thema Kosmetik oder Aktuelles aus unserer breiten Produktpalette,
			wir halten Sie mit allem rund um STYX auf dem neuesten Stand!
		</p>
	</div>
<?php endif; ?>

<?php if (!empty($subcategories)): ?>
	<div class="container">
		<div class="subcategory-buttons">
			<a href="<?= base_url($category->slug) ?>" class="btn btn-success <?= empty($selectedSubcategory) ? 'active' : '' ?>">
				Alle anzeigen
			</a>
			<?php foreach ($subcategories as $sub): ?>
				<a href="<?= base_url($category->slug) . '?sub=' . $sub->id ?>" class="btn btn-success <?= ($selectedSubcategory == $sub->id) ? 'active' : '' ?>">
					<?= htmlspecialchars($sub->name) ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

<section class="container py-5">
	<?php if ($noArticles): ?>
		<div class="alert alert-info text-center">
			<strong>Aktuell gibt es in diesem Bereich keine Artikel.</strong><br>
			Bitte versuchen Sie es mit einer anderen Kategorie.
		</div>
	<?php else: ?>
		<?php foreach ($articles as $a): ?>
			<div class="article-list-row">
				<?php if (!empty($a->image)): ?>
					<div class="article-list-img">
						<img src="<?= base_url($a->image) ?>"
							 class="img-fluid rounded shadow-sm"
							 alt="<?= htmlspecialchars($a->image_title ?? $a->title) ?>">
					</div>
				<?php endif; ?>
				<div class="article-list-text">
					<h4 class="fw-bold"><?= htmlspecialchars($a->title) ?></h4>
					<p><?= strip_tags($a->subtitle) ?></p>
					<a href="<?= base_url($a->slug . '/' . remove_diacritics($a->slug_title)) ?>" class="btn btn-success">Mehr lesen >></a>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</section>


