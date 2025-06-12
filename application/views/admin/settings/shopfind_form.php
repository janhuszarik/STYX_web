<?php
// application/views/admin/shopfind/form.php
?>

<form method="post" action="<?= base_url('admin/shopfind') ?>" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= isset($location->id) ? $location->id : '' ?>">

	<section class="card">
		<header class="card-header">
			<h3 class="card-title mb-0"><?= $title ?></h3>
		</header>
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					<label>Name *</label>
					<input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($location->name ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label>Verantwortliche Person</label>
					<input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($location->contact_person ?? '') ?>">
				</div>

				<div class="col-md-6">
					<label>Adresse *</label>
					<input type="text" name="address" class="form-control" required value="<?= htmlspecialchars($location->address ?? '') ?>">
				</div>
				<div class="col-md-3">
					<label>PLZ *</label>
					<input type="text" name="zip_code" class="form-control" required value="<?= htmlspecialchars($location->zip_code ?? '') ?>">
				</div>
				<div class="col-md-3">
					<label>Stadt *</label>
					<input type="text" name="city" class="form-control" required value="<?= htmlspecialchars($location->city ?? '') ?>">
				</div>

				<div class="col-md-4">
					<label>Land</label>
					<input type="text" name="country" class="form-control" value="<?= htmlspecialchars($location->country ?? 'Österreich') ?>">
				</div>
				<div class="col-md-4">
					<label>E-Mail</label>
					<input type="email" name="email" class="form-control" value="<?= htmlspecialchars($location->email ?? '') ?>">
				</div>
				<div class="col-md-4">
					<label>Telefon</label>
					<input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($location->phone ?? '') ?>">
				</div>

				<div class="col-md-6">
					<label>Website</label>
					<input type="text" name="website" class="form-control" value="<?= htmlspecialchars($location->website ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label>Logo</label>
					<input type="file" name="logo" class="form-control">
					<?php if (!empty($location->logo)): ?>
						<img src="<?= base_url('uploads/' . $location->logo) ?>" alt="Logo" style="max-height: 100px; margin-top: 10px;">
					<?php endif; ?>
				</div>

				<div class="col-md-12">
					<label>Öffnungszeiten</label>
					<textarea name="opening_hours" class="form-control" rows="3"><?= htmlspecialchars($location->opening_hours ?? '') ?></textarea>
				</div>

				<div class="col-md-6">
					<label>Latitude</label>
					<input type="text" name="latitude" class="form-control" value="<?= htmlspecialchars($location->latitude ?? '') ?>">
				</div>
				<div class="col-md-6">
					<label>Longitude</label>
					<input type="text" name="longitude" class="form-control" value="<?= htmlspecialchars($location->longitude ?? '') ?>">
				</div>
				<div class="col-md-3">
					<label>Status</label><br>
					<input type="checkbox" name="active" value="1" <?= (!isset($location) || $location->active) ? 'checked' : '' ?>> Aktiv
				</div>
			</div>
		</div>
		<footer class="card-footer text-end">
			<a href="<?= base_url('admin/shopfind') ?>" class="btn btn-secondary">Zurück</a>
			<button type="submit" class="btn btn-success">Speichern</button>
		</footer>
	</section>
</form>
