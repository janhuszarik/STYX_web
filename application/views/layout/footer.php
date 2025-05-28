<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 id="newsletter-heading" class="text-center font-weight-bold mb-4"><?= lang('NEWSLETTER_TITLE') ?></h1>
				<form id="newsletterForm" onsubmit="return validateNewsletterForm()" action="https://mailworx.marketingsuite.info/sys/form-submit.aspx" method="post" class="newsletter-form">
					<input type="hidden" name="frm" value="3ebb53d5-0afb-489c-b75a-493990d2e4af">
					<input type="hidden" name="acc" value="7ad42b71-86b9-450b-bfae-a9e0d961dc8c">
					<input type="hidden" name="mxCFF_empty" value="">
					<input type="hidden" name="dpl" value="email">
					<div class="row">
						<div class="col-md-4 mb-3">
							<select name="salutation" class="form-control" required>
								<option value=""><?= lang('SELECT_ANREDE')?></option>
								<option value="Frau">Frau</option>
								<option value="Herr">Herr</option>
								<option value="Divers">Divers</option>
							</select>
						</div>
						<div class="col-md-4 mb-3">
							<input type="text" name="firstname" class="form-control" placeholder="<?= lang('VORNAME') ?>">
						</div>
						<div class="col-md-4 mb-3">
							<input type="text" name="lastname" class="form-control" placeholder="<?= lang('NACHNAME') ?>">
						</div>
						<div class="col-md-12 mb-3">
							<input type="email" name="email" class="form-control" placeholder="<?= lang('EMAIL_PLACEHOLDER') ?>" required>
						</div>
						<div class="col-md-12 mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="privacy" id="privacyCheck" required>
								<label class="form-check-label" for="privacyCheck">
									<?= lang('NEWSLETTER_PRIVACY_TEXT') ?>
								</label>
							</div>
						</div>
						<div class="col-md-12 mb-3">
							<div class="g-recaptcha" data-sitekey="<?= RECAPTCHA ?>"></div>
						</div>
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-primary"><?= lang('SUBSCRIBE') ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<footer id="footer">
	<div class="container">
		<div class="footer-ribbon">
			<span><?= COMPANY ?></span>
		</div>
		<div class="row py-5 my-4">
			<div class="col-md-9 mb-4 mb-lg-0">
				<h5 class="text-3 mb-3"><?= lang('ABOUT_US')?></h5>
				<p class="mt-3 mb-3 text-white"><?=$description?></p>
				<div class="row pt-3 footer-menu">
					<?php
					$currentUrl = getCurrentUrl();
					$menuItems = getMenu();
					$columnCount = 4;
					$total = count($menuItems);
					$perColumn = ceil($total / $columnCount);
					$chunks = array_chunk($menuItems, $perColumn);
					foreach ($chunks as $column) {
						foreach ($column as $menu) {
							?>
							<div class="col-6 col-lg-3 mb-4 mb-lg-0">
								<h5 class="text-3 mb-3"><?= $menu['name'] ?></h5>
								<?php if (!empty($menu['has_child']) && !empty($menu['children'])): ?>
									<ul class="list list-icons list-icons-sm mb-0">
										<?php foreach ($menu['children'] as $subMenu): ?>
											<li>
												<i class="fas fa-angle-right"></i>
												<a class="link-hover-style-1 text-white" href="<?= $subMenu['is_external'] ? $subMenu['url'] : BASE_URL . $subMenu['url'] ?>" target="<?= $subMenu['is_external'] ? '_blank' : '_self' ?>">
													<?= $subMenu['name'] ?>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<div class="col-md-3 mb-4 mb-lg-0 footer-block">
				<h5 class="text-3 mb-3 pb-1"><?= lang('KONTAKT') ?></h5>
				<p class="text-8 font-weight-bold">
					<a href="<?= PHONE_HREF ?>" class="text-white"><?= PHONE ?></a>
				</p>
				<br>
				<ul class="list list-icons list-icons-lg">
					<li class="mb-1"><i class="far fa-dot-circle"></i>
						<p class="m-0 text-white"><?= COMPANY . '<br>' . ADRESS . '<br>' . ZIP . ' ' . CITY . '<br>' . COUNTRY ?></p>
					</li>
					<li class="mb-1"><i class="far fa-envelope"></i>
						<p class="m-0"><a class="text-white" href="mailto:<?= MAIL_ADMIN ?>"><?= MAIL_ADMIN ?></a></p>
					</li>
				</ul>
				<ul class="footer-social-icons social-icons mt-4">
					<li class="social-icons-facebook"><a href="https://www.facebook.com/www.styx.at/" target="_blank" title="Facebook"><i class="fab fa-facebook-f text-2"></i></a></li>
					<li class="social-icons-instagram"><a href="https://www.instagram.com/styx.naturcosmetic/" target="_blank" title="Instagram"><i class="fab fa-instagram text-2"></i></a></li>
					<li class="social-icons-youtube"><a href="https://www.youtube.com/channel/UCxpLOYYahcENUfVnacBvagA" target="_blank" title="YouTube"><i class="fab fa-youtube text-2"></i></a></li>
					<li class="social-icons-pinterest"><a href="https://www.pinterest.com/styxnaturcosmetic/" target="_blank" title="Pinterest"><i class="fab fa-pinterest text-2"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container py-2">
			<div class="row py-4">
				<div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
					<a href="<?= BASE_URL ?>" class="logo pe-0 pe-lg-3">
						<img alt="<?= COMPANY ?>" src="<?= BASE_URL . LOGO1 ?>" height="32">
					</a>
				</div>
				<div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
					<p class="text-white">© <?= date('Y') ?> <?= COMPANY ?>. Alle Rechte vorbehalten. Powered by <?=COMPANY?> | Marketing & Grafik</p>
				</div>
				<div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
					<nav id="sub-menu">
						<ul>
							<li><i class="fas fa-angle-right"></i><a href="<?= BASE_URL ?>faq" class="ms-1 text-white">FAQ</a></li>
							<li><i class="fas fa-angle-right"></i><a href="<?= BASE_URL ?>immpressum" class="ms-1 text-white">Impressum</a></li>
							<li><i class="fas fa-angle-right"></i><a href="<?= BASE_URL ?>contact" class="ms-1 text-white"><?= lang('KONTAKT') ?></a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>

<script>
	function validateNewsletterForm() {
		const recaptcha = grecaptcha.getResponse();
		if (!recaptcha) {
			alert("Bitte bestätigen Sie das reCAPTCHA-Feld.");
			return false;
		}
		return true;
	}
</script>

<script src="<?=BASE_URL?>assets/vendor/plugins/js/plugins.min.js"></script>
<script src="<?=BASE_URL?>assets/js/theme.js"></script>
<script src="<?=BASE_URL?>assets/js/custom.js"></script>
<script src="<?=BASE_URL?>assets/js/theme.init.js"></script>
</body>
</html>
