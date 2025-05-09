<div role="main" class="main">
	<?php if (!empty($sliders)): ?>
		<div class="slider-container">
			<?php foreach ($sliders as $index => $s): ?>
				<section class="section border-0 m-0 slider-section <?php echo $index === 0 ? 'active' : ''; ?>"
						 style="background-image: url('<?php echo base_url('uploads/sliders/' . $s->image); ?>'); background-size: cover; background-position: center;">

					<!-- Optional original text block in image -->
				</section>

				<!-- Čiara pod sliderom -->
				<hr style="margin: 0; border-top: 2px solid #fff;">

				<!-- Textová lišta pod sliderom -->
				<?php if (!empty($s->title) || !empty($s->name1) || !empty($s->name2) || !empty($s->name3)): ?>
					<a href="<?php echo !empty($s->button_link) ? $s->button_link : '#'; ?>" style="text-decoration: none;">
						<div style="
							background-color: <?php echo htmlspecialchars($s->bg_color); ?>;
							color: <?php echo htmlspecialchars($s->text_color); ?>;
							padding: 30px 15px;
							text-align: center;
							cursor: pointer;
							">
							<?php if (!empty($s->title)): ?>
								<h2 style="margin-bottom: 10px;"><?php echo $s->title; ?></h2>
							<?php endif; ?>
							<?php if (!empty($s->name1)): ?>
								<h4 style="margin-bottom: 5px;"><?php echo $s->name1; ?></h4>
							<?php endif; ?>
							<?php if (!empty($s->name2)): ?>
								<p style="margin-bottom: 5px;"><?php echo $s->name2; ?></p>
							<?php endif; ?>
							<?php if (!empty($s->name3)): ?>
								<p style="margin-bottom: 0;"><?php echo $s->name3; ?></p>
							<?php endif; ?>
						</div>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
