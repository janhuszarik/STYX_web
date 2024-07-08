<!--<body>-->
<!--<header id="header" class="header header-sticky header-sticky-smart disable-transition-all z-index-5">-->
<!---->
<!--	<div class="topbar bg-body border-bottom">-->
<!--		<div class="container-wide container d-flex justify-content-between align-items-center">-->
<!--			<p style ="color: #fff;" class="mb-0 p-4 fs-6 fw-bold text-center flex-grow-1">STYX Naturcosmetic - nachhaltige Kosmetik aus Österreich</p>-->
<!--			<div class="text-end desktop-only">-->
<!--				<a href="https://www.aroma-derm.com/login.php" class="btn btn-success btn-sm fw-bold">Login für Händler</a>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!---->
<!---->
<!--	<div class="sticky-area">-->
<!--		<div class="main-header nav navbar bg-body navbar-light navbar-expand-xl py-6 py-xl-0">-->
<!--			<div class="container-wide container flex-nowrap">-->
<!--				<div class="w-72px d-flex d-xl-none">-->
<!--					<button class="navbar-toggler align-self-center  border-0 shadow-none px-0 canvas-toggle p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasNavBar" aria-controls="offCanvasNavBar" aria-expanded="false" aria-label="Toggle Navigation">-->
<!--						<span class="fs-24 toggle-icon"></span>-->
<!--					</button>-->
<!--				</div>-->
<!--				<div class="w-xl-50 mx-auto">-->
<!--					<a href="--><?php //=BASE_URL?><!--" class="navbar-brand px-0 py-4 mx-auto">-->
<!--						<img class="light-mode-img" src="--><?php //=BASE_URL.LOGO?><!--" width="179" height="90" alt="STYX_Naturcosmetic_Logo">-->
<!--						<img class="dark-mode-img" src="--><?php //=BASE_URL.LOGO1?><!--" width="179" height="90" alt="STYX_Naturcosmetic_Logo"></a>-->
<!--				</div>-->
<!--				<ul class="navbar-nav">-->
<!--					--><?php //foreach ($menuItems as $index => $item): ?>
<!--						--><?php //$url = empty($item->url) ? BASE_URL : $item->url; ?>
<!--						<li class="nav-item dropdown">-->
<!--							<a class="nav-link dropdown-toggle --><?php //= ($current_url == $url) ? 'active' : '' ?><!-- --><?php //= !empty($item->children) ? 'has-children' : '' ?><!--" href="--><?php //= $url ?><!--" id="menu-item---><?php //= $index ?><!--" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--								--><?php //= $item->name ?>
<!--								--><?php //if (!empty($item->children)): ?>
<!--									<i class="fas fa-angle-down ms-2"></i>-->
<!--								--><?php //endif; ?>
<!--							</a>-->
<!--							--><?php //if (!empty($item->children)): ?>
<!--								<ul class="dropdown-menu" aria-labelledby="menu-item---><?php //= $index ?><!--">-->
<!--									--><?php //foreach ($item->children as $child): ?>
<!--										--><?php //$child_url = empty($child->url) ? BASE_URL : $child->url; ?>
<!--										<li>-->
<!--											<a class="dropdown-item --><?php //= ($current_url == $child_url) ? 'active' : '' ?><!--" href="--><?php //= $child_url ?><!--">-->
<!--												--><?php //= $child->name ?>
<!--											</a>-->
<!--										</li>-->
<!--									--><?php //endforeach; ?>
<!--								</ul>-->
<!--							--><?php //endif; ?>
<!--						</li>-->
<!--					--><?php //endforeach; ?>
<!--				</ul>-->
<!--				<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis">-->
<!--					<div class="px-xl-5 d-inline-block">-->
<!--						<a class="lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#searchModal" aria-controls="searchModal" aria-expanded="false">-->
<!--							<svg class="icon icon-magnifying-glass-light">-->
<!--								<use xlink:href="#icon-magnifying-glass-light"></use>-->
<!--							</svg>-->
<!--						</a>-->
<!--					</div>-->
<!--					<div class="px-5 d-none d-xl-inline-block">-->
<!--						<a class="lh-1 color-inherit text-decoration-none" href="" data-bs-toggle="modal" data-bs-target="#signInModal">-->
<!--							<svg class="icon icon-user-light">-->
<!--								<use xlink:href="#icon-user-light"></use>-->
<!--							</svg>-->
<!--						</a>-->
<!--					</div>-->
<!--					<div class="px-5 d-none d-xl-inline-block">-->
<!--						<a class="position-relative lh-1 color-inherit text-decoration-none" href="/shop/wishlist.html">-->
<!--							<svg class="icon icon-star-light">-->
<!--								<use xlink:href="#icon-star-light"></use>-->
<!--							</svg>-->
<!--							<span class="badge bg-dark text-white position-absolute top-0 start-100 translate-middle mt-4 rounded-circle fs-13px p-0 square" style="--square-size: 18px">3</span>-->
<!--						</a>-->
<!--					</div>-->
<!--					<div class="px-5 d-none d-xl-inline-block">-->
<!--						<a class="position-relative lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart" aria-expanded="false">-->
<!--							<svg class="icon icon-star-light">-->
<!--								<use xlink:href="#icon-shopping-bag-open-light"></use>-->
<!--							</svg>-->
<!--							<span class="badge bg-dark text-white position-absolute top-0 start-100 translate-middle mt-4 rounded-circle fs-13px p-0 square" style="--square-size: 18px">3</span>-->
<!--						</a>-->
<!--					</div>-->
<!--					<div class="color-modes position-relative ps-5">-->
<!--						<a class="bd-theme btn btn-link nav-link dropdown-toggle d-inline-flex align-items-center justify-content-center text-primary p-0 position-relative rounded-circle" href="#" aria-expanded="true" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">-->
<!--							<svg class="bi my-1 theme-icon-active">-->
<!--								<use href="#sun-fill"></use>-->
<!--							</svg>-->
<!--						</a>-->
<!--						<ul class="dropdown-menu dropdown-menu-end fs-14px" data-bs-popper="static">-->
<!--							<li>-->
<!--								<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true">-->
<!--									<svg class="bi me-4 opacity-50 theme-icon">-->
<!--										<use href="#sun-fill"></use>-->
<!--									</svg>-->
<!--									Light-->
<!--									<svg class="bi ms-auto d-none">-->
<!--										<use href="#check2"></use>-->
<!--									</svg>-->
<!--								</button>-->
<!--							</li>-->
<!--							<li>-->
<!--								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">-->
<!--									<svg class="bi me-4 opacity-50 theme-icon">-->
<!--										<use href="#moon-stars-fill"></use>-->
<!--									</svg>-->
<!--									Dark-->
<!--									<svg class="bi ms-auto d-none">-->
<!--										<use href="#check2"></use>-->
<!--									</svg>-->
<!--								</button>-->
<!--							</li>-->
<!--							<li>-->
<!--								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">-->
<!--									<svg class="bi me-4 opacity-50 theme-icon">-->
<!--										<use href="#circle-half"></use>-->
<!--									</svg>-->
<!--									Auto-->
<!--									<svg class="bi ms-auto d-none">-->
<!--										<use href="#check2"></use>-->
<!--									</svg>-->
<!--								</button>-->
<!--							</li>-->
<!--						</ul>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</header>-->
<body>
<header id="header" class="header header-sticky header-sticky-smart disable-transition-all z-index-5">
	<div class="topbar" style="background-color: #00bc4a;">
		<div class="container">
			<p class="mb-0 text-dark text-center p-4 fs-14px fw-medium ls-1 text-uppercase">
				STYX Naturcosmetic - nachhaltige Kosmetik aus Österreich
			</p>
		</div>
	</div>
	<div class="header-above mb-3">
		<div class="container d-none d-xl-block">
			<div class="pt-8 d-flex">
				<div class="w-50 d-flex">
					<div class="d-flex align-items-center justify-content-start">
						<div class="dropdown me-10">
							<button class="btn btn-link dropdown-toggle fw-semibold ls-1 p-0 dropdown-menu-end fs-13px" type="button" data-bs-toggle="dropdown" aria-expanded="false">Login für Händler
							</button>
						</div>
