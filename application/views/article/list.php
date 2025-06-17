<section class="container py-5">
	<?php foreach ($articles as $a): ?>
		<div class="row align-items-center mb-5">
			<div class="col-md-8">
				<h4 class="fw-bold"><?= htmlspecialchars($a->title) ?></h4>
				<p><?= strip_tags($a->subtitle) ?></p>
				<a href="<?= base_url($a->slug . '/' . remove_diacritics($a->slug_title)) ?>" class="btn btn-success">Mehr lesen >></a>
			</div>

			<?php if (!empty($a->image)): ?>
				<div class="col-md-4 text-end">
					<img src="<?= base_url($a->image) ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($a->image_title ?? $a->title) ?>" style="max-width: 200px;">
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</section>
