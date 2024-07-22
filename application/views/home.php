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

	<div class="container">
		<div class="d-flex justify-content-between">
			<div class="card-wrapper col-md-6 col-lg-5 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
				<div class="outer-card card">
					<div class="inner-card">
						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-4 d-flex align-items-center justify-content-center">
									<img src="<?= BASE_URL . 'img/webImage/naturcosmeticImage.jpg' ?>" class="img-fluid rounded-start" alt="...">
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
									<img src="<?= BASE_URL . 'img/webImage/greenLogo.jpg' ?>" class="img-fluid rounded-start" alt="...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Removed duplicated card-wrapper -->
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".owl-carousel").owlCarousel();
	});
</script>
