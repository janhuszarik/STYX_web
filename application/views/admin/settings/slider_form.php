<?php
/**
 * View file for adding or editing a slider item.
 */
?>

<div class="row">
	<div class="col-lg-12">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title"><?= isset($slider->id) ? 'Slider bearbeiten: ' . htmlspecialchars($slider->title) : 'Slider hinzufügen' ?></h2>
				<p class="card-subtitle">
					<?= isset($slider->id) ? 'Bearbeiten Sie bestehende Slider nach Bedarf.' : 'Geben Sie die Daten für den Slider ein' ?>
				</p>
			</header>

			<div class="card-body">
				<form method="post" action="<?= base_url('admin/sliderSave') ?>" enctype="multipart/form-data">
					<?php if (!empty($slider->id)): ?>
						<input type="hidden" name="id" value="<?= $slider->id ?>">
					<?php endif; ?>


					<div class="row form-group pb-3">
						<div class="col-lg-4">
							<label class="col-form-label">Sprache
								<i class="fas fa-info-circle text-primary " data-bs-toggle="tooltip" data-bs-placement="right" title="Sprache, unter der der Inhalt angezeigt wird."></i>
							</label>
							<select class="form-control" name="lang">
								<option value="de" <?= ($slider->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
								<option value="en" <?= ($slider->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
							</select>
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Titel für Inhalt
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Haupttitel des Sliders – wird auch unter dem Slider im Textbereich angezeigt und dient als Hauptüberschrift.!"></i>
							</label>
							<input type="text" name="title" class="form-control" value="<?= htmlspecialchars($slider->title ?? '') ?>">
						</div>
						<div class="col-lg-4">
							<label class="col-form-label">Hauptüberschrift
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Dieser Text wird unter dem Titel als Haupttext unter dem Slider angezeigt. Er sollte im Grunde der längste Text sein und den Inhalt des Sliders oder der Kampagne vermitteln."></i>
							</label>
							<input type="text" name="name1" class="form-control" value="<?= htmlspecialchars($slider->name1 ?? '') ?>">
						</div>
					</div>



					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label">Unterüberschrift
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Dieser Text ist optional und kleiner als der Haupttext. Er dient dazu, unter dem Haupttext eine zusätzliche Erklärung oder einen ergänzenden Hinweis anzuzeigen, falls erforderlich."></i>
							</label>
							<input type="text" name="name2" class="form-control" value="<?= htmlspecialchars($slider->name2 ?? '') ?>">
						</div>
						<div class="col-lg-6">
							<label class="col-form-label">Kleingeschriebener Text
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Dieser Text wird in kleiner Schrift unter dem Slider angezeigt und dient zur Darstellung von Bedingungen der Kampagne o. Ä. Es ist der kleinste Text unter dem Slider."></i>
							</label>
							<input type="text" name="name3" class="form-control" value="<?= htmlspecialchars($slider->name3 ?? '') ?>">
						</div>
					</div>


					<div class="form-group pb-3">
						<label class="col-form-label">Slider Bild
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Das Hinzufügen des Hauptbildes sollte im gleichen Format erfolgen, wie es auch im Webshop und im Aroma-Derm-Shop verwendet wird. Das bedeutet:Maße: 1920x600px oder maximal 1920x800px! Format: .jpg oder .png. Die Bildgröße sollte 3 MB nicht überschreiten, die ideale Größe liegt bei etwa 900 KB."></i>
						</label>
						<input type="file" name="image" class="form-control">
						<?php if (!empty($slider->image)): ?>
							<small class="text-muted">Aktuelles Bild: <img src="<?= base_url('Uploads/sliders/' . $slider->image) ?>" style="width: 50px; margin-top: 5px;"></small>
						<?php endif; ?>
					</div>

					<div class="form-group pb-3">
						<label class="col-form-label">Schaltflächenlink (optional)
							<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Durch das Hinzufügen einer URL wird der Besucher beim Klick auf den Slider zur gewünschten Unterseite weitergeleitet. Wenn dieses Feld leer bleibt, wird beim Klick lediglich die aktuelle Seite neu geladen und der Besucher wird nicht weitergeleitet."></i>
						</label>
						<input type="text" name="button_link" class="form-control" value="<?= htmlspecialchars($slider->button_link ?? '') ?>">
						<small class="text-muted">Für externe Links das gesamte https:// angeben</small>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-3">
							<label class="col-form-label">Hintergrundfarbe
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die Hintergrundfarbe ist die Farbe, die sich hinter dem Text des Sliders befindet. Sie sollte mit dem HEX-Farbcode der unteren Leiste des Sliders übereinstimmen, um einen gleichmäßigen Übergang auf der Website zu gewährleisten.
								Nach dem Öffnen des Farbfelds kann man mit den Pfeilen von RGB auf HEX umstellen – der HEX-Code beginnt mit einem # und besteht aus einem Farbcode, den man aus der Farbpalette in InDesign kopieren kann."></i>
							</label>
							<input type="color" name="bg_color" class="form-control" style="height: 38px; padding: 4px 6px;" value="<?= htmlspecialchars($slider->bg_color ?? '#ffffff') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Textfarbe
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die Textfarbe sollte in der Regel entweder weiß oder schwarz sein. Für die beste Lesbarkeit und zur Einhaltung der Barrierefreiheitsrichtlinien sollte der Text schwarz sein. Ist der Hintergrund jedoch sehr dunkel, sollte der Text weiß dargestellt werden.
								Es ist nicht empfehlenswert, farbigen Text wie z. B. gelb, rot oder grün zu verwenden, da dieser den nötigen Kontrast oft nicht erfüllt."></i>
							</label>
							<input type="color" name="text_color" class="form-control" style="height: 38px; padding: 4px 6px;" value="<?= htmlspecialchars($slider->text_color ?? '#000000') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Position
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Position, an der sich der Menüpunkt befinden wird. Das bedeutet die Reihenfolge von oben nach unten – oder in einer Zeile, wenn es sich um einen Hauptmenüpunkt handelt. Die Nummerierung sollte immer bei 0 beginnen. Position 0 ist stets die erste und hat Vorrang vor allen anderen Nummern."></i>
							</label>
							<input type="number" name="orderBy" class="form-control" required value="<?= htmlspecialchars($slider->orderBy ?? '') ?>">
						</div>
						<div class="col-lg-3">
							<label class="col-form-label">Aktiv?
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Auswahl, ob der Menüpunkt aktiv sein soll oder verborgen bleibt und für die Öffentlichkeit nicht sichtbar ist."></i>
							</label>
							<select name="active" class="form-control">
								<option value="1" <?= !empty($slider->active) ? 'selected' : '' ?>>Ja</option>
								<option value="0" <?= empty($slider->active) ? 'selected' : '' ?>>Nein</option>
							</select>
						</div>
					</div>

					<footer class="card-footer text-end">
						<button type="submit" class="btn btn-primary"><?= isset($slider->id) ? 'Änderungen speichern' : 'Speichern' ?></button>
						<a href="<?= base_url('admin/slider') ?>" class="btn btn-danger">Zurück zur Liste</a>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>
