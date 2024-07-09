

<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<div class="slider-container">
			<?php foreach ($sliders as $index => $s): ?>
				<section class="section border-0 m-0 slider-section <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo base_url('uploads/sliders/' . $s->image); ?>'); background-size: auto; background-position: center; background-repeat: no-repeat;">
					<div class="container h-100 d-flex align-items-center justify-content-center">
						<div class="text-background">
							<?php if (!empty($s->name1)): ?>
								<h1 class="text-color-dark text-5 line-height-5 font-weight-semibold px-4 mb-2 appear-animation" data-appear-animation="fadeInDownShorterPlus" data-plugin-options="{'minWindowWidth': 0}">
                                    <span class="position-absolute right-100pct top-50pct transform3dy-n50">
                                        <img src="<?=BASE_URL?>assets/img/slides/slide-title-border-light.png" class="w-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="250" data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                    </span>
									<?php echo $s->name1; ?>
									<span class="position-absolute left-100pct top-50pct transform3dy-n50">
                                        <img src="<?=BASE_URL?>assets/img/slides/slide-title-border-light.png" class="w-auto appear-animation" data-appear-animation="fadeInLeftShorter" data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                    </span>
								</h1>
							<?php endif; ?>
							<?php if (!empty($s->name2)): ?>
								<h1 class="text-color-dark font-weight-extra-bold text-12 mb-3 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="1000" data-plugin-options="{'minWindowWidth': 0}"><?php echo $s->name2; ?></h1>
							<?php endif; ?>
							<?php if (!empty($s->name3)): ?>
								<p class="text-4 text-color-dark font-weight-light mb-0" data-plugin-animated-letters data-plugin-options="{'startDelay': 2000, 'minWindowWidth': 0}"><?php echo $s->name3; ?></p>
							<?php endif; ?>
							<?php if (!empty($s->button_text) && !empty($s->button_link)): ?>
								<a href="<?php echo $s->button_link; ?>" class="btn btn-success mt-3 animate__animated">
									<?php echo $s->button_text; ?>
								</a>
							<?php endif; ?>
						</div>
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



<style>

	.slider-container {
		position: relative;
		overflow: hidden;
		width: 100%;
		height: 800px; /* Adjust height as needed */
	}

	.slider-section {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
		transition: opacity 1s ease-in-out;
	}

	.slider-section.active {
		opacity: 1;
	}

	.slider-navigation {
		position: absolute;
		width: 100%;
		top: 50%;
		transform: translateY(-50%);
		display: flex;
		justify-content: space-between;
		z-index: 1000;
	}

	.slider-navigation .prev,
	.slider-navigation .next {
		background-color: rgba(0, 0, 0, 0.5);
		color: white;
		padding: 10px;
		cursor: pointer;
		user-select: none;
		font-size: 24px;
	}

	.text-background {
		background-color: rgba(255, 255, 255, 0.6); /* White with 60% opacity */
		border-radius: 20px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		padding: 32px;
		text-align: center;
		width: 80%; /* Fixed width */
		max-width: 800px; /* Optional: Maximum width */
		height: 200px; /* Fixed height */
		margin: 0 auto; /* Center the text container */
		position: relative; /* Ensure position-relative for the absolute children */
	}




</style>

<script>
	$(document).ready(function() {
		var slides = $('.slider-section');
		var currentIndex = 0;
		var slideInterval = setInterval(showNextSlide, 6000); // Change slide every 6 seconds

		function showNextSlide() {
			slides.eq(currentIndex).removeClass('active');
			currentIndex = (currentIndex + 1) % slides.length;
			slides.eq(currentIndex).addClass('active');
		}

		function showPrevSlide() {
			slides.eq(currentIndex).removeClass('active');
			currentIndex = (currentIndex - 1 + slides.length) % slides.length;
			slides.eq(currentIndex).addClass('active');
		}

		$('.next').click(function() {
			clearInterval(slideInterval);
			showNextSlide();
			slideInterval = setInterval(showNextSlide, 6000);
		});

		$('.prev').click(function() {
			clearInterval(slideInterval);
			showPrevSlide();
			slideInterval = setInterval(showNextSlide, 6000);
		});
	});




</script>
