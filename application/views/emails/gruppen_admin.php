<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Neue Gruppenführungsanfrage</title>
</head>
<body style="font-family: Poppins, Arial, sans-serif; background-color:#f5f5f5; padding: 20px;">
<table width="100%" style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden;">
	<tr>
		<td style="padding: 20px; text-align: center;
			background-image: url('<?= BASE_URL ?>img/icon/gravientBackground.png');
			background-size: cover;
			background-repeat: repeat;
			background-position: center;">
			<img src="<?= BASE_URL . LOGOGREENPNG ?>" alt="STYX Logo" width="180" style="background: rgba(255,255,255,0.6); padding: 6px; border-radius: 6px;">
		</td>
	</tr>
	<tr>
		<td style="padding: 20px 30px 3px 30px;">
			<p style="font-size: 20px; font-weight: bold;">Neue Gruppenführungsanfrage</p>

			<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc; width: 100%;">

			<h3 style="margin-bottom: 10px;">Alle Übermittelten Daten:</h3>
			<ul style="padding-left: 20px;">
				<li><strong>Datum der Führung:</strong> <?= !empty($event_date) ? date('d.m.Y', strtotime($event_date)) : 'Nicht angegeben' ?></li>
				<li><strong>Gruppentyp:</strong> <?= $group_type ?? 'Nicht angegeben' ?></li>
				<li><strong>Organisation:</strong> <?= $organization ?? 'Nicht angegeben' ?></li>
				<li><strong>Kontaktperson:</strong> <?= $name ?? 'Nicht angegeben' ?></li>
				<li><strong>Telefonnummer:</strong> <?= $phone ?? 'Nicht angegeben' ?></li>
				<li><strong>E-Mail:</strong> <?= $email ?? 'Nicht angegeben' ?></li>
				<li><strong>Straße:</strong> <?= $street ?? 'Nicht angegeben' ?></li>
				<li><strong>PLZ / Ort:</strong> <?= $zip_city ?? 'Nicht angegeben' ?></li>
				<li><strong>Teilnehmeranzahl:</strong> <?= $num_persons ?? 'Nicht angegeben' ?></li>
				<li><strong>Gewählte Tour:</strong> <?= $tour_type ?? 'Nicht angegeben' ?></li>
				<li><strong>Zahlungsart:</strong> <?= $zahlung ?? 'Nicht angegeben' ?></li>
				<li><strong>Gold-Option:</strong> <?= !empty($gold_option) ? (is_array($gold_option) ? implode(', ', $gold_option) : $gold_option) : 'Keine' ?></li>
				<li><strong>Gold-Extras:</strong> <?= !empty($extras_gold) ? (is_array($extras_gold) ? implode(', ', $extras_gold) : $extras_gold) : 'Keine' ?></li>
				<li><strong>Silber-Extras:</strong> <?= !empty($extras_silber) ? (is_array($extras_silber) ? implode(', ', $extras_silber) : $extras_silber) : 'Keine' ?></li>
				<li><strong>Kombi-Pakete:</strong> <?= !empty($paket) ? (is_array($paket) ? implode(', ', $paket) : $paket) : 'Keine' ?></li>
				<li><strong>Rechnungsadresse:</strong> <?= $rechnung_adresse ?? 'Nicht angegeben' ?></li>
				<li><strong>Andere Adresse:</strong> <?= !empty($andere_adresse) ? nl2br(htmlspecialchars($andere_adresse)) : 'Keine' ?></li>
				<li><strong>Nachricht:</strong><br><?= !empty($message) ? nl2br(htmlspecialchars($message)) : 'Keine Nachricht angegeben' ?></li>
			</ul>

			<p style="margin-top: 30px; font-size: 14px;">Bitte loggen Sie sich ins Admin-Panel ein, um weitere Schritte zu unternehmen.</p>
		</td>
	</tr>
	<tr style="background-color: #e8e8e8;">
		<td style="padding: 10px; text-align: center; font-size: 11px; color: #777;">
			&copy; <?= date('Y') ?> STYX Naturcosmetic. Alle Rechte vorbehalten. | Powered by STYX Naturcosmetic GmbH.
		</td>
	</tr>
</table>
</body>
</html>
