<h3 style="margin-bottom:10px;">Neue Nachricht von der Website</h3>
<table style="width:100%;border-collapse:collapse;">
	<tr><td style="font-weight:bold;width:150px;">Name:</td><td><?= htmlspecialchars($name) ?></td></tr>
	<tr><td style="font-weight:bold;">Adresse:</td><td><?= htmlspecialchars($adresse) ?></td></tr>
	<tr><td style="font-weight:bold;">Telefon:</td><td><?= htmlspecialchars($telefon) ?></td></tr>
	<tr><td style="font-weight:bold;">E-Mail:</td><td><?= htmlspecialchars($email) ?></td></tr>
	<tr><td style="font-weight:bold;">Typ:</td><td><?= htmlspecialchars($typ) ?></td></tr>
	<tr><td style="font-weight:bold;">Nachricht:</td><td><?= nl2br(htmlspecialchars($nachricht)) ?></td></tr>
</table>

