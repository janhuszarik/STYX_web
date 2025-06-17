<section class="container py-5">
	<h2 class="mb-4 text-center">Zugang zum Pressebereich</h2>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
	<?php endif; ?>
	<form method="post" action="<?= base_url('aktuelles/download-presse-login') ?>" class="w-100" style="max-width: 400px; margin: auto;">
		<div class="form-group mb-3">
			<label for="username">Benutzername</label>
			<input type="text" name="username" id="username" class="form-control" required>
		</div>
		<div class="form-group mb-3">
			<label for="password">Passwort</label>
			<input type="password" name="password" id="password" class="form-control" required>
		</div>

		<div class="form-group mb-4 text-center">
			<div class="g-recaptcha d-inline-block" data-sitekey="<?= config_item('recaptcha_site_key') ?>"></div>
		</div>

		<button type="submit" class="btn btn-primary w-100">Anmelden</button>
	</form>
</section>

<!-- reCAPTCHA JS -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
