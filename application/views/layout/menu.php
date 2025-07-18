<body data-plugin-page-transition>
<div class="body">
	<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 45, 'stickySetTop': '-45px', 'stickyChangeLogo': true}">
		<div class="header-body">
			<div class="header-container container">
				<div class="header-row">
					<div class="header-column">
						<div class="header-row">
							<div class="header-logo">
								<a href="<?=BASE_URL?>">
									<img alt="STYX Logo" width="180" height="80" data-sticky-width="102" data-sticky-height="40" data-sticky-top="40" src="<?=BASE_URL.LOGO?>">
								</a>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-end">
						<div class="header-row pt-3">
							<nav class="header-nav-top">
								<ul class="nav nav-pills align-items-center">
									<li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
										<div style="padding: 0px" class="d-flex">
											<?php foreach (getLanguages() as $l){ ?>
												<div class="lang me-2">
													<a href="<?= BASE_URL . $l ?>"><img src="<?= langInfo($l)['flag'] ?>" width="40px" alt="<?= strtoupper($l) ?>"></a>
												</div>
											<?php } ?>
										</div>
									</li>
									<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show nav-item-hide">
										<div class="container">
											<a href="<?=lang('HÄNDLER_URL')?>"><button class="aroma-button"><?=lang('HÄNDLER_TEXT')?></button></a>
										</div>
									</li>
									<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show nav-item-hide">
										<div class="container">
											<a href="https://shop.styx.at/">
												<button class="pulse-button">
													<i class="fas fa-shopping-cart me-2"></i>
													<span style="font-weight: bold">SHOP</span>
												</button>
											</a>
										</div>
									</li>
								</ul>
							</nav>

							<div class="header-nav-features header-nav-hide">
								<div class="header-nav-feature header-nav-features-search d-inline-flex">
									<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search">
										<i class="fas fa-search header-nav-top-icon"></i>
									</a>
									<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
										<form role="search" action="<?php echo base_url('search'); ?>" method="get">
											<div class="simple-search input-group">
												<input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Suchen...">
												<button class="btn" type="submit" aria-label="Search">
													<i class="fas fa-search header-nav-top-icon"></i>
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="header-row">
							<div class="header-nav pt-1">
								<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav nav-pills" id="mainNav">
											<?php $currentUrl = getCurrentUrl(); ?>
											<?php foreach (getMenu() as $menu) { ?>
												<li class="nav-item dropdown <?= $menu['url'] == $currentUrl ? 'active' : '' ?>">
													<?php
													// Položka je klikateľná, ak nemá deti (has_child == false) a base != 1
													if (!$menu['has_child'] && $menu['base'] != 1) { ?>
														<a class="nav-link" href="<?= $menu['is_external'] ? $menu['url'] : BASE_URL . $menu['url'] ?>" target="<?= $menu['is_external'] ? '_blank' : '_self' ?>">
															<?= $menu['name'] ?>
														</a>
													<?php } else { ?>
														<a class="nav-link dropdown-toggle no-link" href="javascript:void(0);">
															<?= $menu['name'] ?>
														</a>
													<?php } ?>
													<?php if ($menu['has_child']) { ?>
														<ul class="dropdown-menu">
															<?php foreach ($menu['children'] as $subMenu) { ?>
																<li>
																	<a class="dropdown-item" href="<?= $subMenu['is_external'] ? $subMenu['url'] : BASE_URL . $subMenu['url'] ?>" target="<?= $subMenu['is_external'] ? '_blank' : '_self' ?>">
																		<?= $subMenu['name'] ?>
																	</a>
																</li>
															<?php } ?>
														</ul>
													<?php } ?>
												</li>
											<?php } ?>
											<li class="nav-item mobile-only">
												<a href="https://shop.styx.at/" class="nav-link mobile-button">
													<i style="font-weight: bold; color: white" class="fas fa-shopping-cart me-2"></i>
													<span style="font-weight: bold; color: white">SHOP</span>
												</a>
											</li>
											<li class="nav-item mobile-only">
												<a style="font-weight: bold; color: white" href="<?=lang('HÄNDLER_URL')?>" class="nav-link mobile-button"><?=lang('HÄNDLER_TEXT')?></a>
											</li>
										</ul>
									</nav>
								</div>
								<ul class="header-social-icons social-icons d-none d-sm-block">
									<li class="social-icons-facebook"><a href="https://www.facebook.com/www.styx.at/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
									<li class="social-icons-instagram"><a href="https://www.instagram.com/styx.naturcosmetic/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
									<li class="social-icons-pinterest"><a href="https://at.pinterest.com/styxnaturcosmetic/" target="_blank" title="Pinterest"><i class="fab fa-pinterest"></i></a></li>
									<li class="social-icons-youtube"><a href="https://www.youtube.com/channel/UCxpLOYYahcENUfVnacBvagA" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a></li>
									<li class="social-icons-email"><a href="mailto:info@styx.at" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>
								</ul>
								<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
									<i class="fas fa-bars"></i>
								</button>
								<div class="d-block d-md-none mobile-lang-flags">
									<?php foreach (getLanguages() as $l){ ?>
										<div class="lang me-2">
											<a href="<?= BASE_URL . $l ?>"><img src="<?= langInfo($l)['flag'] ?>" width="40px" alt="<?= strtoupper($l) ?>"></a>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>
</body>
