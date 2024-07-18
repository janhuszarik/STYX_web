


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


	<div class="container py-5 my-4">
		<div class="row text-center py-3">
			<div class="col-md-10 mx-md-auto">
				<h1 class="word-rotator slide font-weight-bold text-8 mb-3 appear-animation" data-appear-animation="fadeInUpShorter">
					<span>Porto is </span>
					<span class="word-rotator-words bg-primary">
									<b class="is-visible">incredibly</b>
									<b>especially</b>
									<b>extremely</b>
								</span>
					<span> beautiful and fully responsive.</span>
				</h1>
				<p class="lead appear-animation mb-0" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu, ac tincidunt mauris lacus sed leo.
				</p>
			</div>
		</div>
	</div>

	<section class="section section-height-5 bg-primary border-0 pt-5 m-0 appear-animation" data-appear-animation="fadeIn">
		<div class="container">
			<div class="row mt-4 mt-lg-5">
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-support text-color-primary text-6"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="text-color-light font-weight-bold text-4 line-height-5 mb-1">CUSTOMER SUPPORT</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit <span class="alternative-font text-color-light">amet</span>, consectetur adipiscing elit. Praesent tincidunt pretium vulputate.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInUpShorter">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-layers text-color-primary text-6"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="font-weight-bold text-color-light text-4 line-height-5 mb-1">SLIDERS</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget pretium purus.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-menu text-color-primary text-5"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="font-weight-bold text-color-light text-4 line-height-5 mb-1">BUTTONS</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vel magna fringilla.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-lg-4">
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-doc text-color-primary text-5"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="font-weight-bold text-color-light text-4 line-height-5 mb-1">HTML5 / CSS3 / JS</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis dignissim ante eleifend.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInUpShorter">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-user text-color-primary text-5"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="font-weight-bold text-color-light text-4 line-height-5 mb-1">ICONS</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit <span class="alternative-font text-color-light">amet</span>, consectetur adipiscing elit. Praesent consequat pharetra massa.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
					<div class="feature-box">
						<div class="feature-box-icon feature-box-icon-large bg-light mt-1">
							<i class="icons icon-screen-desktop text-color-primary text-6"></i>
						</div>
						<div class="feature-box-info">
							<h2 class="font-weight-bold text-color-light text-4 line-height-5 mb-1">LIGHTBOX</h2>
							<p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum aliquet erat.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section bg-color-grey-scale-1 border-0 pt-0 pt-md-5 m-0">
		<div class="container">
			<div class="row align-items-center justify-content-center pb-4 pb-lg-0">
				<div class="col-lg-6 order-2 order-lg-1 pe-5 pt-4 pt-lg-0 mt-md-5 mt-lg-0 appear-animation" data-appear-animation="fadeInRightShorter">
					<h2 class="font-weight-normal text-6 mb-3"><strong class="font-weight-extra-bold">Who</strong> We Are</h2>
					<p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id valorem ipsum dolor sit amet, consectetur adipiscinorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					<p class="pb-2 mb-4">Phasellus blandit massa enim. Nullam id varius elit. blandit massa enimariusius.</p>
					<a href="#" class="btn btn-dark font-weight-semibold btn-py-2 px-5">Our History</a>
				</div>
				<div class="col-9 col-lg-6 order-1 order-lg-2 scale-6 pb-5 pb-lg-0 mt-0 mt-md-4 mb-5 mb-lg-0">
					<img class="img-fluid appear-animation" src="img/desktop-device-1.png" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300" data-plugin-options="{'accY': -400}" alt="">
				</div>
			</div>
		</div>
	</section>

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
