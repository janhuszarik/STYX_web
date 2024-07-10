<body data-plugin-page-transition>
<div class="body">
	<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
		<div class="header-body border-color-primary border-bottom-0">
			<div class="header-top header-top-simple-border-bottom">
				<div class="container">
					<div class="header-row py-2">
						<div class="header-column justify-content-start">
							<div class="header-row">
								<nav class="header-nav-top">
									<ul class="nav nav-pills text-uppercase text-2">
										<li class="nav-item nav-item-anim-icon d-none d-md-block">
											<a style="font-weight: bold; color: #14c500; font-size: 13px" class="nav-link ps-0" href="https://www.aroma-derm.com/login.php"><i class="fas fa-angle-right"></i> <?=lang('PRICE_HEADER')?></a>
										</li>

										<li class="nav-item dropdown nav-item-left-border d-none d-sm-block nav-item-left-border-remove nav-item-left-border-md-show">
											<a class="nav-link" href="#" role="button" id="dropdownLanguage" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<img id="languageFlag" src="<?=BASE_URL?>assets/img/blank.gif" class="flag" alt="Language" />
												<span id="languageText">Language</span>
												<i class="fas fa-angle-down"></i>
											</a>
											<div class="dropdown-menu" aria-labelledby="dropdownLanguage">
												<a class="dropdown-item" href="#" data-lang="en"><img src="<?=BASE_URL?>assets/img/blank.gif" class="flag flag-us" alt="English" /> English</a>
												<a class="dropdown-item" href="#" data-lang="de"><img src="<?=BASE_URL?>assets/img/blank.gif" class="flag flag-at" alt="Deutsch" /> Deutsch</a>
											</div>
										</li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="header-column justify-content-end">
							<div class="header-row">
								<nav class="header-nav-top">
									<ul class="nav nav-pills">
										<li class="nav-item">
											<a href="mailto:mail@domain.com"><i class="far fa-envelope text-4 text-color-primary" style="top: 1px;"></i> mail@domain.com</a>
										</li>
										<li class="nav-item">
											<a href="tel:123-456-7890"><i class="fab fa-whatsapp text-4 text-color-primary" style="top: 0;"></i> 123-456-7890</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-container container">
				<div class="header-row">
					<div class="header-column">
						<div class="header-row">
							<div class="header-logo">
								<a href="<?=BASE_URL?>">
									<img alt="STYX Logo" width="150" height="80" data-sticky-width="82" data-sticky-height="40" src="<?=BASE_URL.LOGO?>">
								</a>
							</div>
						</div>
					</div>
					<div class="header-column justify-content-end">
						<div class="header-row">
							<div class="header-nav header-nav-line header-nav-bottom-line">
								<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
									<nav class="collapse">
										<ul class="nav nav-pills flex-column flex-lg-row" id="mainNav">
											<?php foreach ($menuItems as $index => $item): ?>
												<?php $url = empty($item->url) ? BASE_URL : $item->url; ?>
												<li class="dropdown <?= !empty($item->children) ? 'has-children' : '' ?>">
													<a class="dropdown-item <?= ($current_url == $url) ? 'active' : '' ?>" href="<?= $url ?>">
														<?= $item->name ?>
														<?php if (!empty($item->children)): ?>
															<i class="fas fa-angle-down ms-2"></i>
														<?php endif; ?>
													</a>
													<?php if (!empty($item->children)): ?>
														<ul class="dropdown-menu">
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

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Skript na nastavenie aktuálneho jazyka
		const languageMap = {
			'en': {
				flagClass: 'flag-us',
				text: 'English'
			},
			'de': {
				flagClass: 'flag-at',
				text: 'Deutsch'
			}
		};

		function setLanguage(lang) {
			const flagImg = document.getElementById('languageFlag');
			const langText = document.getElementById('languageText');

			if (languageMap[lang]) {
				flagImg.className = 'flag ' + languageMap[lang].flagClass;
				flagImg.alt = languageMap[lang].text;
				langText.textContent = languageMap[lang].text;
			}
		}

		function saveLanguage(lang) {
			localStorage.setItem('selectedLanguage', lang);
		}

		function loadLanguage() {
			return localStorage.getItem('selectedLanguage') || 'de';
		}

		const currentLanguage = loadLanguage();
		setLanguage(currentLanguage);

		document.querySelectorAll('.dropdown-item').forEach(item => {
			item.addEventListener('click', function(event) {
				event.preventDefault();
				const selectedLang = this.getAttribute('data-lang');
				saveLanguage(selectedLang);
				setLanguage(selectedLang);
				// Presmerovanie na novú URL
				window.location.href = selectedLang === 'en' ? '<?=BASE_URL?>en' : '<?=BASE_URL?>de';
			});
		});

		// Skript na prepínanie submenu
		const menuItemsWithChildren = document.querySelectorAll('.has-children > a');

		menuItemsWithChildren.forEach(item => {
			item.addEventListener('click', function(event) {
				event.preventDefault();
				const submenu = this.nextElementSibling;
				if (submenu.style.display === 'block') {
					submenu.style.display = 'none';
				} else {
					submenu.style.display = 'block';
				}
			});
		});
	});
</script>

</body>
