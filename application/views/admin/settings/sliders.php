<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<title>Sliders Management</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container col-lg-12">
	<div class="row">
		<div class="col-xl-6">
			<section class="card card-primary">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>
					<h3 class="card-title"><?php echo isset($slider) && !empty($slider['id']) ? 'Slider bearbeiten' : 'Slider hinzufügen'; ?></h3>
					<p class="card-subtitle">
						Hinzufügen und Bearbeiten eines Sliders zur Anzeige von Bildern auf der Startseite einer Webseite.
					</p>
				</header>
				<div class="card-body">
					<?php echo form_open_multipart('admin/sliderSave/' . (isset($slider['id']) ? $slider['id'] : ''), ['id' => 'sliderForm']); ?>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="name1">Hauptüberschrift</label>
								<input type="text" class="form-control" name="name1" id="name1" value="<?php echo isset($slider['name1']) ? $slider['name1'] : ''; ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="name2">Unterüberschrift</label>
								<input type="text" class="form-control" name="name2" id="name2" value="<?php echo isset($slider['name2']) ? $slider['name2'] : ''; ?>">
							</div>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="name3">Kleiner Text 1.</label>
								<input type="text" class="form-control" name="name3" id="name3" value="<?php echo isset($slider['name3']) ? $slider['name3'] : ''; ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="name4">Kleiner Text 2.</label>
								<input type="text" class="form-control" name="name4" id="name4" value="<?php echo isset($slider['name4']) ? $slider['name4'] : ''; ?>">
							</div>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="image">Slider Bild</label>
								<input type="file" class="form-control" name="image" id="image" <?php echo !isset($slider) ? : ''; ?>>
								<?php if (isset($slider['image'])): ?>
									<img src="<?php echo base_url('uploads/sliders/' . $slider['image']); ?>" width="100">
								<?php endif; ?>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="thumb">Vorschau</label>
								<input type="file" class="form-control" name="thumb" id="thumb" <?php echo !isset($slider) ? : ''; ?>>
								<?php if (isset($slider['thumb'])): ?>
									<img src="<?php echo base_url('uploads/sliders/' . $slider['thumb']); ?>" width="100">
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="button_text">Schaltflächentext</label>
								<input type="text" class="form-control" name="button_text" id="button_text" value="<?php echo isset($slider['button_text']) ? $slider['button_text'] : ''; ?>">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="button_link">Schaltflächenlink</label>
								<input type="text" class="form-control" name="button_link" id="button_link" value="<?php echo isset($slider['button_link']) ? $slider['button_link'] : ''; ?>">
							</div>
						</div>
					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="orderBy">Order By</label>
								<input type="number" class="form-control" name="orderBy" id="orderBy" value="<?php echo isset($slider['orderBy']) ? $slider['orderBy'] : ''; ?>" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="float">Text Alignment</label>
								<select class="form-control" name="float" id="float">
									<option value="left" <?php echo isset($slider['float']) && $slider['float'] == 'left' ? 'selected' : ''; ?>>Left</option>
									<option value="center" <?php echo isset($slider['float']) && $slider['float'] == 'center' ? 'selected' : ''; ?>>Center</option>
									<option value="right" <?php echo isset($slider['float']) && $slider['float'] == 'right' ? 'selected' : ''; ?>>Right</option>
								</select>
							</div>
						</div>

					</div>
					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-form-label" for="active">Ist dieser Slider aktiv?</label>
								<input type="hidden" name="active" value="0">
								<input type="checkbox" name="active" value="1" id="active" <?php echo isset($slider['active']) && $slider['active'] ? 'checked' : ''; ?>>
							</div>
						</div>
					</div>

					<footer class="card-footer text-end">
						<?php if (isset($slider) && !empty($slider['id'])): ?>
							<input type="hidden" name="id" value="<?php echo $slider['id']; ?>">
							<button type="submit" class="btn btn-primary">Änderungen speichern</button>
						<?php else: ?>
							<button type="submit" class="btn btn-primary">Speichern</button>
						<?php endif; ?>
					</footer>
					<?php echo form_close(); ?>
				</div>
			</section>
		</div>

		<div class="col-xl-6">
			<section class="card card-yellow">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>
					<h3 class="card-title">Sliders List</h3>
					<p class="card-subtitle">
						Derzeit hinzugefügte Slider: <?php echo count($sliders); ?>
					</p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Haupttext</th>
								<th>Button text</th>
								<th>Button link</th>
								<th>Aktiv</th>
								<th>Order By</th>
								<th>Aktionen</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($sliders)): ?>
								<?php foreach ($sliders as $index => $slider): ?>
									<tr class="text-center">
										<td><?php echo $index + 1; ?></td>
										<td><img src="<?php echo base_url('uploads/sliders/' . $slider['image']); ?>" width="50"></td>
										<td><?php echo $slider['name1']; ?></td>
										<td><?php echo $slider['button_text']; ?></td>
										<td><?php echo $slider['button_link']; ?></td>
										<td>
											<?php if ($slider['active']): ?>
												<i class="fa fa-check text-success"></i>
											<?php else: ?>
												<i class="fa fa-times text-danger"></i>
											<?php endif; ?>
										</td>
										<td><?php echo $slider['orderBy']; ?></td>
										<td class="text-center">
											<a href="<?php echo site_url('admin/sliderSave/' . $slider['id']); ?>" class="btn btn-success btn-sm">
												<i class="fa fa-pencil"></i>
											</a>
											<a href="<?php echo site_url('admin/delete_slider/' . $slider['id']); ?>" class="btn btn-danger btn-sm">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="8" class="text-center"><h5>No sliders found.</h5></td></tr>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>

	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
