<?php
$this->load->view('partials/slider_assets');
?>
<div role="main" class="main">
		<?php if (!empty($sliders)): ?>
		<section class="slider-container" role="region" aria-label="<?= lang('SLIDER_STARTSEITE') ?>">
			<?php foreach ($sliders as $index => $s): ?>
				<div class="slider-wrapper <?= $index === 0 ? 'active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= ($index + 1) . ' / ' . count($sliders) ?>">
					<div class="slider-section" style="background-image: url('<?= base_url('uploads/Sliders/' . $s->image); ?>');" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
						<div class="slider-navigation">
							<button class="prev" aria-label="<?= lang('SLIDER_PREV') ?>">❮</button>
							<button class="next" aria-label="<?= lang('SLIDER_NEXT') ?>">❯</button>
						</div>
					</div>
					<?php $textColor = 'color:' . htmlspecialchars($s->text_color); ?>
					<a href="<?= !empty($s->button_link) ? $s->button_link : '#' ?>" style="text-decoration: none;">
						<div class="slider-text<?= (empty($s->title) && empty($s->name2)) ? ' empty' : ''; ?>"
							 style="background-color: <?= htmlspecialchars($s->bg_color); ?>;" tabindex="0">
							<?php if (!empty($s->title)): ?><h1 style="<?= $textColor ?>"><?= $s->title ?></h1><?php endif; ?>
							<?php if (!empty($s->name2)): ?><h4 style="<?= $textColor ?>"><?= $s->name2 ?></h4><?php endif; ?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
			<div class="slider-controls">
				<div class="progress-ring">
					<svg>
						<circle class="progress-ring-bg" cx="30" cy="30" r="22" />
						<circle class="progress-ring-circle" cx="30" cy="30" r="22" />
					</svg>
					<button id="pauseBtn" aria-label="Pause slider">⏸️</button>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>





