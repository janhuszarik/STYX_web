
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
			<ul style="padding-left: 20px; font-size: 14px; line-height: 1.6;">
				<li><strong>Datum der Führung:</strong> <?= !empty($event_date) ? date('d.m.Y', strtotime($event_date)) : 'Nicht angegeben' ?></li>
				<li><strong>Gruppentyp:</strong> <?= htmlspecialchars($group_type ?? 'Nicht angegeben') ?></li>
				<li><strong>Organisation:</strong> <?= htmlspecialchars($organization ?? 'Nicht angegeben') ?></li>
				<li><strong>Kontaktperson:</strong> <?= htmlspecialchars($name ?? 'Nicht angegeben') ?></li>
				<li><strong>Telefonnummer:</strong> <?= htmlspecialchars($phone ?? 'Nicht angegeben') ?></li>
				<li><strong>E-Mail:</strong> <?= htmlspecialchars($email ?? 'Nicht angegeben') ?></li>
				<li><strong>Straße:</strong> <?= htmlspecialchars($street ?? 'Nicht angegeben') ?></li>
				<li><strong>PLZ / Ort:</strong> <?= htmlspecialchars($zip_city ?? 'Nicht angegeben') ?></li>
				<li><strong>Teilnehmeranzahl:</strong> <?= htmlspecialchars($num_persons ?? 'Nicht angegeben') ?></li>
				<li><strong>Gewählte Tour:</strong> <?= htmlspecialchars($tour_type ?? 'Nicht angegeben') ?></li>
				<li><strong>Zahlungsart:</strong> <?= htmlspecialchars($zahlung ?? 'Nicht angegeben') ?></li>
				<li><strong>Gold-Option:</strong> <?= !empty($gold_option) ? htmlspecialchars(is_array($gold_option) ? implode(', ', $gold_option) : $gold_option) : 'Keine' ?></li>
				<li><strong>Gold-Extras:</strong> <?= !empty($extras_gold) ? htmlspecialchars(is_array($extras_gold) ? implode(', ', $extras_gold) : $extras_gold) : 'Keine' ?></li>
				<li><strong>Silber-Extras:</strong> <?= !empty($extras_silber) ? htmlspecialchars(is_array($extras_silber) ? implode(', ', $extras_silber) : $extras_silber) : 'Keine' ?></li>
				<li><strong>Kombi-Pakete:</strong> <?= !empty($paket) ? htmlspecialchars(is_array($paket) ? implode(', ', $paket) : $paket) : 'Keine' ?></li>
				<li><strong>Rechnungsadresse:</strong> <?= htmlspecialchars($rechnung_adresse ?? 'Nicht angegeben') ?></li>
				<li><strong>Andere Adresse:</strong><br><?= !empty($andere_adresse) ? nl2br(htmlspecialchars($andere_adresse)) : 'Keine' ?></li>
				<li><strong>Nachricht:</strong><br><?= !empty($message) ? nl2br(htmlspecialchars($message)) : 'Keine Nachricht angegeben' ?></li>
			</ul>
		</td>
	</tr>
	<tr style="background-color: #f0f0f0;">
		<td style="padding: 15px; text-align: center;">

			<p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">
				Versuchen Sie auch unsere App für Ihr mobiles Gerät:
			</p>

			<a href="https://play.google.com/store/apps/details?id=at.helloagain.styx" style="margin: 0 5px; text-decoration: none;">
				<img src="<?= base_url('img/icon/android_app.png') ?>"  alt="Google Play">
			</a>
			<a href="https://apps.apple.com/app/id6743492896" style="margin: 0 5px; text-decoration: none;">
				<img src="<?= base_url('img/icon/apple_app.png') ?>"  alt="App Store">
			</a>

			<div style="margin-top: 20px;">
				<a href="https://www.facebook.com/STYX.Naturcosmetic/" style="margin: 0 10px; text-decoration: none;">
					<img src="<?= base_url('img/icon/facebook.png') ?>" width="24" height="24" alt="Facebook">
				</a>
				<a href="https://www.instagram.com/styx_naturcosmetic/" style="margin: 0 10px; text-decoration: none;">
					<img src="<?= base_url('img/icon/instagram.png') ?>" width="24" height="24" alt="Instagram">
				</a>
				<a href="https://www.youtube.com/@STYXNaturcosmetic" style="margin: 0 10px; text-decoration: none;">
					<img src="<?= base_url('img/icon/youtube.png') ?>" width="24" height="24" alt="YouTube">
				</a>
				<a href="mailto:office@styx.at" style="margin: 0 10px; text-decoration: none;">
					<img src="<?= base_url('img/icon/email.png') ?>" width="24" height="24" alt="E-Mail">
				</a>
			</div>
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
