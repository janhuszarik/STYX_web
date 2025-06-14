<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3"><?= $title ?></h1>
				<p class="text-muted lead mb-0"><?= htmlspecialchars($description) ?></p>
			</div>
		</div>
	</div>
</section>
<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<section class="contact-form-section py-5" style="font-family: 'Poppins', Arial, sans-serif; font-size: 14px;">
	<div class="container">
		<div class="row">
			<!-- Ľavá strana: formulár -->
			<div class="col-lg-7 mb-4 mb-lg-0">
				<h2 class="font-weight-bold mb-3">Kontaktformular</h2>
				<form id="kontaktFormular" action="<?= base_url('kontakt/send') ?>" method="post">
					<div class="form-group">
						<label for="name">Name *</label>
						<input type="text" name="name" id="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="adresse">Adresse, PLZ, Ort *</label>
						<input type="text" name="adresse" id="adresse" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="telefon">Telefon *</label>
						<input type="text" name="telefon" id="telefon" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="email">E-Mail *</label>
						<input type="email" name="email" id="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="typ">Ich bin ein</label>
						<select name="typ" id="typ" class="form-control">
							<option>Kunde</option>
							<option>Händler</option>
							<option>Partner</option>
						</select>
					</div>
					<div class="form-group">
						<label for="nachricht">Nachricht *</label>
						<textarea name="nachricht" id="nachricht" class="form-control" rows="5" required></textarea>
					</div>
					<button
						type="button"
						class="g-recaptcha btn btn-success"
						data-sitekey="<?= RECAPTCHA ?>"
						data-callback="submitForm"
						data-action="submit">
						Anfrage abschicken
					</button>


				</form>
			</div>

			<!-- Pravá strana: text + mapa -->
			<div class="col-lg-5">
				<div class="kontakt-info">
					<h4 class="font-weight-bold">STYX Naturcosmetic GmbH</h4>
					<p class="mb-2"><i class="fas fa-home me-2 text-success"></i> Am Kräutergarten 6, 3200 Ober-Grafendorf</p>

					<h4 class="font-weight-bold mt-4">STYX Shop</h4>
					<p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-success"></i> Ritzersdorfer Straße 11, 3200 Ober-Grafendorf</p>
					<p class="mb-0"><i class="fas fa-phone me-2 text-success"></i> <a href="tel:+4327473250">+43 2747 3250</a></p>
					<p class="mb-0"><i class="fas fa-phone me-2 text-success"></i> <a href="tel:+432747325010">+43 2747 3250-10</a></p>

					<p class="mt-3">
						Naturkosmetik und Bestellungen: <a href="mailto:office@styx.at">office@styx.at</a><br>
						Sponsoring und Marketing: <a href="mailto:marketing@styx.at">marketing@styx.at</a><br>
						Betriebsführungen: <a href="mailto:firmenbesichtigung@styx.at">firmenbesichtigung@styx.at</a>
					</p>
				</div>

				<!-- Mapa -->
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


