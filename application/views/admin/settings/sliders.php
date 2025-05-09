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
					<p class="card-subtitle">Slider auf der Startseite verwalten.</p>
				</header>
				<div class="card-body">
					<?php echo form_open_multipart('admin/sliderSave/' . (isset($slider['id']) ? $slider['id'] : ''), ['id' => 'sliderForm']); ?>

					<div class="form-group">
						<label for="inputLang">Sprache</label>
						<select class="form-control" name="lang" id="inputLang">
							<option value="de" <?php echo ($slider['lang'] == 'de') ? 'selected' : ''; ?>>Deutsch</option>
							<option value="en" <?php echo ($slider['lang'] == 'en') ? 'selected' : ''; ?>>English</option>
						</select>
					</div>

					<div class="form-group">
						<label for="title">Titel für Inhalt</label>
						<input type="text" class="form-control" name="title" id="title" value="<?php echo isset($slider['title']) ? $slider['title'] : ''; ?>">
					</div>

					<div class="form-group">
						<label for="name1">Hauptüberschrift</label>
						<input type="text" class="form-control" name="name1" id="name1" value="<?php echo isset($slider['name1']) ? $slider['name1'] : ''; ?>">
					</div>

					<div class="form-group">
						<label for="name2">Unterüberschrift</label>
						<input type="text" class="form-control" name="name2" id="name2" value="<?php echo isset($slider['name2']) ? $slider['name2'] : ''; ?>">
					</div>

					<div class="form-group">
						<label for="name3">Kleingeschriebener Text</label>
						<input type="text" class="form-control" name="name3" id="name3" value="<?php echo isset($slider['name3']) ? $slider['name3'] : ''; ?>">
					</div>

					<div class="form-group">
						<label for="image">Slider Bild</label>
						<input type="file" class="form-control" name="image" id="image">
						<?php if (isset($slider['image'])): ?>
							<img src="<?php echo base_url('uploads/sliders/' . $slider['image']); ?>" width="100">
						<?php endif; ?>
					</div>

					<div class="form-group">
						<label for="button_link">Schaltflächenlink</label>
						<input type="text" class="form-control" name="button_link" id="button_link" value="<?php echo isset($slider['button_link']) ? $slider['button_link'] : ''; ?>">
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label for="bg_color">Hintergrundfarbe</label>
							<input type="color" class="form-control form-control-color" name="bg_color" id="bg_color"
								   value="<?php echo isset($slider['bg_color']) ? $slider['bg_color'] : '#ffffff'; ?>">
						</div>
						<div class="col-md-6">
							<label for="text_color">Textfarbe</label>
							<input type="color" class="form-control form-control-color" name="text_color" id="text_color"
								   value="<?php echo isset($slider['text_color']) ? $slider['text_color'] : '#000000'; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="orderBy">Order By</label>
						<input type="number" class="form-control" name="orderBy" id="orderBy" value="<?php echo isset($slider['orderBy']) ? $slider['orderBy'] : ''; ?>" required>
					</div>

					<div class="form-group">
						<label for="active">Status</label>
						<select name="active" id="active" class="form-control">
							<option value="1" <?php echo (isset($slider['active']) && $slider['active'] == 1) ? 'selected' : ''; ?>>Aktiv</option>
							<option value="0" <?php echo (isset($slider['active']) && $slider['active'] == 0) ? 'selected' : ''; ?>>Inaktiv</option>
						</select>
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
						<table class="table table-responsive-md table-hover mb-0 table-bordered mb-0" >
							<thead>
							<tr>
								<th>#</th>
								<th></th>
								<th>Image</th>
								<th>Inhalt</th>
								<th>Link</th>
								<th>Sort.</th>
								<th>Status</th>
								<th>Aktionen</th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($sliders)): ?>
								<?php foreach ($sliders as $index => $slider): ?>
									<tr class="text-center">
										<td><?php echo $index + 1; ?></td>
										<?php if (count(getLanguages()) > 1) { ?>
											<td class="text-center">
												<img src="<?php echo langInfo($slider['lang'])['flag']; ?>" width="30" alt="">
											</td>
										<?php } ?>

										<td><img src="<?php echo base_url('uploads/sliders/' . $slider['image']); ?>" width="50"></td>
										<td><?php echo $slider['title']; ?></td>
										<td><?php echo $slider['button_link']; ?></td>
										<td><?php echo $slider['orderBy']; ?></td>
										<td>
											<?php if ($slider['active']): ?>
												<i class="fa fa-check text-success"></i>
											<?php else: ?>
												<i class="fa fa-times text-danger"></i>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<div class="button-container">
												<a href="<?php echo site_url('admin/sliderSave/' . $slider['id']); ?>" class="btn btn-success btn-sm">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="<?php echo site_url('admin/delete_slider/' . $slider['id']); ?>" class="btn btn-danger btn-sm">
													<i class="fa fa-trash"></i>
												</a>
											</div>
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
