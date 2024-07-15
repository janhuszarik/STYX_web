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
											<a style="font-weight: bold; color: #14c500; font-size: 13px" class="nav-link ps-0" href="https://www.aroma-derm.com/login.php"><i class="fas fa-angle-right"></i> <?=lang('HÄNDLER_TEXT')?></a>
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
											<a href="mailto:<?=lang('EMAIL')?>"><i class="far fa-envelope text-4 text-color-primary" style="top: 1px;"></i><?=lang('EMAIL')?></a>
										</li>
										<li class="nav-item">
											<a href="tel:<?=lang('PHONE_NUMBER')?>"><i class="fab fa-whatsapp text-4 text-color-primary" style="top: 0;"></i> <?=lang('PHONE_NUMBER')?></a>
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
											<?php if (!empty($menuItems)): ?>
												<?php foreach ($menuItems as $index => $item): ?>
													<?php $url = empty($item->url) ? BASE_URL : $item->url; ?>
													<li class="dropdown <?= !empty($item->children) ? 'has-children' : '' ?>">
														<a class="dropdown-item <?= ($current_url == $url) ? 'active' : '' ?>" href="<?= $url ?>" data-lang="<?= $item->lang ?>">
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
																		<a class="dropdown-item <?= ($current_url == $child_url) ? 'active' : '' ?>" href="<?= $child_url ?>" data-lang="<?= $child->lang ?>">
																			<?= $child->name ?>
																		</a>
																	</li>
																<?php endforeach; ?>
															</ul>
														<?php endif; ?>
													</li>
												<?php endforeach; ?>
											<?php else: ?>
												<li><a class="dropdown-item" href="#">No menu items found</a></li>
											<?php endif; ?>
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

		function loadMenu(lang) {
			fetch(`<?=BASE_URL?>app/get_menu/${lang}`)
				.then(response => response.json())
				.then(data => {
					renderMenu(data.menuItems);
				})
				.catch(error => console.error('Error loading menu:', error));
		}

		function renderMenu(menuItems) {
			const menu = document.getElementById('mainNav');
			menu.innerHTML = ''; // Clear existing menu

			if (menuItems.length > 0) {
				menuItems.forEach(item => {
					const menuItem = document.createElement('li');
					menuItem.className = 'dropdown ' + (item.children && item.children.length ? 'has-children' : '');

					const link = document.createElement('a');
					link.className = 'dropdown-item';
					link.href = item.url || '<?=BASE_URL?>';
					link.textContent = item.name;

					if (item.children && item.children.length > 0) {
						const arrowIcon = document.createElement('i');
						arrowIcon.className = 'fas fa-angle-down ms-2';
						link.appendChild(arrowIcon);
					}

					menuItem.appendChild(link);

					if (item.children && item.children.length > 0) {
						const subMenu = document.createElement('ul');
						subMenu.className = 'dropdown-menu';

						item.children.forEach(child => {
							const subMenuItem = document.createElement('li');
							const subLink = document.createElement('a');
							subLink.className = 'dropdown-item';
							subLink.href = child.url || '<?=BASE_URL?>';
							subLink.textContent = child.name;

							subMenuItem.appendChild(subLink);
							subMenu.appendChild(subMenuItem);
						});

						menuItem.appendChild(subMenu);
					}

					menu.appendChild(menuItem);
				});
			} else {
				const noItems = document.createElement('li');
				noItems.innerHTML = '<a class="dropdown-item" href="#">No menu items found</a>';
				menu.appendChild(noItems);
			}
		}

		const currentLanguage = loadLanguage();
		setLanguage(currentLanguage);
		loadMenu(currentLanguage);

		document.querySelectorAll('.dropdown-item[data-lang]').forEach(item => {
			item.addEventListener('click', function(event) {
				event.preventDefault();
				const selectedLang = this.getAttribute('data-lang');
				saveLanguage(selectedLang);
				window.location.href = `<?=BASE_URL?>${selectedLang}/`; // Update URL and reload page
			});
		});

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
