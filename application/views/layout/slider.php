<section class="section border-0 m-0" style="background-size: cover; background-position: center; height: 600px;">
	<div class="container h-100">
		<div class="row align-items-center h-100">
			<div class="col">
				<div class="d-flex flex-column align-items-center justify-content-center h-100">
					<?php foreach ($sliders as $slider): ?>
						<div class="slider-item" style="background-image: url(<?= base_url('uploads/sliders/') . $slider->image ?>); background-size: cover; background-position: center; height: 600px;">
							<h1 class="position-relative text-color-dark text-5 line-height-5 font-weight-semibold px-4 mb-2 appear-animation" data-appear-animation="fadeInDownShorterPlus" data-plugin-options="{'minWindowWidth': 0}">
                                <span class="position-absolute right-100pct top-50pct transform3dy-n50">
                                    <img src="<?= base_url('img/slides/slide-title-border-light.png') ?>" class="w-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                </span>
								<?= $slider->title_line1 ?>
								<span class="position-absolute left-100pct top-50pct transform3dy-n50">
                                    <img src="<?= base_url('img/slides/slide-title-border-light.png') ?>" class="w-auto appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                </span>
							</h1>
							<h1 class="text-color-dark font-weight-extra-bold text-12 mb-3 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="1000" data-plugin-options="{'minWindowWidth': 0}"><?= $slider->title_line2 ?></h1>
							<p class="text-4 text-color-dark font-weight-light mb-0" data-plugin-animated-letters data-plugin-options="{'startDelay': 2000, 'minWindowWidth': 0}"><?= $slider->subtitle ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
