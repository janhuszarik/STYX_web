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
<section class="container py-5" style="max-width: 500px; margin: auto;">
	<h2 class="mb-4 text-center">Presse Login</h2>

	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
	<?php endif; ?>

	<form id="presseLoginForm" action="<?= base_url('aktuelles/download-presse-login') ?>" method="post">
		<div class="form-group mb-3">
			<label for="username">Benutzername *</label>
			<input type="text" name="username" id="username" class="form-control" required>
		</div>

		<div class="form-group mb-4">
			<label for="password">Passwort *</label>
			<input type="password" name="password" id="password" class="form-control" required>
		</div>

		<!-- Invisible reCAPTCHA tlačidlo -->
		<button
			type="button"
			class="g-recaptcha btn btn-primary w-100"
			data-sitekey="<?= RECAPTCHA ?>"
			data-callback="submitForm"
			data-action="submit">
			Einloggen und PDF öffnen
		</button>
	</form>
</section>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
	function submitForm(token) {
		document.getElementById('presseLoginForm').submit();
	}
</script>
