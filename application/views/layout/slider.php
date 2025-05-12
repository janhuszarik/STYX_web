<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<section class="slider-container" role="region" aria-label="<?= lang('SLIDER_STARTSEITE') ?>">
			<?php foreach ($sliders as $index => $s): ?>
				<div class="slider-wrapper <?= $index === 0 ? 'active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= ($index + 1) . ' / ' . count($sliders) ?>">
					<div class="slider-section" style="background-image: url('<?= base_url('uploads/sliders/' . $s->image); ?>');" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
						<div class="slider-navigation">
							<button class="custom-prev" aria-label="Previous slide">‹</button>
							<button class="custom-next" aria-label="Next slide">›</button>

						</div>
					</div>
					<?php $textColor = 'color:' . htmlspecialchars($s->text_color); ?>
					<a href="<?= !empty($s->button_link) ? $s->button_link : '#' ?>" style="text-decoration: none;">
						<div class="slider-text<?= (empty($s->title) && empty($s->name1) && empty($s->name2) && empty($s->name3)) ? ' empty' : ''; ?>"
							 style="background-color: <?= htmlspecialchars($s->bg_color); ?>;" tabindex="0">
							<?php if (!empty($s->title)): ?><h2 style="<?= $textColor ?>"><?= $s->title ?></h2><?php endif; ?>
							<?php if (!empty($s->name1)): ?><h3 style="<?= $textColor ?>"><?= $s->name1 ?></h3><?php endif; ?>
							<?php if (!empty($s->name2)): ?><p style="<?= $textColor ?>"><?= $s->name2 ?></p><?php endif; ?>
							<?php if (!empty($s->name3)): ?><p style="<?= $textColor ?>"><?= $s->name3 ?></p><?php endif; ?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
</div>
