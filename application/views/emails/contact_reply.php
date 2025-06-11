<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Kontaktformular Antwort</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f5f5f5; padding: 20px;">

<table width="100%" style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden;">
	<tr style="background-color: #2b2b2b;">
		<td style="padding: 20px; text-align: center;">
			<img src="<?= BASE_URL.LOGOBLACKPNG ?>" alt="STYX Logo" width="120">
		</td>
	</tr>
	<tr>
		<td style="padding: 30px;">
			<p style="font-size: 18px;">Sehr geehrte/r <?= htmlspecialchars($name) ?>,</p>
			<p>vielen Dank für Ihre Nachricht an STYX Naturcosmetic.<br>Wir haben Ihre Anfrage erhalten und werden uns schnellstmöglich bei Ihnen melden.</p>
			<hr>
			<p style="font-size: 14px; color: #555;">
				Mit freundlichen Grüßen<br>
				<b>STYX Naturcosmetic GmbH</b><br>
				Am Kräutergarten 6, 3200 Ober-Grafendorf<br>
				Tel: <a href="tel:+4327473250">+43 2747 3250</a><br>
				E-Mail: <a href="mailto:office@styx.at">office@styx.at</a><br>
				Web: <a href="https://styx.at">www.styx.at</a>
			</p>

			<p style="margin-top: 20px; font-size: 12px;">
				<a href="<?= base_url('gdpr') ?>">Datenschutzerklärung</a>
			</p>
		</td>
	</tr>
	<tr style="background-color: #f0f0f0;">
		<td style="padding: 15px; text-align: center;">
			<a href="https://www.facebook.com/STYX.Naturcosmetic/" style="margin: 0 10px;"><img src="<?= base_url('img/icon/facebook.png') ?>" width="24" alt="Facebook"></a>
			<a href="https://www.instagram.com/styx_naturcosmetic/" style="margin: 0 10px;"><img src="<?= base_url('img/icon/instagram.png') ?>" width="24" alt="Instagram"></a>
			<a href="https://www.youtube.com/@STYXNaturcosmetic" style="margin: 0 10px;"><img src="<?= base_url('img/icon/youtube.png') ?>" width="24" alt="YouTube"></a>
			<a href="mailto:office@styx.at" style="margin: 0 10px;"><img src="<?= base_url('img/icon/email.png') ?>" width="24" alt="E-Mail"></a>
		</td>
	</tr>
</table>

</body>
</html>

