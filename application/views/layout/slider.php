<div role="main" class="main">
	<?php
	$current_language = language();

	function get_sliders_for_language($lang) {
		$CI = get_instance();
		$CI->db->where('lang', $lang);
		$CI->db->where('active', '1');
		return $CI->db->get('slider')->result();
	}

	$sliders = get_sliders_for_language($current_language);

	if (empty($sliders) && $current_language === 'en') {
		$sliders = get_sliders_for_language('de');
	}
	?>

	<?php if (!empty($sliders)): ?>
		<section class="slider-container" role="region" aria-label="<?= lang('SLIDER_STARTSEITE') ?>">
			<?php foreach ($sliders as $index => $s): ?>
				<div class="slider-wrapper <?= $index === 0 ? 'active' : '' ?>" role="group" aria-roledescription="slide" aria-label="<?= ($index + 1) . ' / ' . count($sliders) ?>">
					<div class="slider-section" style="background-image: url('<?= base_url('uploads/sliders/' . $s->image); ?>');" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
						<div class="slider-navigation">
							<button class="prev" aria-label="<?= lang('SLIDER_PREV') ?>">❮</button>
							<button class="next" aria-label="<?= lang('SLIDER_NEXT') ?>">❯</button>
						</div>
					</div>
					<?php $textColor = 'color:' . htmlspecialchars($s->text_color); ?>
					<a href="<?= !empty($s->button_link) ? $s->button_link : '#' ?>" style="text-decoration: none;">
						<div class="slider-text<?= (empty($s->title) && empty($s->name1) && empty($s->name2) && empty($s->name3)) ? ' empty' : ''; ?>"
							 style="background-color: <?= htmlspecialchars($s->bg_color); ?>;" tabindex="0">
							<?php if (!empty($s->title)): ?><h1 style="<?= $textColor ?>"><?= $s->title ?></h1><?php endif; ?>
							<?php if (!empty($s->name1)): ?><h3 style="<?= $textColor ?>"><?= $s->name1 ?></h3><?php endif; ?>
							<?php if (!empty($s->name2)): ?><h4 style="<?= $textColor ?>"><?= $s->name2 ?></h4><?php endif; ?>
							<?php if (!empty($s->name3)): ?><p style="<?= $textColor ?>"><?= $s->name3 ?></p><?php endif; ?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
</div>
