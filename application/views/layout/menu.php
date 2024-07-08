<body>
<header id="header" class="header header-sticky header-sticky-smart disable-transition-all z-index-5">

	<div class="topbar bg-body border-bottom">
		<div class="container-wide container d-flex justify-content-between align-items-center">
			<p style ="color: #fff;" class="mb-0 p-4 fs-6 fw-bold text-center flex-grow-1">STYX Naturcosmetic - nachhaltige Kosmetik aus Österreich</p>
			<div class="text-end desktop-only">
				<a href="https://www.aroma-derm.com/login.php" class="btn btn-success btn-sm fw-bold">Login für Händler</a>
			</div>
		</div>
	</div>
	

	<div class="sticky-area">
		<div class="main-header nav navbar bg-body navbar-light navbar-expand-xl py-6 py-xl-0">
			<div class="container-wide container flex-nowrap">
				<div class="w-72px d-flex d-xl-none">
					<button class="navbar-toggler align-self-center  border-0 shadow-none px-0 canvas-toggle p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasNavBar" aria-controls="offCanvasNavBar" aria-expanded="false" aria-label="Toggle Navigation">
						<span class="fs-24 toggle-icon"></span>
					</button>
				</div>
				<div class="w-xl-50 mx-auto">
					<a href="<?=BASE_URL?>" class="navbar-brand px-0 py-4 mx-auto">
						<img class="light-mode-img" src="<?=BASE_URL.LOGO?>" width="179" height="90" alt="STYX_Naturcosmetic_Logo">
						<img class="dark-mode-img" src="<?=BASE_URL.LOGO1?>" width="179" height="90" alt="STYX_Naturcosmetic_Logo"></a>
				</div>
				<ul class="navbar-nav">
					<?php foreach ($menuItems as $index => $item): ?>
						<?php $url = empty($item->url) ? BASE_URL : $item->url; ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle <?= ($current_url == $url) ? 'active' : '' ?> <?= !empty($item->children) ? 'has-children' : '' ?>" href="<?= $url ?>" id="menu-item-<?= $index ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
				<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis">
					<div class="px-xl-5 d-inline-block">
						<a class="lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#searchModal" aria-controls="searchModal" aria-expanded="false">
							<svg class="icon icon-magnifying-glass-light">
								<use xlink:href="#icon-magnifying-glass-light"></use>
							</svg>
						</a>
					</div>
					<div class="px-5 d-none d-xl-inline-block">
						<a class="lh-1 color-inherit text-decoration-none" href="" data-bs-toggle="modal" data-bs-target="#signInModal">
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
		</div>
	</div>
</header>
