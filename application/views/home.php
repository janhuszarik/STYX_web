<div role="main" class="main">
	<div role="main" class="main">
		<div class="home-intro light border border-bottom-0 mb-0">
			<div class="container">
				<div class="row">
					<div class="col">
						<h1 style='font-weight: bolder' class="text-center"><?=lang('AKTUELL')?></h1>
						<div class="owl-carousel owl-theme show-nav-title show-nav-title-both-sides" data-plugin-options="{'items': 4, 'margin': 10, 'loop': false, 'nav': true, 'dots': false}">
							<?php foreach ($news as $news_item): ?>
								<div class="home-carousel-card" onclick="location.href='<?=$news_item->buttonUrl?>';" style="cursor: pointer;">
									<div class="home-carousel-img-container">
										<img alt="" class="img-fluid rounded" src="<?=BASE_URL?>uploads/news/<?=$news_item->image?>">
									</div>
									<div class="home-carousel-card-content">
										<h5><?=$news_item->name?></h5>
										<p><?=$news_item->name1?></p>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div role="main" class="main">
		<div class="home-intro light border border-bottom-0 mb-0">
			<div class="container">
				<div class="row">
					<div class="col">
						<h1 style='font-weight: bolder' class="text-center"><?=lang('PRODUCT_WEB')?></h1>
						<div class="owl-carousel owl-theme show-nav-title show-nav-title-both-sides" data-plugin-options="{'items': 6, 'margin': 10, 'loop': false, 'nav': true, 'dots': false}">
							<?php foreach ($product as $product_item): ?>
								<div class="home-carousel-card" onclick="location.href='<?=$product_item->url?>';" style="cursor: pointer;">
									<div class="home-carousel-img-container">
										<img alt="" class="img-fluid rounded" src="<?=BASE_URL?>uploads/product/<?=$product_item->image?>">
									</div>
									<div class="home-carousel-card-content-product">
										<h5><?=$product_item->name?></h5>
									</div>
									<?php if ($product_item->action == 1): ?>
										<div class="aktion-ribbon">
											<span>Rabatt <?php if (!empty($product_item->price)) { ?> / <?=$product_item->price?><?php } else { echo ''; } ?></span>
										</div>
									<?php endif; ?>

								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="container py-5 my-4">
		<div class="row text-center py-3">
			<div class="col-md-10 mx-md-auto">
				<h5 class="text-uppercase mt-4"><?=lang('FIRMA_LOGOS')?></h5>
				<div class="row"> <!-- Added row wrapper for list items -->
					<ul class="list-unstyled d-flex flex-wrap justify-content-center"> <!-- Flexbox utility classes for layout -->
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Adjusted column classes and margin for spacing -->
							<a class="lightbox" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?=BASE_URL.'img/webImage/staat.png'?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Adjusted column classes and margin for spacing -->
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?=BASE_URL.'img/webImage/eco-cert_start.png'?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Adjusted column classes and margin for spacing -->
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?=BASE_URL.'img/webImage/Bio-Austria_start.png'?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Adjusted column classes and margin for spacing -->
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?=BASE_URL.'img/webImage/top_rated_company_24.png'?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Adjusted column classes and margin for spacing -->
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?=BASE_URL.'img/webImage/trusted-shop_start.png'?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
					</ul>
					<p><?=lang('FIRMA_LOGOS_TEXT')?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="featured-boxes py-5 mt-5 mb-4">
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="featured-box featured-box-primary featured-box-effect-1">
						<div class="box-content">
							<i class="icon-featured icons icon-people"></i>
							<h3 class="text-color-primary font-weight-bold text-3 mb-2 mt-3">Loved by Customers</h3>
							<p class="px-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<p><a href="/" class="text-dark learn-more font-weight-bold text-2">VIEW MORE <i class="fas fa-chevron-right ms-2"></i></a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="featured-box featured-box-dark featured-box-effect-1">
						<div class="box-content">
							<i class="icon-featured icons icon-docs"></i>
							<h3 class="font-weight-bold text-3 mb-2 mt-3">Well Documented</h3>
							<p class="px-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<p><a href="/" class="text-dark learn-more font-weight-bold text-2">VIEW MORE <i class="fas fa-chevron-right ms-2"></i></a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="featured-box featured-box-primary featured-box-effect-1">
						<div class="box-content">
							<i class="icon-featured icons icon-trophy"></i>
							<h3 class="text-color-primary font-weight-bold text-3 mb-2 mt-3">Winner</h3>
							<p class="px-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<p><a href="/" class="text-dark learn-more font-weight-bold text-2">VIEW MORE <i class="fas fa-chevron-right ms-2"></i></a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="featured-box featured-box-dark featured-box-effect-1">
						<div class="box-content">
							<i class="icon-featured icons icon-equalizer"></i>
							<h3 class="font-weight-bold text-3 mb-2 mt-3">Customizable</h3>
							<p class="px-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<p><a href="/" class="text-dark learn-more font-weight-bold text-2">VIEW MORE <i class="fas fa-chevron-right ms-2"></i></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="section section-height-3 section-background border-0 m-0 appear-animation" data-appear-animation="fadeIn" style="background-image: url(img/parallax/parallax-10.jpg); background-size: cover; background-position: center;">
		<div class="container">
			<div class="row">
				<div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">

					<div class="owl-carousel owl-theme nav-bottom rounded-nav" data-plugin-options="{'items': 1, 'loop': false}">
						<div>
							<div class="testimonial testimonial-style-2 testimonial-with-quotes testimonial-quotes-dark mb-0">
								<div class="testimonial-author">
									<img src="img/clients/client-1.jpg" class="img-fluid rounded-circle" alt="">
								</div>
								<blockquote>
									<p class="text-color-dark text-5 line-height-5 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget risus porta, tincidunt turpis at, interdum tortor. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce ante tellus, convallis non consectetur sed, pharetra nec ex.</p>
								</blockquote>
								<div class="testimonial-author">
									<p><strong class="font-weight-extra-bold text-2">- John Smith. Okler</strong></p>
								</div>
							</div>
						</div>
						<div>
							<div class="testimonial testimonial-style-2 testimonial-with-quotes testimonial-quotes-dark mb-0">
								<div class="testimonial-author">
									<img src="img/clients/client-1.jpg" class="img-fluid rounded-circle" alt="">
								</div>
								<blockquote>
									<p class="text-color-dark text-5 line-height-5 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget risus porta, tincidunt turpis at, interdum tortor. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
								</blockquote>
								<div class="testimonial-author">
									<p><strong class="font-weight-extra-bold text-2">- John Smith. Okler</strong></p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

	<div class="container">
		<div class="row pt-5 mt-4">
			<div class="col">
				<h2 class="font-weight-normal text-6 mb-4"><strong class="font-weight-extra-bold">Latest</strong> Posts</h2>
			</div>
		</div>
		<div class="row recent-posts pb-5 mb-4">
			<div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
				<article>
					<div class="row">
						<div class="col-auto pe-0">
							<div class="date">
								<span class="day text-color-dark font-weight-extra-bold">15</span>
								<span class="month text-1">JAN</span>
							</div>
						</div>
						<div class="col ps-1">
							<h4 class="line-height-3 text-4"><a href="blog-post.html" class="text-dark">Lorem ipsum dolor sit amet, consectetur</a></h4>
							<p class="line-height-5 pe-4 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<a href="/" class="read-more text-color-dark font-weight-bold text-2">read more <i class="fas fa-chevron-right text-1 ms-1"></i></a>
						</div>
					</div>
				</article>
			</div>
			<div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
				<article>
					<div class="row">
						<div class="col-auto pe-0">
							<div class="date">
								<span class="day text-color-dark font-weight-extra-bold">14</span>
								<span class="month text-1">JAN</span>
							</div>
						</div>
						<div class="col ps-1">
							<h4 class="line-height-3 text-4"><a href="blog-post.html" class="text-dark">Lorem ipsum dolor sit amet, consectetur</a></h4>
							<p class="line-height-5 pe-4 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<a href="/" class="read-more text-color-dark font-weight-bold text-2">read more <i class="fas fa-chevron-right text-1 ms-1"></i></a>
						</div>
					</div>
				</article>
			</div>
			<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
				<article>
					<div class="row">
						<div class="col-auto pe-0">
							<div class="date">
								<span class="day text-color-dark font-weight-extra-bold">13</span>
								<span class="month text-1">JAN</span>
							</div>
						</div>
						<div class="col ps-1">
							<h4 class="line-height-3 text-4"><a href="blog-post.html" class="text-dark">Lorem ipsum dolor sit amet, consectetur</a></h4>
							<p class="line-height-5 pe-4 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<a href="/" class="read-more text-color-dark font-weight-bold text-2">read more <i class="fas fa-chevron-right text-1 ms-1"></i></a>
						</div>
					</div>
				</article>
			</div>
			<div class="col-md-6 col-lg-3">
				<article>
					<div class="row">
						<div class="col-auto pe-0">
							<div class="date">
								<span class="day text-color-dark font-weight-extra-bold">12</span>
								<span class="month text-1">JAN</span>
							</div>
						</div>
						<div class="col ps-1">
							<h4 class="line-height-3 text-4"><a href="blog-post.html" class="text-dark">Lorem ipsum dolor sit amet, consectetur</a></h4>
							<p class="line-height-5 pe-4 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
							<a href="/" class="read-more text-color-dark font-weight-bold text-2">read more <i class="fas fa-chevron-right text-1 ms-1"></i></a>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>
