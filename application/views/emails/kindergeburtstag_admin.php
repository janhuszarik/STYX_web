<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Neue Kindergeburtstag Anfrage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		@media only screen and (max-width: 600px) {
			table {
				width: 100% !important;
			}
			td {
				display: block !important;
				width: 95% !important;
				text-align: left !important;
			}
		}
	</style>
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
			<p style="font-size: 20px; margin-bottom: 10px;"><b>Neue Kindergeburtstag Anfrage</b></p>

			<table style="width:100%; border-collapse: collapse; font-size: 14px;">
				<tr><td style="font-weight:bold; padding: 6px 0;">Datum:</td><td><?= htmlspecialchars($event_date) ?> um <?= htmlspecialchars($event_time) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Kind:</td><td><?= htmlspecialchars($child_name) ?> (<?= htmlspecialchars($child_age) ?> Jahre alt)</td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Anzahl Kinder:</td><td><?= htmlspecialchars($num_children) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Kontaktperson:</td><td><?= htmlspecialchars($contact_person) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">E-Mail:</td><td><?= htmlspecialchars($email) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Telefon:</td><td><?= htmlspecialchars($phone) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Adresse:</td><td><?= htmlspecialchars($address) ?>, <?= htmlspecialchars($zip_city) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Paket:</td><td><?= htmlspecialchars($paket) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Torte:</td><td><?= htmlspecialchars($torte) ?></td></tr>
				<tr><td style="font-weight:bold; padding: 6px 0;">Jause:</td><td><?= htmlspecialchars($jause) ?></td></tr>
				<?php if (!empty($notes)): ?>
					<tr><td style="font-weight:bold; padding: 6px 0;">Anmerkung:</td><td><?= nl2br(htmlspecialchars($notes)) ?></td></tr>
				<?php endif; ?>
			</table>

			<p style="margin-top: 30px; font-size: 12px; color: #999;">
				Diese Nachricht wurde automatisch vom System gesendet.
			</p>
		</td>
	</tr>

	<tr style="background-color: #f0f0f0;">
		<td style="padding: 15px; text-align: center;">
			<p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">
				STYX Naturcosmetic GmbH
			</p>
			<p style="font-size: 12px; margin: 0;">
				Am Kräutergarten 6, 3200 Ober-Grafendorf<br>
				Tel: <a href="tel:+4327473250">+43 2747 3250</a><br>
				<a href="mailto:office@styx.at">office@styx.at</a> | <a href="https://www.styx.at">www.styx.at</a>
			</p>
		</td>
	</tr>

	<tr style="background-color: #e8e8e8;">
		<td style="padding: 10px; text-align: center; font-size: 11px; color: #777;">
			© <?= date('Y') ?> STYX Naturcosmetic. Alle Rechte vorbehalten.
		</td>
	</tr>

</table>

</body>
</html>
