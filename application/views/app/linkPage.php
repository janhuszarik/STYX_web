<div role="main" class="main">
	<section class="page-header page-header-modern page-header-background page-header-background-md parallax overlay overlay-color-dark overlay-show overlay-op-5 mt-0" data-plugin-parallax data-plugin-options="{'speed': 1.2}" data-image-src="<?=BASE_URL?>img/paralax.jpg">
		<div class="container">
			<div class="row">
				<div class="col-md-12 align-self-center p-static order-2 text-center">
					<h1><strong><?=$title?></strong></h1>
				</div>
				<div class="col-md-12 align-self-center order-1">
					<ul class="breadcrumb breadcrumb-light d-block text-center">
						<li><a href="#">Domov</a></li>
						<li class="active"><?=$title?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<div role="main" class="main">

		<div id="examples" class="container py-2">

			<div class="row mb-5 pb-3">
				<?php foreach ($linkPage as $l): ?>
					<div class="col-md-6 col-lg-6 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
						<div class="card mb-3">
							<div class="row g-0">
								<div class="col-lg-4">
									<img src="<?= BASE_URL . $l->image ?>" class="img-fluid p-relative left-1 rounded-end" alt="...">
								</div>
								<div class="col-lg-8">
									<div class="card-body">
										<h4 class="card-title mb-1 text-4 font-weight-bold"><?= $l->name ?></h4>
										<p class="card-text mb-2"><?= $l->plusInfo ?></p>
										<a href="https://<?= $l->link ?>" class="read-more text-color-primary font-weight-semibold text-2">Prejdi na web <i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
