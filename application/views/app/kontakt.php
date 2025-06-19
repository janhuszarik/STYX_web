<?php
$CI =& get_instance();
$currentLang = $CI->config->item('language'); // Ermittelt die aktuelle Sprache aus der Konfiguration
?>

<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3">
					<?= ($currentLang == 'english') ? 'Contact Form' : 'Kontaktformular' ?>
				</h1>
				<p class="text-muted lead mb-0">
					<?= htmlspecialchars(($currentLang == 'english') ? 'Get in touch with us for any inquiries or support.' : 'Kontaktieren Sie uns für Anfragen oder Unterstützung.') ?>
				</p>
			</div>
		</div>
	</div>
</section>

<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success">
		<?= ($currentLang == 'english') ? $this->session->flashdata('success') : $this->session->flashdata('success') ?>
	</div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger">
		<?= ($currentLang == 'english') ? $this->session->flashdata('error') : $this->session->flashdata('error') ?>
	</div>
<?php endif; ?>

<section class="contact-form-section py-5" style="font-family: 'Poppins', Arial, sans-serif; font-size: 14px;">
	<div class="container">
		<div class="row">
			<!-- Linke Seite: Formular -->
			<div class="col-lg-7 mb-4 mb-lg-0">
				<h2 class="font-weight-bold mb-3">
					<?= ($currentLang == 'english') ? 'Contact Form' : 'Kontaktformular' ?>
				</h2>
				<form id="kontaktFormular" action="<?= base_url('kontakt/send') ?>" method="post">
					<div class="form-group">
						<label for="name">
							<?= ($currentLang == 'english') ? 'Name *' : 'Name *' ?>
						</label>
						<input type="text" name="name" id="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="adresse">
							<?= ($currentLang == 'english') ? 'Address, ZIP, City *' : 'Adresse, PLZ, Ort *' ?>
						</label>
						<input type="text" name="adresse" id="adresse" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="telefon">
							<?= ($currentLang == 'english') ? 'Phone *' : 'Telefon *' ?>
						</label>
						<input type="text" name="telefon" id="telefon" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="email">
							<?= ($currentLang == 'english') ? 'E-Mail *' : 'E-Mail *' ?>
						</label>
						<input type="email" name="email" id="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="typ">
							<?= ($currentLang == 'english') ? 'I am a' : 'Ich bin ein' ?>
						</label>
						<select name="typ" id="typ" class="form-control">
							<option><?= ($currentLang == 'english') ? 'Customer' : 'Kunde' ?></option>
							<option><?= ($currentLang == 'english') ? 'Retailer' : 'Händler' ?></option>
							<option><?= ($currentLang == 'english') ? 'Partner' : 'Partner' ?></option>
						</select>
					</div>
					<div class="form-group">
						<label for="nachricht">
							<?= ($currentLang == 'english') ? 'Message *' : 'Nachricht *' ?>
						</label>
						<textarea name="nachricht" id="nachricht" class="form-control" rows="5" required></textarea>
					</div>
					<button
						type="button"
						class="g-recaptcha btn btn-success"
						data-sitekey="<?= RECAPTCHA ?>"
						data-callback="submitForm"
						data-action="submit">
						<?= ($currentLang == 'english') ? 'Submit Request' : 'Anfrage abschicken' ?>
					</button>
				</form>
			</div>

			<!-- Rechte Seite: Text + Karte -->
			<div class="col-lg-5">
				<div class="kontakt-info">
					<h4 class="font-weight-bold">
						<?= ($currentLang == 'english') ? 'STYX Naturcosmetic GmbH' : 'STYX Naturcosmetic GmbH' ?>
					</h4>
					<p class="mb-2">
						<i class="fas fa-home me-2 text-success"></i>
						<?= ($currentLang == 'english') ? 'Am Kräutergarten 6, 3200 Ober-Grafendorf' : 'Am Kräutergarten 6, 3200 Ober-Grafendorf' ?>
					</p>

					<h4 class="font-weight-bold mt-4">
						<?= ($currentLang == 'english') ? 'STYX Shop' : 'STYX Shop' ?>
					</h4>
					<p class="mb-0">
						<i class="fas fa-map-marker-alt me-2 text-success"></i>
						<?= ($currentLang == 'english') ? 'Ritzersdorfer Straße 11, 3200 Ober-Grafendorf' : 'Ritzersdorfer Straße 11, 3200 Ober-Grafendorf' ?>
					</p>
					<p class="mb-0">
						<i class="fas fa-phone me-2 text-success"></i>
						<a href="tel:+4327473250"><?= ($currentLang == 'english') ? '+43 2747 3250' : '+43 2747 3250' ?></a>
					</p>
					<p class="mb-0">
						<i class="fas fa-phone me-2 text-success"></i>
						<a href="tel:+432747325010"><?= ($currentLang == 'english') ? '+43 2747 3250-10' : '+43 2747 3250-10' ?></a>
					</p>

					<p class="mt-3">
						<?= ($currentLang == 'english') ? 'Natural cosmetics and orders: ' : 'Naturkosmetik und Bestellungen: ' ?>
						<a href="mailto:office@styx.at"><?= ($currentLang == 'english') ? 'office@styx.at' : 'office@styx.at' ?></a><br>
						<?= ($currentLang == 'english') ? 'Sponsoring and marketing: ' : 'Sponsoring und Marketing: ' ?>
						<a href="mailto:marketing@styx.at"><?= ($currentLang == 'english') ? 'marketing@styx.at' : 'marketing@styx.at' ?></a><br>
						<?= ($currentLang == 'english') ? 'Company tours: ' : 'Betriebsführungen: ' ?>
						<a href="mailto:firmenbesichtigung@styx.at"><?= ($currentLang == 'english') ? 'firmenbesichtigung@styx.at' : 'firmenbesichtigung@styx.at' ?></a>
					</p>
				</div>

				<!-- Karte -->
				<div class="mt-4">
					<iframe src="https://www.google.com/maps?q=Am+Kräutergarten+6,+3200+Ober-Grafendorf&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
	function submitForm(token) {
		document.getElementById('kontaktFormular').submit();
	}
</script>
