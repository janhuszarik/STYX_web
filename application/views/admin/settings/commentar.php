
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title"><?php if (!empty($komentar->id)){ echo "product bearbeiten"; } else { echo "product hinzufügen"; } ?></h2>
					<p class="card-subtitle">
						Erstellen Sie Text für product im Abschnitt unter dem Banner
					</p>
				</header>
				<div class="card-body">
					<form action="<?=BASE_URL?>admin/commentarSave" method="post" id="form" enctype="multipart/form-data">
						<?php if (!empty($komentar->id)){ ?>
							<input type="hidden" name="id" value="<?=$komentar->id?>">
						<?php } ?>

						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputLang">Sprache</label>
									<select class="form-control" name="lang" id="inputLang">
										<option value="de" <?php echo ($komentar->lang == 'de') ? 'selected' : ''; ?>>Deutsch</option>
										<option value="en" <?php echo ($komentar->lang == 'en') ? 'selected' : ''; ?>>English</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<label class="col-form-label" for="active">Ist Aktiv?</label>
								<select name="active" class="form-control" id="activeSelect">
									<option value="1" <?php echo isset($komentar->active) && $komentar->active ? 'selected' : ''; ?>>Aktiv</option>
									<option value="0" <?php echo isset($komentar->active) && !$komentar->active ? 'selected' : ''; ?>>Inaktiv</option>
								</select>
							</div>
						</div>

						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Name</label>
									<input placeholder="Hauptüberschrift/Kurztext" type="text" name="name" class="form-control" id="Input1" value="<?=!empty($komentar->name)?$komentar->name: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">E-mail</label>
									<input placeholder="Internetverbindung" type="email" name="email" class="form-control" id="Input1" value="<?=!empty($komentar->email)?$komentar->email: ''?>" required>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Section_id</label>
									<input placeholder="Hauptüberschrift/Kurztext" type="text" name="section_id" class="form-control" id="Input1" value="<?=!empty($komentar->section_id)?$komentar->section_id: ''?>" required>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="col-form-label" for="Input1">Komentar</label>
									<textarea name="comment" class="form-control" id="Input1" rows="3" required oninput="autoResize(this)"><?= !empty($komentar->comment) ? $komentar->comment : '' ?></textarea>
								</div>
							</div>
						</div>


						<footer class="card-footer text-end">
							<?php if (!empty($komentar->id)){ ?>
								<input type="hidden" name="id" value="<?=$komentar->id?>">
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
					<?php if (!empty($komentar->id)){?>
						<input type="hidden" name="id" value="<?=$komentar->id?>">
						<h3 class="card-title">product-liste| Edit</h3>
					<?php } else { ?>
						<h3 class="card-title">product-liste </h3>
					<?php } ?>
					<p class="card-subtitle">Liste aller Menüelemente: <?=count($komentars)?></p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-md table-hover mb-0 table-bordered mb-0" >
							<thead>
							<tr>
								<th></th>
								<th>Sprache</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Kommentar</th>
								<th>GDPR</th>
								<th>Sektion</th>
								<th>Aktiv?</th>
								<th></th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<tbody>
							<?php if (empty($komentar)) { ?>
								<tr>
									<td colspan="8" class="text-center"><h5>Ich habe keine Daten zum Anzeigen...</h5></td>
								</tr>
							<?php } else {
								foreach ($komentars as $k => $r) { $k++ ?>
									<tr>
										<td data-title="#" class="text-end" title="<?=$r->id?>"><?=$k?></td>
										<?php if (count(getLanguages()) > 1){ ?>
											<td class="text-center"><img src="<?=langInfo($r->lang)['flag']?>" width="20px" alt=""></td>
										<?php } ?>
										<td data-title="Überschrift"><?=$r->name?></td>
										<td data-title="Button text"><?=$r->email?></td>
										<td data-title="Button text"><?=$r->comment?></td>
										<td data-title="Button text"><?=$r->consent?></td>
										<td data-title="Button text"><?=$r->section_id?></td>
										<td data-title="Aktiv" class="text-center"><?=active($r->active)?></td>
										<td data-title="Editovať" class="text-center"><a href="<?=BASE_URL.'admin/commentar/edit/'.$r->id?>"><i style="color: green" class="fa fa-edit"></i></a></td>
										<td data-title="Zmazať" class="text-center"><a href="<?=BASE_URL.'admin/commentar/del/'.$r->id?>" onclick="return confirm('Ste si istý/(á), že to chcete zmazať?!?')"><i style="color: red" class="fa fa-trash"></i></a></td>
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
	function autoResize(textarea) {
		textarea.style.height = 'auto';
		textarea.style.height = (textarea.scrollHeight) + 'px';
	}
</script>

