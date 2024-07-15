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
									<img alt="STYX Logo" width="180" height="80" data-sticky-width="82" data-sticky-height="40" data-sticky-top="25" src="<?=BASE_URL.LOGO?>">
								</a>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-end">
						<div class="header-row pt-3">
							<nav class="header-nav-top">
								<ul class="nav nav-pills">
									<li class="nav-item nav-item-anim-icon d-none d-md-block">
										<a class="nav-link ps-0" href="about-us.html"><i class="fas fa-angle-right"></i> About Us</a>
									</li>
									<li class="nav-item nav-item-anim-icon d-none d-md-block">
										<a class="nav-link" href="contact-us.html"><i class="fas fa-angle-right"></i> Contact Us</a>
									</li>
									<li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
										<div class="d-flex">
											<?php foreach (getLanguages() as $l){ ?>
												<div class="active lang me-2">
													<a href="<?= BASE_URL . $l ?>"><img src="<?= langInfo($l)['flag'] ?>" width="30px" alt=""></a>
												</div>
											<?php } ?>
										</div>
									</li>
									<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show">
										<span class="ws-nowrap"><a href="<?=PHONE_HREF?>"><i class="fas fa-phone"></i> <?=PHONE?></a></span>
									</li>
								</ul>

							</nav>
							<div class="header-nav-features">
								<div class="header-nav-feature header-nav-features-search d-inline-flex">
									<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search"><i class="fas fa-search header-nav-top-icon"></i></a>
									<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
										<form role="search" action="page-search-results.html" method="get">
											<div class="simple-search input-group">
												<input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
												<button class="btn" type="submit" aria-label="Search">
													<i class="fas fa-search header-nav-top-icon"></i>
												</button>
											</div>
										</form>
									</div>
								</div>
								<div class="header-nav-feature header-nav-features-cart d-inline-flex ms-2">
									<a href="#" class="header-nav-features-toggle" aria-label="">
										<img src="img/icons/icon-cart.svg" width="14" alt="" class="header-nav-top-icon-img">
										<span class="cart-info d-none">
                                                <span class="cart-qty">1</span>
                                            </span>
									</a>
									<div class="header-nav-features-dropdown" id="headerTopCartDropdown">
										<ol class="mini-products-list">
											<li class="item">
												<a href="#" title="Camera X1000" class="product-image"><img src="img/products/product-1.jpg" alt="Camera X1000"></a>
												<div class="product-details">
													<p class="product-name">
														<a href="#">Camera X1000</a>
													</p>
													<p class="qty-price">
														1X <span class="price">$890</span>
													</p>
													<a href="#" title="Remove This Item" class="btn-remove"><i class="fas fa-times"></i></a>
												</div>
											</li>
										</ol>
										<div class="totals">
											<span class="label">Total:</span>
											<span class="price-total"><span class="price">$890</span></span>
										</div>
										<div class="actions">
											<a class="btn btn-dark" href="#">View Cart</a>
											<a class="btn btn-primary" href="#">Checkout</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="header-row">
							<div class="header-nav pt-1">
								<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav nav-pills" id="mainNav">
											<?php foreach (getMenu() as $menu) { ?>
												<li class="nav-item dropdown">
													<a class="nav-link dropdown-toggle" href="<?= BASE_URL . $menu['url'] ?>">
														<?= $menu['name'] ?>
														<?php if (isset($menu['parent'])){ ?>
															<i class="fa fa-angle-down"></i>
														<?php } ?>
													</a>
													<?php if (isset($menu['parent'])){ ?>
														<ul class="dropdown-menu">
															<?php foreach ($menu['parent'] as $subMenu) { ?>
																<li><a class="dropdown-item" href="<?= BASE_URL . $subMenu['url'] ?>"><?= $subMenu['name'] ?></a></li>
															<?php } ?>
														</ul>
													<?php } ?>
												</li>
											<?php } ?>
										</ul>
									</nav>
								</div>
								<ul class="header-social-icons social-icons d-none d-sm-block">
									<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
									<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
									<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
								</ul>
								<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
									<i class="fas fa-bars"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</div>
</body>
