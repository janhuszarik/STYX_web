<?php // view/emails/gruppen_admin.php ?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Neue Gruppenführungsanfrage</title>
</head>
<body>
<h2>Neue Gruppenführungsanfrage</h2>
<p><strong>Art der Veranstaltung:</strong> <?= htmlspecialchars($group_type) ?></p>
<p><strong>Besuchstermin:</strong> <?= htmlspecialchars($event_date) ?></p>
<p><strong>Organisation:</strong> <?= htmlspecialchars($organization) ?></p>

<h3>Ansprechpartner</h3>
<p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
<p><strong>E-Mail:</strong> <?= htmlspecialchars($email) ?></p>
<p><strong>Telefon:</strong> <?= htmlspecialchars($phone) ?></p>
<p><strong>Straße:</strong> <?= htmlspecialchars($street) ?></p>
<p><strong>PLZ / Ort:</strong> <?= htmlspecialchars($zip_city) ?></p>

<h3>Details zur Führung</h3>
<p><strong>Personenanzahl:</strong> <?= htmlspecialchars($num_persons) ?></p>
<p><strong>Tour:</strong> <?= htmlspecialchars($tour_type) ?></p>
<p><strong>Zahlung:</strong> <?= htmlspecialchars($payment) ?></p>
<p><strong>Nachricht:</strong> <?= nl2br(htmlspecialchars($message ?? '')) ?></p>
</body>
</html>





