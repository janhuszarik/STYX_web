

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
	<section id="our_best_sellers_1">
		<div class="pt-14 pb-14 pt-lg-19 pb-lg-16">
			<div class="container container-xxl mb-13 d-xl-flex">
				<div class="flex-grow-1 text-left" data-animate="fadeInUp">
					<h2 class="mb-5">Our Bestsellers</h2>
					<p class="fs-18px mb-0 mw-xl-40 mw-lg-50 mw-md-75">
						Looking for something specific? Shop by category to find your perfect piece of jewellery!
					</p>
				</div>
			</div>
			<div class="container-fluid mb-4">
				<div class="slick-slider our-best-seller-4" data-slick-options='{"arrows":true,"centerMode":true,"centerPadding":"calc((100% - 1440px) / 2)","dots":true,"infinite":true,"responsive":[{"breakpoint":1200,"settings":{"arrows":false,"dots":false,"slidesToShow":3}},{"breakpoint":992,"settings":{"arrows":false,"dots":false,"slidesToShow":2}},{"breakpoint":576,"settings":{"arrows":false,"dots":false,"slidesToShow":1}}],"slidesToShow":4}'>
					<?php foreach ($product as $product_item): ?>
						<div data-animate="fadeInUp">
							<div class="card card-product grid-1 bg-transparent border-0">
								<figure class="card-img-top position-relative mb-7 overflow-hidden">
									<a href="<?= $product_item->url ?>" class="hover-zoom-in d-block" title="<?= $product_item->name ?>">
										<img src="<?= BASE_URL ?>uploads/product/<?= $product_item->image ?>" class="img-fluid lazy-image w-100" alt="<?= $product_item->name ?>" width="330" height="440">
									</a>
									<?php if ($product_item->action == 1): ?>
										<div class="position-absolute product-flash z-index-2">
											<span class="badge badge-product-flash on-sale bg-primary">Rabatt <?= !empty($product_item->price) ? ' / ' . $product_item->price : '' ?></span>
										</div>
									<?php endif; ?>
									<div class="position-absolute d-flex z-index-2 product-actions horizontal">
										<a class="text-body-emphasis bg-body bg-dark-hover text-light-hover rounded-circle square product-action shadow-sm add_to_cart" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
											<svg class="icon icon-shopping-bag-open-light">
												<use xlink:href="#icon-shopping-bag-open-light"></use>
											</svg>
										</a>
										<a class="text-body-emphasis bg-body bg-dark-hover text-light-hover rounded-circle square product-action shadow-sm quick-view" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Quick View">
										<span data-bs-toggle="modal" data-bs-target="#quickViewModal" class="d-flex align-items-center justify-content-center">
											<svg class="icon icon-eye-light">
												<use xlink:href="#icon-eye-light"></use>
											</svg>
										</span>
										</a>
										<a class="text-body-emphasis bg-body bg-dark-hover text-light-hover rounded-circle square product-action shadow-sm wishlist" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Wishlist">
											<svg class="icon icon-star-light">
												<use xlink:href="#icon-star-light"></use>
											</svg>
										</a>
										<a class="text-body-emphasis bg-body bg-dark-hover text-light-hover rounded-circle square product-action shadow-sm compare" href="./shop/compare.html" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Compare">
											<svg class="icon icon-arrows-left-right-light">
												<use xlink:href="#icon-arrows-left-right-light"></use>
											</svg>
										</a>
									</div>
								</figure>
								<div class="card-body text-center p-0">
								<span class="d-flex align-items-center price text-body-emphasis fw-bold justify-content-center mb-3 fs-6">
									<?php if (!empty($product_item->old_price)): ?>
										<del class="text-body fw-500 me-4 fs-13px"><?= $product_item->old_price ?></del>
									<?php endif; ?>
									<ins class="text-decoration-none"><?= $product_item->price ?></ins>
								</span>
									<h4 class="product-title card-title text-primary-hover text-body-emphasis fs-15px fw-500 mb-3">
										<a class="text-decoration-none text-reset" href="<?= $product_item->url ?>"><?= $product_item->name ?></a>
									</h4>
									<div class="d-flex align-items-center fs-12px justify-content-center">
										<div class="rating">
											<div class="empty-stars">
												<?php for ($i = 0; $i < 5; $i++): ?>
													<span class="star">
													<svg class="icon star-o">
														<use xlink:href="#star-o"></use>
													</svg>
												</span>
												<?php endfor; ?>
											</div>
											<div class="filled-stars" style="width: <?= $product_item->rating_percentage ?>%">
												<?php for ($i = 0; $i < 5; $i++): ?>
													<span class="star">
													<svg class="icon star text-primary">
														<use xlink:href="#star"></use>
													</svg>
												</span>
												<?php endfor; ?>
											</div>
										</div>
										<span class="reviews ms-4 pt-3 fs-14px"><?= $product_item->reviews_count ?> reviews</span>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

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
	<style>
		.outer-card {
			padding: 5px; /* Priestor okolo vnútorných kariet */
			border-radius: 8px; /* Zaoblené rohy pre vonkajšiu kartu */
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Jemný tieň pre lepší vzhľad */
		}

		.inner-card .card {
			border-radius: 0; /* Odstránime zaoblené rohy vnútorných kariet */
			margin-bottom: 0; /* Odstránime spodný okraj prvej vnútornej karty */
		}

		.inner-card .card:first-child {
			border-bottom-left-radius: 0; /* Odstránime dolné ľavé zaoblenie prvej vnútornej karty */
			border-bottom-right-radius: 0; /* Odstránime dolné pravé zaoblenie prvej vnútornej karty */
		}

		.inner-card .card:last-child {
			border-top-left-radius: 0; /* Odstránime horné ľavé zaoblenie druhej vnútornej karty */
			border-top-right-radius: 0; /* Odstránime horné pravé zaoblenie druhej vnútornej karty */
			margin-top: -1px; /* Prekryjeme horný okraj druhej vnútornej karty */
		}

		.d-flex.justify-content-between > .card-wrapper {
			margin-right: 1rem; /* Pridáme medzeru medzi kartami */
		}

		.d-flex.justify-content-between > .card-wrapper:last-child {
			margin-right: 0; /* Posledná karta nemá pravý margin */
		}



	</style>
	<div class="container">
		<div class="d-flex justify-content-between">
			<div class="card-wrapper col-md-6 col-lg-5 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="outer-card card">
					<div class="inner-card">
						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-4 d-flex align-items-center justify-content-center">
									<img src="<?=BASE_URL.'img/webImage/naturcosmeticImage.jpg'?>" class="img-fluid rounded-start" alt="...">
								</div>
								<div class="col-lg-8">
									<div class="card-body">
										<h4 class="card-title mb-1 text-7 font-weight-bold">NATURCOSMETIC</h4>
										<a href="/" class="read-more text-color-primary font-weight-semibold text-2">Read More <i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-8">
									<div class="card-body">
										<h4 class="card-title mb-1 text-4 font-weight-bold"></h4>
										<p class="card-text mb-2">Naturkosmetik aus Österreich. Viele zertifizierte und vegane Produkte.</p>
									</div>
								</div>
								<div class="col-lg-4 d-flex align-items-center justify-content-center">
									<img src="<?=BASE_URL.'img/webImage/greenLogo.jpg'?>" class="img-fluid rounded-start" alt="...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card-wrapper col-md-6 col-lg-5 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="outer-card card">
					<div class="inner-card">
						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-4 d-flex align-items-center justify-content-center">
									<img src="<?=BASE_URL.'img/webImage/naturcosmeticImage.jpg'?>" class="img-fluid rounded-start" alt="...">
								</div>
								<div class="col-lg-8">
									<div class="card-body">
										<h4 class="card-title mb-1 text-7 font-weight-bold">NATURCOSMETIC</h4>
										<a href="/" class="read-more text-color-primary font-weight-semibold text-2">Read More <i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-8">
									<div class="card-body">
										<h4 class="card-title mb-1 text-4 font-weight-bold"></h4>
										<p class="card-text mb-2">Naturkosmetik aus Österreich. Viele zertifizierte und vegane Produkte.</p>
									</div>
								</div>
								<div class="col-lg-4 d-flex align-items-center justify-content-center">
									<img src="<?=BASE_URL.'img/webImage/greenLogo.jpg'?>" class="img-fluid rounded-start" alt="...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
