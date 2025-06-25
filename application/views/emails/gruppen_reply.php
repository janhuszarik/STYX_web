<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Gruppenführungsanfrage Bestätigung</title>
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
			<p style="font-size: 20px;">Sehr geehrte/r <?= htmlspecialchars($name ?? '') ?>,</p>
			<p>vielen Dank für Ihre Anfrage für eine Gruppenführung bei <b>STYX Naturcosmetic</b>.<br>
				Wir melden uns baldmöglichst bei Ihnen.</p>

			<hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc; width: 100%;">

			<h3 style="margin-bottom: 10px;">Zusammenfassung Ihrer Anfrage:</h3>
			<ul style="padding-left: 20px;">
				<li><strong>Datum der Führung:</strong> <?= !empty($event_date) ? date('d.m.Y', strtotime($event_date)) : '-' ?></li>
				<li><strong>Gruppentyp:</strong> <?= htmlspecialchars($group_type ?? '-') ?></li>
				<li><strong>Kontaktperson:</strong> <?= htmlspecialchars($name ?? '-') ?></li>
				<li><strong>Telefonnummer:</strong> <?= htmlspecialchars($phone ?? '-') ?></li>
				<li><strong>E-Mail:</strong> <?= htmlspecialchars($email ?? '-') ?></li>
				<li><strong>Organisation:</strong> <?= htmlspecialchars($organization ?? '-') ?></li>
				<li><strong>Teilnehmeranzahl:</strong> <?= htmlspecialchars($num_persons ?? '-') ?></li>
				<li><strong>Gewählte Tour:</strong> <?= htmlspecialchars($tour_type ?? '-') ?></li>
				<?php if (!empty($gold_option)): ?>
					<li><strong>Gold-Option:</strong> <?= is_array($gold_option) ? htmlspecialchars(implode(', ', $gold_option)) : htmlspecialchars($gold_option) ?></li>
				<?php endif; ?>
				<?php if (!empty($extras_gold)): ?>
					<li><strong>Gold-Extras:</strong> <?= is_array($extras_gold) ? htmlspecialchars(implode(', ', $extras_gold)) : htmlspecialchars($extras_gold) ?></li>
				<?php endif; ?>
				<?php if (!empty($extras_silber)): ?>
					<li><strong>Silber-Extras:</strong> <?= is_array($extras_silber) ? htmlspecialchars(implode(', ', $extras_silber)) : htmlspecialchars($extras_silber) ?></li>
				<?php endif; ?>
				<?php if (!empty($paket)): ?>
					<li><strong>Gewähltes Kombi-Paket:</strong> <?= is_array($paket) ? htmlspecialchars(implode(', ', $paket)) : htmlspecialchars($paket) ?></li>
				<?php endif; ?>
				<?php if (!empty($zahlung)): ?>
					<li><strong>Zahlungsart:</strong> <?= htmlspecialchars($zahlung) ?></li>
				<?php endif; ?>
				<?php if (!empty($rechnung_adresse) && $rechnung_adresse === 'andere' && !empty($andere_adresse)): ?>
					<li><strong>Abweichende Rechnungsadresse:</strong><br><?= nl2br(htmlspecialchars($andere_adresse)) ?></li>
				<?php endif; ?>
			</ul>

			<p style="margin-top: 30px;">Mit freundlichen Grüßen,<br>Ihr STYX Erlebniswelt Team</p>
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
</table>
</body>
</html>
