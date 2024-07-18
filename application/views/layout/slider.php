<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<div class="slider-container">
			<?php foreach ($sliders as $index => $s): ?>
				<?php
				$hasText = !empty($s->name1) || !empty($s->name2) || !empty($s->name3);
				?>
				<section class="section border-0 m-0 slider-section <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo base_url('uploads/sliders/' . $s->image); ?>'); background-size: auto; background-position: center; background-repeat: no-repeat;">
					<div style="float:<?=$s->float?>" class="container h-100 d-flex align-items-center justify-content-center">
						<?php if ($hasText): ?>
							<div class="text-background">
								<?php if (!empty($s->name1)): ?>
									<h1 class="text-color-dark text-5 line-height-5 font-weight-semibold px-4 mb-2 appear-animation" data-appear-animation="fadeInDownShorterPlus" data-plugin-options="{'minWindowWidth': 0}">
										<span class="position-absolute right-100pct top-50pct transform3dy-n50"></span>
										<?php echo $s->name1; ?>
										<span class="position-absolute left-100pct top-50pct transform3dy-n50"></span>
									</h1>
								<?php endif; ?>
								<?php if (!empty($s->name2)): ?>
									<h1 class="text-color-dark font-weight-extra-bold text-6 mb-3 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="1000" data-plugin-options="{'minWindowWidth': 0}"><?php echo $s->name2; ?></h1>
								<?php endif; ?>
								<?php if (!empty($s->name3)): ?>
									<p class="text-5 text-color-dark font-weight-light mb-0" data-plugin-animated-letters data-plugin-options="{'startDelay': 2000, 'minWindowWidth': 0}"><?php echo $s->name3; ?></p>
								<?php endif; ?>
								<?php if (!empty($s->button_text) && !empty($s->button_link)): ?>
									<a href="<?php echo $s->button_link; ?>" class="btn btn-success mt-3 animate__animated"><?php echo $s->button_text; ?></a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</section>
			<?php endforeach; ?>
			<div class="slider-navigation">
				<span class="prev">&#10094;</span>
				<span class="next">&#10095;</span>
			</div>
		</div>
	<?php endif; ?>
</div>
