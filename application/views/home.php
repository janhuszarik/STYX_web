<main role="main" class="main">
	<section class="home-intro light border border-bottom-0 mb-0" aria-labelledby="news-heading">
		<div class="container">
			<div class="row">
				<div class="col">
					
					<h1 id="news-heading" class="text-center font-weight-bold"><?= lang('AKTUELL') ?></h1>
					<div class="owl-carousel owl-theme show-nav-title show-nav-title-both-sides news-carousel"
						 role="region"
						 aria-roledescription="carousel"
						 aria-label="News carousel"
						 data-plugin-options="{'items': 4, 'margin': 10, 'loop': true, 'nav': true, 'dots': false, 'autoplay': false}">
						<?php foreach ($news as $news_item): ?>
							<?php
							$href = "";
							if (!empty($news_item->buttonUrl)) {
								$href = $news_item->buttonUrl;
							} elseif (!empty($news_item->id)) {
								$href = language() . "/news_article/" . $news_item->id;
							}
							?>
							<?php if (!empty($href)): ?>
								<article class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-lighten thumb-info-bottom-info thumb-info-bottom-info-custom thumb-info-bottom-info-show-more thumb-info-no-zoom">
									<a href="<?= $href ?>" aria-label="Read more about <?= htmlspecialchars($news_item->name) ?>">
                                        <span class="thumb-info-wrapper">
                                            <img src="<?= BASE_URL ?>uploads/news/<?= $news_item->image ?>"
												 class="img-fluid"
												 alt="<?= htmlspecialchars($news_item->name) ?>"
												 style="padding: 0 0 114px 0">
                                            <span class="thumb-info-title">
                                                <span class="thumb-info-inner line-height-5 text-4"><?= htmlspecialchars($news_item->name) ?></span>
                                                <hr class="thumb-info-hr" aria-hidden="true">
                                                <span class="thumb-info-inner home-carousel-card-custom"><?= htmlspecialchars($news_item->name1) ?></span>
                                            </span>
                                        </span>
									</a>
								</article>
							<?php else: ?>
								<article class="thumb-info thumb-info-no-borders thumb-info-no-borders-rounded thumb-info-lighten thumb-info-bottom-info thumb-info-bottom-info-custom thumb-info-bottom-info-show-more thumb-info-no-zoom">
                                    <span class="thumb-info-wrapper">
                                        <img src="<?= BASE_URL ?>uploads/news/<?= $news_item->image ?>"
											 class="img-fluid"
											 alt="<?= htmlspecialchars($news_item->name) ?>"
											 style="padding: 0 0 114px 0">
                                        <span class="thumb-info-title">
                                            <span class="thumb-info-inner line-height-5 text-4"><?= htmlspecialchars($news_item->name) ?></span>
                                            <hr class="thumb-info-hr" aria-hidden="true">
                                            <span class="thumb-info-inner home-carousel-card-custom"><?= htmlspecialchars($news_item->name1) ?></span>
                                        </span>
                                    </span>
								</article>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="row d-none d-lg-block" aria-labelledby="product-heading">
		<div class="col">
			<hr class="solid my-5" aria-hidden="true">
			<h1 id="product-heading" class="text-center font-weight-bold"><?= lang('PRODUCT_WEB') ?></h1>
		</div>
	</section>

	<section class="carousel-container d-none d-lg-block" aria-labelledby="product-heading">
		<div class="owl-carousel owl-theme full-width product-carousel"
			 role="region"
			 aria-roledescription="carousel"
			 aria-label="Product carousel"
			 data-plugin-options="{'items': 5, 'loop': true, 'dots': false, 'autoplay': true, 'autoplayTimeout': 5000, 'autoplayHoverPause': true}">
			<?php foreach ($product as $product_item): ?>
				<article>
					<a href="<?= $product_item->url ?>"
					   aria-label="View product: <?= htmlspecialchars($product_item->name) ?>">
                    <span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
                        <span class="thumb-info-wrapper">
                            <img loading="lazy"
								 src="<?= BASE_URL ?>uploads/product/<?= $product_item->image ?>"
								 class="img-fluid"
								 alt="<?= htmlspecialchars($product_item->name) ?>">
                        </span>
                    </span>
						<?php if ($product_item->action == 1): ?>
							<div class="ribbon" aria-label="Promotion details">
								<?php if (!empty($product_item->aktion_name) && !empty($product_item->price)): ?>
									<?= htmlspecialchars($product_item->aktion_name) ?> / <?= htmlspecialchars($product_item->price) ?>
								<?php elseif (!empty($product_item->aktion_name)): ?>
									<?= htmlspecialchars($product_item->aktion_name) ?>
								<?php elseif (!empty($product_item->price)): ?>
									<?= htmlspecialchars($product_item->price) ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="product-info"><?= htmlspecialchars($product_item->name) ?></div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>

		<nav class="custom-nav" aria-label="Carousel navigation">
			<button class="custom-prev"
					aria-label="Previous product"
					aria-controls="product-carousel">‹</button>
			<button class="custom-next"
					aria-label="Next product"
					aria-controls="product-carousel">›</button>
		</nav>
	</section>

	<section class="container py-5 my-4" aria-labelledby="awards-heading">
		<div class="row text-center py-3">
			<div class="col-md-10 mx-md-auto">
				<h2 id="awards-heading" class="text-uppercase mt-4"><?= lang('FIRMA_LOGOS') ?></h2>
				<div class="row">
					<ul class="list-unstyled d-flex flex-wrap justify-content-center" role="list">
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4" role="listitem">
							<a class="lightbox"
							   href="<?= BASE_URL . 'img/logo/staatliche_auszeichnung.jpg' ?>"
							   data-plugin-options="{'type':'image'}"
							   aria-label="View Staatliche Auszeichnung certificate">
								<img loading="lazy"
									 class="img-fluid"
									 src="<?= BASE_URL . 'img/logo/staatliche_auszeichnung.jpg' ?>"
									 alt="Staatliche Auszeichnung certificate">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4" role="listitem">
							<a class="lightbox"
							   href="<?= BASE_URL . 'img/logo/eco-cert_start.jpg' ?>"
							   data-plugin-options="{'type':'image'}"
							   aria-label="View Eco-Cert certificate">
								<img loading="lazy"
									 class="img-fluid"
									 src="<?= BASE_URL . 'img/logo/eco-cert_start.jpg' ?>"
									 alt="Eco-Cert certificate">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4" role="listitem">
							<a class="lightbox"
							   href="<?= BASE_URL . 'img/logo/Bio-Austria_start.jpg' ?>"
							   data-plugin-options="{'type':'image'}"
							   aria-label="View Bio Austria certificate">
								<img loading="lazy"
									 class="img-fluid"
									 src="<?= BASE_URL . 'img/logo/Bio-Austria_start.jpg' ?>"
									 alt="Bio Austria certificate">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4" role="listitem">
							<a class="lightbox"
							   href="<?= BASE_URL . 'img/logo/top_rated.jpg' ?>"
							   data-plugin-options="{'type':'image'}"
							   aria-label="View Top Rated Company 2024 award">
								<img loading="lazy"
									 class="img-fluid"
									 src="<?= BASE_URL . 'img/logo/top_rated.jpg' ?>"
									 alt="Top Rated Company 2024 award">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4" role="listitem">
							<a class="lightbox"
							   href="<?= BASE_URL . 'img/logo/trusted_shop.jpg' ?>"
							   data-plugin-options="{'type':'image'}"
							   aria-label="View Trusted Shop certificate">
								<img loading="lazy"
									 class="img-fluid"
									 src="<?= BASE_URL . 'img/logo/trusted_shop.jpg' ?>"
									 alt="Trusted Shop certificate">
							</a>
						</li>
					</ul>
					<p><?= lang('FIRMA_LOGOS_TEXT') ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="container" aria-labelledby="brands-heading">
		<h2 id="brands-heading" class="visually-hidden"></h2>
		<div class="row">
			<!-- 1. STYX Naturkosmetik -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/styx_card.jpg" alt="STYX Naturkosmetik logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('STYX_NATURKOSMETIK_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('STYX_NATURKOSMETIK_TEXT') ?></p>
						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/Unternehmen/naturkosmetik';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/company/natural-cosmetics';
						} else {
							echo BASE_URL . 'Naturkosmetik';
						}
						?>"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about STYX Naturkosmetik">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>

			</div>
			<!-- 2. Aroma Derm -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/aroma_derm_card.jpg" alt="Aroma Derm logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('AROMA_DERM_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('AROMA_DERM_TEXT') ?></p>

						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/Unternehmen/aroma-derm-profikosmetik';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/company/aroma-derm-professional-cosmetics';
						} else {
							echo BASE_URL;
						}
						?>"
						 class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about Aroma Derm">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 3. Schokoladenmanufaktur -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/schokoladenmanufaktur_card.jpg" alt="STYX Schokoladenmanufaktur logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('SCHOKOLADE_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('SCHOKOLADE_TEXT') ?></p>
						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/Unternehmen/schokoladenmanufaktur';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/company/chocolate-manufactory';
						} else {
							echo BASE_URL;
						}
						?>"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about STYX Schokoladenmanufaktur">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 4. World of STYX -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/welcomecenter_card.jpg" alt="World of STYX logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('WORLD_OF_STYX_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('WORLD_OF_STYX_TEXT') ?></p>
						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/besuchen/betriebsfuehrungen';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/visit/factory-tours';
						} else {
							echo BASE_URL;
						}
						?>"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about World of STYX">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 5. Private Labeling -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/privateLabeling_card.jpg" alt="Private Labeling logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('PRIVATE_LABELING_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('PRIVATE_LABELING_TEXT') ?></p>
						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/Unternehmen/private-labeling';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/company/private-labeling';
						} else {
							echo BASE_URL;
						}
						?>"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about Private Labeling">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 6. Werbegeschenke | EN-Bahnhofsbraeu -->
			<?php if (language() === 'en'): ?>
				<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
					<div class="card h-100">
						<img class="card-img-top" src="<?= BASE_URL ?>img/image/bahnhofsbraeu_card.jpg" alt="Bahnhofsbaue_logo">
						<div class="card-body">
							<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('BAHNHOFSBRAUE_TEXT_HEADER') ?></h3>
							<p class="card-text mb-2 pb-1"><?= lang('BAHNHOFSBRAUE_TEXT') ?></p>
							<a href="<?= BASE_URL ?>en/visit/bahnhofsbraeu"
							   class="read-more text-color-primary font-weight-semibold text-2"
							   aria-label="Learn more about Private Labeling">
								<?= lang('READ_MORE') ?>
								<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
					<div class="card h-100">
						<img class="card-img-top" src="<?= BASE_URL ?>img/image/werbegeschenke_card.jpg" alt="Werbegeschenke logo">
						<div class="card-body">
							<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('WERBE_TEXT_HEADER') ?></h3>
							<p class="card-text mb-2 pb-1"><?= lang('WERBE_TEXT') ?></p>
							<a href="<?= BASE_URL ?>de/Unternehmen/werbegeschenke"
							   class="read-more text-color-primary font-weight-semibold text-2"
							   aria-label="Learn more about Werbegeschenke">
								<?= lang('READ_MORE') ?>
								<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- 7. STYX Remise -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/remise_card.jpg" alt="STYX Remise logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('STYX_REMISE_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('STYX_REMISE_TEXT') ?></p>
						<a href="https://www.styx-remise.at/"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about STYX Remise" target="_blank" rel="noopener">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 8. STYX Academy -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/workshops_card.jpg" alt="STYX Academy logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('ACADEMY_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('ACADEMY_TEXT') ?></p>
						<a href="<?php
						if (language() === 'de') {
							echo BASE_URL . 'de/besuchen/workshops';
						} elseif (language() === 'en') {
							echo BASE_URL . 'en/Workshops-Seminars';
						} else {
							echo BASE_URL;
						}
						?>"
						   class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about STYX Academy">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- 9. EMPTY CARD -->
			<div class="col-md-6 col-lg-4 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="card h-100">
					<img class="card-img-top" src="<?= BASE_URL ?>img/image/gartenwelt_card.jpg" alt="STYX Gartenwelt_logo">
					<div class="card-body">
						<h3 class="card-title mb-1 text-4 font-weight-bold"><?= lang('GARTENWELT_TEXT_HEADER') ?></h3>
						<p class="card-text mb-2 pb-1"><?= lang('GARTENWELT_TEXT') ?></p>
						<a href="<?= BASE_URL . language() . '/Workshops' ?>" class="read-more text-color-primary font-weight-semibold text-2"
						   aria-label="Learn more about STYX Gartenwelt">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
