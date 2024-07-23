<div role="main" class="main">
	<div class="home-intro light border border-bottom-0 mb-0">
		<div class="container">
			<div class="row">
				<div class="col">
					<h1 style='font-weight: bolder' class="text-center"><?= lang('AKTUELL') ?></h1>
					<div class="owl-carousel owl-theme show-nav-title show-nav-title-both-sides news-carousel" data-plugin-options="{'items': 4, 'margin': 10, 'loop': true, 'nav': true, 'dots': false, 'autoplay': false}">
						<?php foreach ($news as $news_item): ?>
							<div class="home-carousel-card" onclick="location.href='<?= $news_item->buttonUrl ?>';" style="cursor: pointer;">
								<div class="home-carousel-img-container">
									<img alt="" class="img-fluid rounded" src="<?= BASE_URL ?>uploads/news/<?= $news_item->image ?>">
								</div>
								<div class="home-carousel-card-content">
									<h5><?= $news_item->name ?></h5>
									<p><?= $news_item->name1 ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col">
			<hr class="solid my-5">
			<h1 style='font-weight: bolder' class="text-center"><?= lang('PRODUCT_WEB') ?></h1>
		</div>
	</div>

	<div class="owl-carousel owl-theme full-width" data-plugin-options="{'items': 6, 'loop': true, 'nav': true, 'dots': false}">
		<?php foreach ($product as $product_item): ?>
			<a href="<?= $product_item->url ?>" aria-label="">
			<span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
				<span class="thumb-info-wrapper">
					<img src="<?= BASE_URL ?>uploads/product/<?= $product_item->image ?>" class="img-fluid" alt="<?= $product_item->name ?>">
				</span>
			</span>
				<?php if ($product_item->action == 1): ?>
					<div class="ribbon">
						<?php if (!empty($product_item->aktion_name) && !empty($product_item->price)): ?>
							<?= $product_item->aktion_name ?> / <?= $product_item->price ?>
						<?php elseif (!empty($product_item->aktion_name)): ?>
							<?= $product_item->aktion_name ?>
						<?php elseif (!empty($product_item->price)): ?>
							<?= $product_item->price ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="product-info">
					<?= $product_item->name ?>
				</div>
			</a>
		<?php endforeach; ?>
	</div>

	<div class="container py-5 my-4">
		<div class="row text-center py-3">
			<div class="col-md-10 mx-md-auto">
				<h5 class="text-uppercase mt-4"><?= lang('FIRMA_LOGOS') ?></h5>
				<div class="row">
					<ul class="list-unstyled d-flex flex-wrap justify-content-center">
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4">
							<a class="lightbox" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?= BASE_URL . 'img/webImage/staat.png' ?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4">
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?= BASE_URL . 'img/webImage/eco-cert_start.png' ?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4">
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?= BASE_URL . 'img/webImage/Bio-Austria_start.png' ?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4">
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?= BASE_URL . 'img/webImage/top_rated_company_24.png' ?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
						<li class="col-lg-2 col-md-4 col-sm-6 mb-4">
							<a class="lightbox" href="img/projects/project.jpg" data-plugin-options="{'type':'image'}">
								<img class="img-fluid" src="<?= BASE_URL . 'img/webImage/trusted-shop_start.png' ?>" alt="Staatliche_Auszeichnung">
							</a>
						</li>
					</ul>
					<p><?= lang('FIRMA_LOGOS_TEXT') ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/Styx-Naturcosmetic.jpg" alt="Logo">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('STYX_NATURKOSMETIK_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('STYX_NATURKOSMETIK_TEXT')?></p>
					<?php if (language() === 'en'): ?>
						<a href="<?= BASE_URL . 'en/Naturkosmetik' ?>" class="read-more text-color-primary font-weight-semibold text-2">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1"></i>
						</a>
					<?php else: ?>
						<a href="<?= BASE_URL . 'Naturkosmetik' ?>" class="read-more text-color-primary font-weight-semibold text-2">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1"></i>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/Aroma-Derm.jpg" alt="Aroma-Derm.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('AROMA_DERM_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('AROMA_DERM_TEXT')?></p>
					<?php if (language() === 'en'): ?>
						<a href="<?= BASE_URL . 'en/Aroma-Derm' ?>" class="read-more text-color-primary font-weight-semibold text-2">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1"></i>
						</a>
					<?php else: ?>
						<a href="<?= BASE_URL . 'Aroma-Derm' ?>" class="read-more text-color-primary font-weight-semibold text-2">
							<?= lang('READ_MORE') ?>
							<i class="fas fa-angle-right position-relative top-1 ms-1"></i>
						</a>
					<?php endif; ?>				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/Styx-Schokoladenmanufaktur.jpg" alt="Styx-Schokoladenmanufaktur.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('SCHOKOLADE_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('SCHOKOLADE_TEXT')?></p>
					<a href="/" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/World-of-Styx.jpg" alt="World-of-Styx.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('WORLD_OF_STYX_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('WORLD_OF_STYX_TEXT')?></p>
					<a href="https://www.styx.at/de/Betriebsfuehrungen" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>

	</div>
	<br>
	<div class="row justify-content-center">
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/PL.jpg" alt="Private Labeling logo">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('PRIVATE_LABELING_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('PRIVATE_LABELING_TEXT')?></p>
					<a href="/" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/Werbegeschenke.jpg" alt="Werbegeschenke.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('WERBE_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('WERBE_TEXT')?></p>
					<a href="/" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/STYX-Remise.jpg" alt="STYX-Remise.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('STYX_REMISE_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('STYX_REMISE_TEXT')?></p>
					<a href="/" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-3 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
			<div class="card">
				<img class="card-img-top" src="<?=BASE_URL?>img/logo/STYX-Academy.jpg" alt="STYX-Academy.jpg">
				<div class="card-body">
					<h4 class="card-title mb-1 text-4 font-weight-bold"><?=lang('ACADEMY_TEXT_HEADER')?></h4>
					<p class="card-text mb-2 pb-1"><?=lang('ACADEMY_TEXT')?></p>
					<a href="https://www.styx.at/de/Betriebsfuehrungen" class="read-more text-color-primary font-weight-semibold text-2"><?=lang('READ_MORE')?><i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
				</div>
			</div>
		</div>

	</div>
</div>

<script>
		$(window).on('load', function(){
		$(".owl-carousel").owlCarousel();
	});
</script>