<!--						<div class="dropdown">-->
<!--							<button class="btn btn-link dropdown-toggle fw-semibold text-uppercase ls-1 p-0 dropdown-menu-end fs-15px" type="button" data-bs-toggle="dropdown" aria-expanded="false">USD-->
<!--							</button>-->
<!--							<div class="dropdown-menu dropdown-menu-end py-5" style="min-width: unset">-->
<!--								<a class="dropdown-item py-1" href="#">EUR</a>-->
<!--								<a class="dropdown-item py-1" href="#">GBP</a>-->
<!--								<a class="dropdown-item py-1" href="#">JPY</a>-->
<!--								<a class="dropdown-item py-1" href="#">AUD</a>-->
<!--							</div>-->
<!--						</div>-->
					</div>
				</div>
				<a href="/" class="navbar-brand px-8 py-4 mx-auto">
					<img class="light-mode-img" src="<?=BASE_URL.LOGO?>" width="200" height="80" alt="Glowing - Bootstrap 5 HTML Templates">
					<img class="dark-mode-img" src="<?=BASE_URL.LOGO1?>" width="200" height="90" alt="Glowing - Bootstrap 5 HTML Templates"></a>
				<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis">
					<form action="#" method="get" class="search-box-2 w-60">
						<div class="position-relative">
							<input type="text" name="s" class="form-control form-control bg-transparent pe-12 lh-1 py-5" placeholder="Search product">
							<button class="position-absolute pos-fixed-right-center bg-transparent border-0 px-0 fs-4 px-6 top-0 bottom-0 end-0 my-auto z-index-3 text-body-emphasis" type="submit">
								<svg class="icon fs-18px mt-n3">
									<use xlink:href="#search"></use>
								</svg>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="sticky-area">
		<div class="main-header nav navbar bg-body navbar-light navbar-expand-xl py-6 py-xl-0">
			<div class="container">
				<div class="d-flex d-xl-none w-100">
					<div class="w-72px d-flex d-xl-none">
						<button class="navbar-toggler align-self-center  border-0 shadow-none px-0 canvas-toggle p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasNavBar" aria-controls="offCanvasNavBar" aria-expanded="false" aria-label="Toggle Navigation">
							<span class="fs-24 toggle-icon"></span>
						</button>
					</div>
					<div class="d-flex mx-auto">
						<a href="/" class="navbar-brand px-8 py-4 mx-auto">
							<img class="light-mode-img" src="<?=BASE_URL.LOGO?>" width="179" height="26" alt="Glowing - Bootstrap 5 HTML Templates">
							<img class="dark-mode-img" src="<?=BASE_URL.LOGO?>" width="179" height="26" alt="Glowing - Bootstrap 5 HTML Templates"></a>
					</div>
					<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis w-72px">
						<div class="px-xl-5 d-inline-block">
							<a class="lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#searchModal" aria-controls="searchModal" aria-expanded="false">
								<svg class="icon icon-magnifying-glass-light">
									<use xlink:href="#icon-magnifying-glass-light"></use>
								</svg>
							</a>
						</div>
						<div class="color-modes position-relative ps-5">
							<a class="bd-theme btn btn-link nav-link dropdown-toggle d-inline-flex align-items-center justify-content-center text-primary p-0 position-relative rounded-circle" href="#" aria-expanded="true" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
								<svg class="bi my-1 theme-icon-active">
									<use href="#sun-fill"></use>
								</svg>
							</a>
							<ul class="dropdown-menu dropdown-menu-end fs-14px" data-bs-popper="static">
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true">
										<svg class="bi me-4 opacity-50 theme-icon">
											<use href="#sun-fill"></use>
										</svg>
										Light
										<svg class="bi ms-auto d-none">
											<use href="#check2"></use>
										</svg>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
										<svg class="bi me-4 opacity-50 theme-icon">
											<use href="#moon-stars-fill"></use>
										</svg>
										Dark
										<svg class="bi ms-auto d-none">
											<use href="#check2"></use>
										</svg>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
										<svg class="bi me-4 opacity-50 theme-icon">
											<use href="#circle-half"></use>
										</svg>
										Auto
										<svg class="bi ms-auto d-none">
											<use href="#check2"></use>
										</svg>
									</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="d-none d-xl-flex w-xl-50"></div>

				<div class="d-none d-xl-flex w-xl-50">
					<ul class="navbar-nav">
						<?php foreach ($menuItems as $index => $item): ?>
							<?php $url = empty($item->url) ? BASE_URL : $item->url; ?>
							<li class="nav-item <?= !empty($item->children) ? 'dropdown' : '' ?>">
								<a class="nav-link <?= ($current_url == $url) ? 'active' : '' ?> <?= !empty($item->children) ? 'dropdown-toggle' : '' ?>" href="<?= $url ?>" id="menu-item-<?= $index ?>" role="button" <?= !empty($item->children) ? 'data-bs-toggle="dropdown" aria-expanded="false"' : '' ?>>
									<?= $item->name ?>
									<?php if (!empty($item->children)): ?>
										<i class="fas fa-angle-down ms-2"></i>
									<?php endif; ?>
								</a>
								<?php if (!empty($item->children)): ?>
									<ul class="dropdown-menu" aria-labelledby="menu-item-<?= $index ?>">
										<?php foreach ($item->children as $child): ?>
											<?php $child_url = empty($child->url) ? BASE_URL : $child->url; ?>
											<li>
												<a class="dropdown-item <?= ($current_url == $child_url) ? 'active' : '' ?>" href="<?= $child_url ?>">
													<?= $child->name ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>

				</div>
				<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis">
					<div class="px-5 d-none d-xl-inline-block">
						<a class="lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
							<svg class="icon icon-user-light">
								<use xlink:href="#icon-user-light"></use>
							</svg>
						</a>
					</div>
					<div class="px-5 d-none d-xl-inline-block">
						<a class="position-relative lh-1 color-inherit text-decoration-none" href="/shop/wishlist.html">
							<svg class="icon icon-star-light">
								<use xlink:href="#icon-star-light"></use>
							</svg>
							<span class="badge bg-dark text-white position-absolute top-0 start-100 translate-middle mt-4 rounded-circle fs-13px p-0 square" style="--square-size: 18px">3</span>
						</a>
					</div>
					<div class="px-5 d-none d-xl-inline-block">
						<a class="position-relative lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart" aria-expanded="false">
							<svg class="icon icon-star-light">
								<use xlink:href="#icon-shopping-bag-open-light"></use>
							</svg>
							<span class="badge bg-dark text-white position-absolute top-0 start-100 translate-middle mt-4 rounded-circle fs-13px p-0 square" style="--square-size: 18px">3</span>
						</a>
					</div>
					<div class="color-modes position-relative ps-5 d-none d-xl-inline-block">
						<a class="bd-theme btn btn-link nav-link dropdown-toggle d-inline-flex align-items-center justify-content-center text-primary p-0 position-relative rounded-circle" href="#" aria-expanded="true" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
							<svg class="bi my-1 theme-icon-active">
								<use href="#sun-fill"></use>
							</svg>
						</a>
						<ul class="dropdown-menu dropdown-menu-end fs-14px" data-bs-popper="static">
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true">
									<svg class="bi me-4 opacity-50 theme-icon">
										<use href="#sun-fill"></use>
									</svg>
									Light
									<svg class="bi ms-auto d-none">
										<use href="#check2"></use>
									</svg>
								</button>
							</li>
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
									<svg class="bi me-4 opacity-50 theme-icon">
										<use href="#moon-stars-fill"></use>
									</svg>
									Dark
									<svg class="bi ms-auto d-none">
										<use href="#check2"></use>
									</svg>
								</button>
							</li>
							<li>
								<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
									<svg class="bi me-4 opacity-50 theme-icon">
										<use href="#circle-half"></use>
									</svg>
									Auto
									<svg class="bi ms-auto d-none">
										<use href="#check2"></use>
									</svg>
								</button>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
