

<header id="header" class="header header-sticky header-sticky-smart disable-transition-all z-index-5">
	<div style="background-color: rgba(8,156,8,0.8)" class="topbar">
		<div class="container-xxl container">
			<p class="mb-0 text-dark-emphasis  text-center p-4 fs-15px fw-bold ls-1">
				STYX Naturcosmetic - nachhaltige Kosmetik aus Österreich
			</p>
		</div>
	</div>
	<div class="header-above">
		<div class="container-xxl container d-none d-xl-block">
			<div class="pt-8 d-flex">
				<div class="icons-actions d-flex justify-content-start w-xl-50 fs-28px text-body-emphasis">
					<form action="#" method="get" class="search-box-2 w-60">
						<div class="position-relative">
							<input type="text" name="s" class="form-control form-control bg-transparent pe-12 lh-1 py-5" placeholder="Suchen">
							<button class="position-absolute pos-fixed-right-center bg-transparent border-0 px-0 fs-4 px-6 top-0 bottom-0 end-0 my-auto z-index-3 text-body-emphasis" type="submit">
								<svg class="icon fs-18px mt-n3">
									<use xlink:href="#search"></use>
								</svg>
							</button>
						</div>
					</form>
				</div>
				<a href="/" class="navbar-brand px-8 py-4 mx-auto">
					<img class="light-mode-img" src="<?=BASE_URL.LOGO?>" width="179" height="80" alt="STYX Naturcosmetic_logo">
					<img class="dark-mode-img" src="<?=BASE_URL.LOGO1?>" width="179" height="77" alt="STYX Naturcosmetic_logo"></a>
				<div class="icons-actions d-flex justify-content-end w-xl-50 fs-28px text-body-emphasis">
					<div class="px-5 d-none d-xl-inline-block">
						<a class="lh-1 color-inherit text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#signInModal">
							<svg class="icon icon-user-light">
								<use xlink:href="#icon-user-light"></use>
							</svg>
						</a>
					</div>
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
									Hell
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
									Dunkel
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
	<div class="sticky-area">
		<div class="main-header nav navbar bg-body navbar-light navbar-expand-xl py-6 py-xl-0">
			<div class="container-xxl container">
				<div class="d-flex d-xl-none w-100">
					<div class="w-72px d-flex d-xl-none">
						<button class="navbar-toggler align-self-center  border-0 shadow-none px-0 canvas-toggle p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvasNavBar" aria-controls="offCanvasNavBar" aria-expanded="false" aria-label="Toggle Navigation">
							<span class="fs-24 toggle-icon"></span>
						</button>
					</div>
					<div class="d-flex mx-auto">
						<a href="/" class="navbar-brand px-8 py-4 mx-auto">
							<img class="light-mode-img" src="<?=BASE_URL.LOGO?>" width="179" height="80" alt="STYX Naturcosmetic_logo">
							<img class="dark-mode-img" src="<?=BASE_URL.LOGO1?>" width="179" height="80" alt="STYX Naturcosmetic_logo"></a>
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
				<style>
					@media (min-width: 1200px) {
						.navbar-nav .dropdown-menu {
							display: none;
							position: absolute;
							top: 100%;
							left: 0;
						}
						.navbar-nav .nav-item:hover .dropdown-menu {
							display: block;
						}
					}

					@media (max-width: 1199px) {
						.navbar-nav .dropdown-menu {
							display: block;
							position: relative;
							top: auto;
							left: auto;
						}
						.navbar-nav .nav-item .dropdown-toggle {
							display: none;
						}
					}
				</style>



				<div class="w-100 d-none d-xl-flex align-items-center justify-content-center">
					<ul class="navbar-nav">
						<?php foreach ($menuItems as $index => $item): ?>
							<?php $url = empty($item->url) ? BASE_URL : $item->url; ?>
							<li class="nav-item transition-all-xl-1 py-xl-7 py-0 me-xxl-12 me-xl-10 dropdown <?= !empty($item->children) ? 'dropdown-fullwidth' : '' ?>">
								<div class="d-flex align-items-center">
									<a class="nav-link d-flex justify-content-between position-relative py-xl-0 px-xl-0 fw-semibold ls-1 fs-6 fs-xl-15px text-body-emphasis <?= ($current_url == $url) ? 'active' : '' ?>" href="<?= $url ?>">
										<?= $item->name ?>
									</a>
									<?php if (!empty($item->children)): ?>
										<ul class="dropdown-menu mega-menu start-0 py-6" aria-labelledby="dropdownMenuButton-<?= $index ?>" style="width:250px">
											<?php foreach ($item->children as $child): ?>
												<?php $child_url = empty($child->url) ? BASE_URL : $child->url; ?>
												<li>
													<a class="dropdown-item border-hover <?= ($current_url == $child_url) ? 'active' : '' ?>" href="<?= $child_url ?>">
														<?= $child->name ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>



			</div>
		</div>
	</div>
</header>
