<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<div class="slider-container">
			<?php foreach ($sliders as $index => $s): ?>
				<div class="slider-wrapper <?= $index === 0 ? 'active' : '' ?>">

					<!-- Obrázkový slider -->
					<div class="slider-section" style="background-image: url('<?php echo base_url('uploads/sliders/' . $s->image); ?>');">
						<!-- Navigácia -->
						<div class="slider-navigation">
							<span class="prev">&#10094;</span>
							<span class="next">&#10095;</span>
						</div>
					</div>

					<!-- Textová lišta POD sliderom -->
					<a href="<?= !empty($s->button_link) ? $s->button_link : '#' ?>" style="text-decoration: none;">
						<div class="slider-text<?= (empty($s->title) && empty($s->name1) && empty($s->name2) && empty($s->name3)) ? ' empty' : ''; ?>"
							 style="background-color: <?= htmlspecialchars($s->bg_color); ?>; color: <?= htmlspecialchars($s->text_color); ?>;">
							<?php if (!empty($s->title)): ?><h2><?= $s->title ?></h2><?php endif; ?>
							<?php if (!empty($s->name1)): ?><h3><?= $s->name1 ?></h3><?php endif; ?>
							<?php if (!empty($s->name2)): ?><p><?= $s->name2 ?></p><?php endif; ?>
							<?php if (!empty($s->name3)): ?><p><?= $s->name3 ?></p><?php endif; ?>
						</div>
					</a>

				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const sliders = document.querySelectorAll('.slider-wrapper');
		let current = 0;

		const showSlide = (index) => {
			sliders.forEach((slide, i) => {
				slide.style.display = i === index ? 'block' : 'none';
			});
		};

		const nextSlide = () => {
			current = (current + 1) % sliders.length;
			showSlide(current);
		};

		const prevSlide = () => {
			current = (current - 1 + sliders.length) % sliders.length;
			showSlide(current);
		};

		document.querySelectorAll('.slider-navigation .next').forEach(btn => {
			btn.addEventListener('click', nextSlide);
		});
		document.querySelectorAll('.slider-navigation .prev').forEach(btn => {
			btn.addEventListener('click', prevSlide);
		});

		// Init first slide
		showSlide(current);

		// Auto change every 5 seconds
		setInterval(nextSlide, 5000);
	});
</script>
