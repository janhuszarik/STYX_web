<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Kontaktformular Antwort</title>
</head>
<body style="font-family: Poppins, Arial, sans-serif; background-color:#f5f5f5; padding: 20px;">

<table width="100%" style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden;">

	<tr>
		<td style="padding: 20px; text-align: center;
			background-image: url('<?= BASE_URL ?>img/icon/gravientBackground.png');
			background-size: cover;
			background-repeat: repeat;
			background-position: center;">
			<img src="<?= BASE_URL . LOGOGREENPNG ?>" alt="STYX Logo" width="120" style="background: rgba(255,255,255,0.6); padding: 6px; border-radius: 6px;">
		</td>
	</tr>

	<tr>
		<td style="padding: 30px;">
			<p style="font-size: 18px;">Sehr geehrte/r <?= htmlspecialchars($name) ?>,</p>
			<p>vielen Dank für Ihre Nachricht an <b>STYX Naturcosmetic</b>.<br>
				Wir haben Ihre Anfrage erhalten und werden uns schnellstmöglich bei Ihnen melden.</p>

			<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc; width: 50%;">

			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td style="font-size: 12px; color: #555; vertical-align: top;">
						Mit freundlichen Grüßen<br>
						<b>STYX Naturcosmetic GmbH</b><br>
						Am Kräutergarten 6, 3200 Ober-Grafendorf<br>
						Tel: <a href="tel:+4327473250">+43 2747 3250</a><br>
						E-Mail: <a href="mailto:office@styx.at">office@styx.at</a><br>
						Web: <a href="https://styx.at">www.styx.at</a>
					</td>
					<td style="text-align: right;">
						<a href="https://styx.shop.com" target="_blank">
							<img src="<?= BASE_URL ?>img/icon/shop.png" alt="Zum Shop" width="100" height="100" style="margin-right: 50px;">
						</a>
					</td>
				</tr>
			</table>

			<p style="margin-top: 20px; font-size: 12px;">
				<a href="<?= base_url('gdpr') ?>">Datenschutzerklärung</a>
			</p>

			<p style="font-size: 11px; color: #999; text-align: center; margin: 30px 0 10px;">
				Dies ist eine automatisch generierte E-Mail, bitte antworten Sie nicht darauf.<br>
				Falls Sie Fragen oder Probleme mit Ihrer Bestellung oder unseren Dienstleistungen haben,<br>
				zögern Sie nicht, uns über die oben genannten Telefonnummern zu kontaktieren.
			</p>
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
