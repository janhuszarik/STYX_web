<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<div class="slider-container">
			<?php foreach ($sliders as $index => $s): ?>
				<div class="slider-wrapper <?= $index === 0 ? 'active' : '' ?>">

					<!-- Obrázkový slider -->
					<div class="slider-section" style="background-image: url('<?= base_url('uploads/sliders/' . $s->image); ?>');">
						<!-- Navigácia -->
						<div class="slider-navigation">
							<span class="prev">❮</span>
							<span class="next">❯</span>
						</div>
					</div>

					<!-- Textová lišta POD sliderom -->
					<?php $textColor = 'color:' . htmlspecialchars($s->text_color); ?>
					<a href="<?= !empty($s->button_link) ? $s->button_link : '#' ?>" style="text-decoration: none;">
						<div class="slider-text<?= (empty($s->title) && empty($s->name1) && empty($s->name2) && empty($s->name3)) ? ' empty' : ''; ?>"
							 style="background-color: <?= htmlspecialchars($s->bg_color); ?>;">
							<?php if (!empty($s->title)): ?><h2 style="<?= $textColor ?>"><?= $s->title ?></h2><?php endif; ?>
							<?php if (!empty($s->name1)): ?><h3 style="<?= $textColor ?>"><?= $s->name1 ?></h3><?php endif; ?>
							<?php if (!empty($s->name2)): ?><p style="<?= $textColor ?>"><?= $s->name2 ?></p><?php endif; ?>
							<?php if (!empty($s->name3)): ?><p style="<?= $textColor ?>"><?= $s->name3 ?></p><?php endif; ?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
