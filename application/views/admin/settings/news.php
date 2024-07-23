
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title"><?php if (!empty($news->id)){ echo "News bearbeiten"; } else { echo "News hinzufügen"; } ?></h2>
					<p class="card-subtitle">
						Erstellen Sie Text für News im Abschnitt unter dem Banner
					</p>
				</header>
				<div class="card-body">
					<form action="<?=BASE_URL?>admin/newsSave" method="post" id="form" enctype="multipart/form-data">
						<?php if (!empty($news->id)){ ?>
							<input type="hidden" name="id" value="<?=$news->id?>">
						<?php } ?>

						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputLang">Sprache</label>
									<select class="form-control" name="lang" id="inputLang">
										<option value="de" <?php echo ($menu->lang == 'de') ? 'selected' : ''; ?>>Deutsch</option>
										<option value="en" <?php echo ($menu->lang == 'en') ? 'selected' : ''; ?>>English</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<label class="col-form-label" for="active">Ist Aktiv?</label>
								<select name="active" class="form-control" id="activeSelect">
									<option value="1" <?php echo isset($news->active) && $news->active ? 'selected' : ''; ?>>Aktiv</option>
									<option value="0" <?php echo isset($news->active) && !$news->active ? 'selected' : ''; ?>>Inaktiv</option>
								</select>
							</div>
						</div>

						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Hauptüberschrift</label>
									<input placeholder="Hauptüberschrift/Kurztext" type="text" name="name" class="form-control" id="Input1" value="<?=!empty($news->name)?$news->name: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Kurztext</label>
									<input placeholder="Text unter einer großen Überschrift" type="text" name="name1" class="form-control" id="Input1" value="<?=!empty($news->name1)?$news->name1: ''?>" required>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">URL link</label>
									<input placeholder="Internetverbindung" type="text" name="buttonUrl" class="form-control" id="Input1" value="<?=!empty($news->buttonUrl)?$news->buttonUrl: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<label class="col-form-label" for="image">Bild hochladen</label>
								<input type="file" name="image" class="form-control" id="image">
							</div>
						</div>

						<!-- Pridanie nahrávania obrázkov -->


						<!-- Pridanie dátumu a času -->
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="start_date">Startdatum*</label>
									<input type="date" name="start_date" class="form-control" id="start_date" value="<?=!empty($news->start_date)?$news->start_date: ''?>">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="end_date">Enddatum*</label>
									<input type="date" name="end_date" class="form-control" id="end_date" value="<?=!empty($news->end_date)?$news->end_date: ''?>">
								</div>
							</div>
						</div>
						<br><br>
							<footer class="card-footer text-end">
							<?php if (!empty($news->id)){ ?>
								<input type="hidden" name="id" value="<?=$news->id?>">
								<button type="submit" class="btn btn-primary">Bearbeiten</button>
							<?php } else { ?>
								<button type="submit" class="btn btn-primary">Speichern</button>
							<?php } ?>
						</footer>
					</form>
				</div>
			</section>
		</div>


		<div class="col-lg-6">
			<section class="card card-yellow">
				<header class="card-header">
					<?php if (!empty($news->id)){?>
						<input type="hidden" name="id" value="<?=$news->id?>">
						<h3 class="card-title">NEWS-liste| Edit</h3>
					<?php } else { ?>
						<h3 class="card-title">NEWS-liste </h3>
					<?php } ?>
					<p class="card-subtitle">Liste aller Menüelemente: <?=count($newss)?></p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-md table-hover mb-0 table-bordered mb-0" >
							<thead>
							<tr>
								<th>#</th>
								<th>Überschrift</th>
								<th>Hauptüberschrift</th>
								<th>URL</th>
								<th>ab:</th>
								<th>bis:</th>
								<th>Aktiv</th>
								<th></th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<tbody>
							<?php if (empty($news)) { ?>
								<tr>
									<td colspan="8" class="text-center"><h5>Ich habe keine Daten zum Anzeigen...</h5></td>
								</tr>
							<?php } else {
								foreach ($newss as $k => $r) { $k++ ?>
									<tr>
										<td data-title="#" class="text-end" title="<?=$r->id?>"><?=$k?></td>
										<td data-title="Überschrift"><?=$r->name?></td>
										<td data-title="Hauptüberschrift"><?=$r->name1?></td>
										<td data-title="Button text"><span class="wrapped-text"><?= $r->buttonUrl ?></span></td>										<td data-title="ab"><?= date('d.m.Y', strtotime($r->start_date)) ?></td>
										<td data-title="bis"><?= date('d.m.Y', strtotime($r->end_date))?></td>
										<td data-title="Aktiv" class="text-center"><?=active($r->active)?></td>
										<td data-title="Bild" class="text-center"><img src="<?=BASE_URL?>uploads/news/<?=$r->image?>" style="width: 50px;"></td>
										<td data-title="Editovať" class="text-center"><a href="<?=BASE_URL.'admin/news/edit/'.$r->id?>"><i style="color: green" class="fa fa-edit"></i></a></td>
										<td data-title="Zmazať" class="text-center"><a href="<?=BASE_URL.'admin/news/del/'.$r->id?>" onclick="return confirm('Ste si istý/(á), že to chcete zmazať?!?')"><i style="color: red" class="fa fa-trash"></i></a></td>
									</tr>
								<?php }} ?>
							</tbody>

						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script>
	$("#form").validate({ // Set Focus on first invalid input
		focusInvalid: false,
		invalidHandler: function() {
			$(this).find(":input.error:first").focus();
		}
	});

	// Initial call to set the background color on page load
	updateBackgroundColor();
	$(document).ready(function() {
		$('#Input5').summernote();
	});

</script>

