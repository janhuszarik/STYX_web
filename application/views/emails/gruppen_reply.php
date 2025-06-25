<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Vielen Dank für Ihre Anfrage</title>
	<style>
		body { font-family: Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #000; }
		h2 { color: #1a7b36; }
		ul { padding-left: 20px; }
		li { margin-bottom: 4px; }
	</style>
</head>
<body>
<h2>Vielen Dank für Ihre Gruppenführungsanfrage</h2>

<p>Sehr geehrte/r <?= htmlspecialchars($name ?? '') ?>,</p>

<p>vielen Dank für Ihre Anfrage für eine Gruppenführung bei STYX.<br>
	Wir melden uns baldmöglichst bei Ihnen.</p>

<h3>Zusammenfassung Ihrer Anfrage:</h3>

<p>
	Wir danken Ihnen für Ihre neue Gruppenführungsanfrage am
	<strong><?= htmlspecialchars($event_date ?? '') ?></strong>
	für eine
	<strong><?= htmlspecialchars($group_type ?? '') ?></strong>.
</p>

<p><strong>Kontaktperson:</strong> <?= htmlspecialchars($name ?? '') ?><br>
	<strong>Telefonnummer:</strong> <?= htmlspecialchars($phone ?? '') ?><br>
	<strong>E-Mail:</strong> <?= htmlspecialchars($email ?? '') ?><br>
	<strong>Organisation:</strong> <?= htmlspecialchars($organization ?? '') ?><br>
	<strong>Teilnehmeranzahl:</strong> <?= htmlspecialchars($num_persons ?? '') ?></p>

<?php if (!empty($tour_type)): ?>
	<p><strong>Gewählte Tour:</strong> <?= htmlspecialchars($tour_type) ?></p>
<?php endif; ?>

<?php if (!empty($gold_option)): ?>
	<p><strong>Gold-Option gewählt:</strong> <?= htmlspecialchars($gold_option) ?></p>
<?php endif; ?>

<?php if (!empty($schoko_option)): ?>
	<p><strong>Schoko-Option gewählt:</strong> <?= htmlspecialchars($schoko_option) ?></p>
<?php endif; ?>

<?php if (!empty($bierverkostung_option)): ?>
	<p><strong>Bierverkostung:</strong> <?= htmlspecialchars($bierverkostung_option) ?></p>
<?php endif; ?>

<?php if (!empty($kombi_paket)): ?>
	<p><strong>Kombi Paket:</strong> <?= htmlspecialchars($kombi_paket) ?></p>
<?php endif; ?>

<?php if (!empty($payment)): ?>
	<p><strong>Zahlungsart:</strong> <?= htmlspecialchars($payment) ?></p>
<?php endif; ?>

<p>Mit freundlichen Grüßen,<br>
	Ihr STYX Erlebniswelt Team</p>
</body>
</html>
