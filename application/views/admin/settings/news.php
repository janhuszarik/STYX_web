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
					<form action="<?=BASE_URL?>admin/newsSave" method="post" id="form">
						<?php if (!empty($news->id)){ ?>
							<input type="hidden" name="id" value="<?=$news->id?>">
						<?php } ?>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Überschrift</label>
									<input placeholder="Hauptüberschrift/Kurztext" type="text" name="name" class="form-control" id="Input1" value="<?=!empty($news->name)?$news->name: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Hauptüberschrift/Kurztext</label>
									<input placeholder="Text unter einer großen Überschrift" type="text" name="name1" class="form-control" id="Input1" value="<?=!empty($news->name1)?$news->name1: ''?>" required>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Button text</label>
									<input placeholder="Schaltflächentext, der auf der rechten Seite angezeigt wird" type="text" name="buttonName" class="form-control" id="Input1" value="<?=!empty($news->buttonName)?$news->buttonName: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Button link</label>
									<input placeholder="Internetverbindung" type="text" name="buttonUrl" class="form-control" id="Input1" value="<?=!empty($news->buttonUrl)?$news->buttonUrl: ''?>" required>
								</div>
							</div>
						</div>
						<div class="form-group pb-3">
							<label class="col-form-label" for="active">Ist Aktiv?</label>
							<input type="hidden" name="active" value="0">
							<input type="checkbox" name="active" value="1" <?php echo isset($news->active) && $news->active ? 'checked' : ''; ?>><br>
							<small>Wenn keine Nachrichten aktiv sind, wird der gesamte Abschnitt unter dem Banner deaktiviert!!!</small>
						</div>
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
						<table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Überschrift</th>
								<th>Hauptüberschrift</th>
								<th>Button text</th>
								<th>Button link</th>
								<th>Aktiv</th>
								<th></th>
								<th></th>
							</tr>
							</thead>
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
										<td data-title="Button text"><?=$r->buttonName?></td>
										<td data-title="Button link"><?=$r->buttonUrl?></td>
										<td data-title="Aktiv" class="text-center"><?=activeToIcon($r->active)?></td>
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
</script>
<script>
	$(document).ready(function() {
		$('#Input5').summernote();
	});
</script>
