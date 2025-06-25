<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Vielen Dank für Ihre Anfrage</title>
</head>
<body>
<h2>Vielen Dank für Ihre Gruppenführungsanfrage</h2>
<p>Sehr geehrte/r <?= htmlspecialchars($name) ?>,</p>

<p>vielen Dank für Ihre Anfrage zu einer Gruppenführung bei STYX Naturcosmetic GmbH. Wir werden Ihre Anfrage umgehend bearbeiten und uns schnellstmöglich mit Ihnen in Verbindung setzen.</p>

<p>Ihre übermittelten Daten im Überblick:</p>
<ul>
	<li><strong>Art der Veranstaltung:</strong> <?= htmlspecialchars($group_type) ?></li>
	<li><strong>Besuchstermin:</strong> <?= htmlspecialchars($event_date) ?></li>
	<li><strong>Organisation:</strong> <?= htmlspecialchars($organization) ?></li>
	<li><strong>Personenanzahl:</strong> <?= htmlspecialchars($num_persons) ?></li>
	<li><strong>Gewählte Tour:</strong> <?= htmlspecialchars($tour_type) ?></li>
</ul>

<p>Mit freundlichen Grüßen,<br>Ihr STYX Erlebniswelt Team</p>
</body>
</html>
