<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Vielen Dank für Ihre Anfrage</title>
	<style>
		body { font-family: Arial, sans-serif; color: #333; }
		h2 { color: #005600; }
		ul { padding-left: 20px; }
		strong { font-weight: bold; }
	</style>
</head>
<body>
<h2>Vielen Dank für Ihre Gruppenführungsanfrage</h2>

<p>Sehr geehrte/r <?= htmlspecialchars($name ?? '') ?>,</p>

<p>
	vielen Dank für Ihre Anfrage für eine Gruppenführung bei STYX.<br>
	Wir melden uns baldmöglichst bei Ihnen.
</p>

<h3>Zusammenfassung Ihrer Anfrage:</h3>

<p>
	Wir danken Ihnen für Ihre neue Gruppenführungsanfrage
	am <?= htmlspecialchars($event_date ?? '-') ?> für eine <?= htmlspecialchars($group_type ?? '-') ?>.
</p>

<ul>
	<li><strong>Kontaktperson:</strong> <?= htmlspecialchars($name ?? '-') ?></li>
	<li><strong>Telefonnummer:</strong> <?= htmlspecialchars($phone ?? '-') ?></li>
	<li><strong>E-Mail:</strong> <?= htmlspecialchars($email ?? '-') ?></li>
	<li><strong>Organisation:</strong> <?= htmlspecialchars($organization ?? '-') ?></li>
	<li><strong>Teilnehmeranzahl:</strong> <?= htmlspecialchars($num_persons ?? '-') ?></li>
	<li><strong>Gewählte Tour:</strong> <?= htmlspecialchars($tour_type ?? '-') ?></li>
</ul>
<?php if (!empty($gold_option)): ?>
	<p><strong>Gold-Extras:</strong>
		<?= is_array($gold_option) ? htmlspecialchars(implode(', ', $gold_option)) : htmlspecialchars($gold_option) ?>
	</p>
<?php endif; ?>
<?php if (!empty($paket)): ?>
	<p><strong>Sie haben folgendes Paket gewählt:</strong> <?= htmlspecialchars($paket) ?></p>
<?php endif; ?>

<?php if (!empty($extras_gold)): ?>
	<p><strong>Gold-Extras:</strong> <?= htmlspecialchars($extras_gold) ?></p>
<?php endif; ?>

<?php if (!empty($extras_silber)): ?>
	<p><strong>Silber-Extras:</strong> <?= htmlspecialchars($extras_silber) ?></p>
<?php endif; ?>

<?php if (!empty($zahlung)): ?>
	<p><strong>Zahlungsart:</strong> <?= htmlspecialchars($zahlung) ?></p>
<?php endif; ?>

<?php if (!empty($rechnung_adresse) && $rechnung_adresse === 'andere' && !empty($andere_adresse)): ?>
	<p><strong>Abweichende Rechnungsadresse:</strong><br><?= nl2br(htmlspecialchars($andere_adresse)) ?></p>
<?php endif; ?>

<br>
<p>Mit freundlichen Grüßen,<br>Ihr STYX Erlebniswelt Team</p>
</body>
</html>
