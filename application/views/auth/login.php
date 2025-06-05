<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?? 'Anmeldung' ?></title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="<?= BASE_URL ?>img/icon/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login/my-custom.css">

</head>
<body>

<div class="login-container">
	<div class="logo">
		<a href="<?= BASE_URL ?>">
			<img src="<?= BASE_URL . LOGO ?>" alt="Logo">
		</a>
	</div>

	<h3>Anmeldung im Konto</h3>

	<form method="post" action="<?= BASE_URL ?>login">
		<div class="form-group">
			<?= form_input($identity, '', 'class="form-control" placeholder="E-Mail-Adresse"') ?>
		</div>
		<div class="form-group">
			<?= form_input($password, '', 'class="form-control" placeholder="Passwort"') ?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn-login">Einloggen</button>
		</div>
	</form>
</div>

</body>
</html>
