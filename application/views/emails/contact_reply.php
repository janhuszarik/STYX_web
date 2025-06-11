<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Kontaktformular Antwort</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f5f5f5; padding: 20px;">

<table width="100%" style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden;">

	<!-- HLAVIČKA -->
	<tr>
		<td style="padding: 20px; text-align: center;
			background-image: url('<?= BASE_URL ?>img/bg/email_bg.png');
			background-size: cover;
			background-repeat: repeat;
			background-position: center;">
			<img src="<?= BASE_URL . LOGOBLACKPNG ?>" alt="STYX Logo" width="120" style="background: rgba(255,255,255,0.6); padding: 6px; border-radius: 6px;">
		</td>
	</tr>

	<!-- OBSAH EMAILU -->
	<tr>
		<td style="padding: 30px;">
			<p style="font-size: 18px;">Sehr geehrte/r <?= htmlspecialchars($name) ?>,</p>
			<p>vielen Dank für Ihre Nachricht an <b>STYX Naturcosmetic</b>.<br>
				Wir haben Ihre Anfrage erhalten und werden uns schnellstmöglich bei Ihnen melden.</p>

			<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc; width: 50%;">

			<!-- Adresa + obrázok doprava -->
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td style="font-size: 14px; color: #555; vertical-align: top;">
						Mit freundlichen Grüßen<br>
						<b>STYX Naturcosmetic GmbH</b><br>
						Am Kräutergarten 6, 3200 Ober-Grafendorf<br>
						Tel: <a href="tel:+4327473250">+43 2747 3250</a><br>
						E-Mail: <a href="mailto:office@styx.at">office@styx.at</a><br>
						Web: <a href="https://styx.at">www.styx.at</a>
					</td>
					<td style="text-align: right;">
						<a href="https://styx.shop.com" target="_blank">
							<img src="<?= BASE_URL ?>img/icons/cart.png" alt="Zum Shop" width="48" height="48" style="margin-left: 10px;">
						</a>
					</td>
				</tr>
			</table>

			<p style="margin-top: 20px; font-size: 12px;">
				<a href="<?= base_url('gdpr') ?>">Datenschutzerklärung</a>
			</p>

			<!-- Info o e-maile -->
			<p style="font-size: 12px; color: #999; text-align: center; margin: 30px 0 10px;">
				Dies ist eine automatisch generierte E-Mail, bitte antworten Sie nicht darauf.<br>
				Falls Sie Fragen oder Probleme mit Ihrer Bestellung oder unseren Dienstleistungen haben,<br>
				zögern Sie nicht, uns über die oben genannten Telefonnummern zu kontaktieren.
			</p>
		</td>
	</tr>

	<!-- SOCIÁLNE SIETE -->
	<tr style="background-color: #f0f0f0;">
		<td style="padding: 15px; text-align: center;">
			<a href="https://www.facebook.com/STYX.Naturcosmetic/" style="margin: 0 10px;">
				<img src="<?= base_url('img/icon/facebook.png') ?>" width="24" height="24" alt="Facebook">
			</a>
			<a href="https://www.instagram.com/styx_naturcosmetic/" style="margin: 0 10px;">
				<img src="<?= base_url('img/icon/instagram.png') ?>" width="24" height="24" alt="Instagram">
			</a>
			<a href="https://www.youtube.com/@STYXNaturcosmetic" style="margin: 0 10px;">
				<img src="<?= base_url('img/icon/youtube.png') ?>" width="24" height="24" alt="YouTube">
			</a>
			<a href="mailto:office@styx.at" style="margin: 0 10px;">
				<img src="<?= base_url('img/icon/email.png') ?>" width="24" height="24" alt="E-Mail">
			</a>
		</td>
	</tr>

	<!-- FOOTER -->
	<tr style="background-color: #e8e8e8;">
		<td style="padding: 10px; text-align: center; font-size: 11px; color: #777;">
			&copy; <?= date('d.m.Y') ?> STYX Naturcosmetic. Alle Rechte vorbehalten. | Powered by Jan Huszarik
		</td>
	</tr>

</table>

</body>
</html>
