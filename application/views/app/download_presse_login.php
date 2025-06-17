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
