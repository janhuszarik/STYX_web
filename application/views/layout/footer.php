</div>
<footer id="footer">
	<div class="container">
		<div class="footer-ribbon">
			<span>STYX NATURCOSMETIC</span>
		</div>
		<div class="row py-5 my-4">
			<div class="col-md-6 mb-4 mb-lg-0">
				<a href="<?=BASE_URL?>" class="logo pe-0 pe-lg-3">
					<img alt="STYX Logo" src="<?=BASE_URL.LOGO1?>" class="opacity-7 bottom-4" height="80">
				</a>
				<p class="mt-2 mb-2"><?=lang('HOME_DESCRIPTION')?></p>
			</div>
			<div class="col-md-6">
				<h5 class="text-3 mb-3"><?=lang('KONTAKT')?></h5>
				<div class="row">
					<div class="col-md-6">
						<ul class="list list-icons list-icons-lg">
							<li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0"><?=COMPANY.ADRESS.'<br>'.ZIP.' '.CITY.'<br>'.COUNTRY?></p></li>
							<li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="<?=PHONE_HREF?>"><?=PHONE?></a></p></li>
							<li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:<?=MAIL_ADMIN?>"><?=MAIL_ADMIN?></a></p></li>
						</ul>
					</div>
					<?php
					$currentUrl = getCurrentUrl();
					$menuItems = getMenu();
					?>

					<div class="col-md-6">
						<ul class="list list-icons list-icons-sm">
							<?php foreach ($menuItems as $menu) { ?>
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
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="footer-copyright footer-copyright-style-3">
		<div class="container py-2">
			<div class="row py-4">
				<div class="col d-flex align-items-center justify-content-center">
					<p><?=COMPANY?> © Copyright 2009 - <?=date('Y')?>. All Rights Reserved. Powered by Jan Huszarik | Marketing & Grafik</p>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>

<!-- Vendor -->
<script src="<?=BASE_URL?>assets/vendor/plugins/js/plugins.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?=BASE_URL?>assets/js/theme.js"></script>

<!-- Theme Custom -->
<script src="<?=BASE_URL?>assets/js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?=BASE_URL?>assets/js/theme.init.js"></script>

</body>
</html>
