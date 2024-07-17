
<style>
	.header-social-icons {
		padding: 0;
		margin: 0;
		list-style: none;
		display: flex;
		gap: 10px;
	}
	.header-social-icons li a {
		font-size: 20px;
		color: #333;
		transition: color 0.3s ease;
	}
	.header-social-icons li a:hover {
		color: #007bff;
	}
</style>

<body data-plugin-page-transition>
<div class="body">
	<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
		<div class="header-body header-body-bottom-border border-top-0">
			<!-- Social Media and Contact Information Section -->
			<div class="contact-info d-none d-lg-block" style="border-bottom: 1px solid #ddd; padding-bottom: 10px;">
				<div class="container">
					<div class="row">
						<div class="col">
							<ul class="header-social-icons social-icons">
								<li><a href="https://www.facebook.com/www.styx.at/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="https://www.instagram.com/styx.naturcosmetic/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
								<li><a href="https://at.pinterest.com/styxnaturcosmetic/" target="_blank" title="Pinterest"><i class="fab fa-pinterest"></i></a></li>
								<li><a href="https://www.youtube.com/channel/UCxpLOYYahcENUfVnacBvagA" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a></li>
								<li><a href="mailto:info@styx.at" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>
							</ul>
						</div>
						<div class="col">
							<div class="nav-item nav-item-anim-icon d-none d-sm-block">
								<div style="padding: 5px" class="d-flex">
									<?php foreach (getLanguages() as $l){ ?>
										<div class="active lang me-2">
											<a href="<?= BASE_URL . $l ?>"><img src="<?= langInfo($l)['flag'] ?>" width="40px" alt=""></a>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-container header-container-height-md container">
				<div class="header-row">
					<div class="header-column justify-content-center w-auto-mobile w-50 order-3 order-lg-1">
						<div class="header-nav justify-content-start header-nav-line header-nav-bottom-line">
							<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
								<nav class="collapse">
									<ul class="nav nav-pills" id="mainNav">
										<?php $currentUrl = getCurrentUrl(); ?>
										<?php foreach (getMenu() as $menu) { ?>
											<li class="nav-item dropdown <?= $menu['url'] == $currentUrl ? 'active' : '' ?>">
												<?php if ($menu['base'] !== 0) { ?>
													<a class="nav-link dropdown-toggle no-link" href="javascript:void(0);">
														<?= $menu['name'] ?>
														<?php if ($menu['has_child']) { ?>
															<i class="fa fa-angle-down"></i>
														<?php } ?>
													</a>
												<?php } else { ?>
													<a class="nav-link dropdown-toggle" href="<?= $menu['is_external'] ? $menu['url'] : BASE_URL . $menu['url'] ?>" target="<?= $menu['is_external'] ? '_blank' : '_self' ?>">
														<?= $menu['name'] ?>
														<?php if ($menu['has_child']) { ?>
															<i class="fa fa-angle-down"></i>
														<?php } ?>
													</a>
												<?php } ?>
												<?php if ($menu['has_child']) { ?>
													<ul class="dropdown-menu">
														<?php foreach ($menu['children'] as $subMenu) { ?>
															<li><a class="dropdown-item" href="<?= $subMenu['is_external'] ? $subMenu['url'] : BASE_URL . $subMenu['url'] ?>" target="<?= $subMenu['is_external'] ? '_blank' : '_self' ?>"><?= $subMenu['name'] ?></a></li>
														<?php } ?>
													</ul>
												<?php } ?>
											</li>
										<?php } ?>
									</ul>
								</nav>
							</div>
							<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
								<i class="fas fa-bars"></i>
							</button>
						</div>
					</div>
					<div class="header-column justify-content-center order-1 order-lg-2">
						<div class="header-row">
							<div class="header-logo">
								<a href="index.html">
									<img alt="Porto" width="150" height="80" data-sticky-width="82" data-sticky-height="40" src="<?=BASE_URL.LOGO?>">
								</a>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-center w-100-mobile w-50 order-2 order-lg-3">
						<div class="header-row justify-content-end">
							<ul class="nav nav-pills">
								<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show nav-item-hide">
									<div class="container">
										<a href="<?=lang('HÄNDLER_URL')?>"><button class="aroma-button">
												<?=lang('HÄNDLER_TEXT')?>
											</button></a>
									</div>
								</li>
								<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show nav-item-hide">
									<div class="container">
										<a href="https://shop.styx.at/"><button class="pulse-button">
												<span style="font-weight: bold" </span> SHOP
											</button></a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var toggles = document.querySelectorAll(".dropdown-toggle");
			toggles.forEach(function(toggle) {
				toggle.addEventListener("click", function(e) {
					if (window.innerWidth <= 768) {
						e.preventDefault();
						var menu = this.nextElementSibling;
						if (menu.style.display === "block") {
							menu.style.display = "none";
						} else {
							menu.style.display = "block";
						}
					}
				});
			});
		});
	</script>
</div>
</body>
