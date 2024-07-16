<style>
	.translucent-background {
		background-color: rgba(209, 209, 209, 0.64); /* Semi-transparent gray */
		backdrop-filter: blur(5px); /* Frosted glass effect */
		-webkit-backdrop-filter: blur(5px); /* For Safari */
		padding: 20px; /* Adding padding for better text readability */
		border-radius: 10px; /* Optional: rounded corners for a softer look */
	}
</style>
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
										<a class="nav-link ps-0" href="<?=lang('HÄNDLER_URL')?>"><i class="fas fa-angle-right"></i> <?=lang('HÄNDLER_TEXT')?></a>
									</li>
									<li class="nav-item nav-item-anim-icon d-none d-md-block">
										<a class="nav-link" href="<?=BASE_URL.'kontakt'?>"><i class="fas fa-angle-right"></i> <?=lang('CONTACT_US')?></a>
									</li>
									<li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
										<div class="d-flex">
											<?php foreach (getLanguages() as $l){ ?>
												<div class="active lang me-2">
													<a href="<?= BASE_URL . $l ?>"><img src="<?= langInfo($l)['flag'] ?>" width="25px" alt=""></a>
												</div>
											<?php } ?>
										</div>
									</li>
									<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-sm-show nav-item-hide">
										<span class="ws-nowrap"><a href="<?=PHONE_HREF?>"><i class="fas fa-phone"></i> <?=PHONE?></a></span>
									</li>
								</ul>

							</nav>
							<div class="header-nav-features header-nav-hide">
								<div class="header-nav-feature header-nav-features-search d-inline-flex ">
									<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search">
										<i class="fas fa-search header-nav-top-icon"></i>
									</a>
									<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
										<form role="search" action="<?php echo base_url('search'); ?>" method="get">
											<div class="simple-search input-group">
												<input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
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
													<a class="nav-link dropdown-toggle" href="<?= $menu['is_external'] ? $menu['url'] : BASE_URL . $menu['url'] ?>" target="<?= $menu['is_external'] ? '_blank' : '_self' ?>">
														<?= $menu['name'] ?>
														<?php if ($menu['has_child']) { ?>
															<i class="fa fa-angle-down"></i>
														<?php } ?>
													</a>
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
<?php
// Assuming you have a variable or function to determine if it's the homepage
$is_homepage = basename($_SERVER['PHP_SELF']) == 'index.php'; // Example check for homepage

if (!$is_homepage):
	?>
	<div role="main" class="main">
		<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-primary overlay-show overlay-op-9 mb-0" style="background-image: url(<?=$image1?>);">
			<div class="container translucent-background">
				<div class="row">
					<div class="col align-self-center p-static text-center">
						<h1 style="color: #0a0a0a"><strong><?=$title?></strong></h1>
						<span style="color: #0a0a0a" class="sub-title"><?=$description?></span>
					</div>
				</div>
			</div>
		</section>
		<section class="page-header bg-color-light border-bottom border-width-2 translucent-background">
			<div class="container">
				<div class="row">
					<div class="col align-self-center p-static">
						<ul class="breadcrumb d-block">
							<li><a href="<?=BASE_URL?>">Home</a></li>
							<li class="active"><?=$title?></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
	</div>
<?php
endif;
?>

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
