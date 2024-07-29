<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title"><?php if (!empty($news->id)) { echo "News bearbeiten"; } else { echo "News hinzufügen"; } ?></h2>
					<p class="card-subtitle">
						Erstellen Sie Text für News im Abschnitt unter dem Banner
					</p>
				</header>
				<div class="card-body">
					<form action="<?=BASE_URL?>admin/newsSave" method="post" id="form" enctype="multipart/form-data">
						<?php if (!empty($news->id)) { ?>
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

						<div class="row form-group pb-3">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="layoutSelect">Vyberte dizajn</label>
									<select class="form-control" id="layoutSelect">
										<option selected>Vyber si typ predlohy</option>
										<option value="layout1">Dizajn 1</option>
										<option value="layout2">Dizajn 2</option>
										<option value="layout3">Dizajn 3</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row form-group pb-3">
							<div class="col-lg-12">
								<div id="summernote"></div>
								<input type="hidden" name="content" id="content" value="<?=!empty($news->content) ? htmlspecialchars($news->content) : ''?>">
							</div>
						</div>





						<footer class="card-footer text-end">
							<?php if (!empty($news->id)) { ?>
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
					<?php if (!empty($news->id)) { ?>
						<input type="hidden" name="id" value="<?=$news->id?>">
						<h3 class="card-title">NEWS-liste| Edit</h3>
					<?php } else { ?>
						<h3 class="card-title">NEWS-liste </h3>
					<?php } ?>
					<p class="card-subtitle">Liste aller Menüelemente: <?=count($newss)?></p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-md table-hover mb-0 table-bordered mb-0">
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
										<td data-title="Button text"><span class="wrapped-text"><?= $r->buttonUrl ?></span></td>
										<td data-title="ab"><?= date('d.m.Y', strtotime($r->start_date)) ?></td>
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
	$(document).ready(function() {
		// Získanie obsahu z hidden input
		var content = $('#content').val();

		// Debugovanie obsahu
		console.log("Loaded content:", content);

		// Inicializácia Summernote s obsahom
		$('#summernote').summernote({
			height: 300,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['insert', ['link', 'picture', 'video', 'table', 'hr']],
				['view', ['fullscreen', 'codeview', 'help']]
			],
			popover: {
				image: [
					['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
					['float', ['floatLeft', 'floatRight', 'floatNone']],
					['remove', ['removeMedia']]
				],
				link: [
					['link', ['linkDialogShow', 'unlink']]
				],
				air: [
					['color', ['color']],
					['font', ['bold', 'underline', 'clear']],
					['para', ['ul', 'paragraph']],
					['insert', ['link', 'picture']]
				]
			}
		});

		// Nastavenie obsahu po inicializácii
		$('#summernote').summernote('code', content);

		// Aktualizácia hidden input pri odoslaní formulára
		$('#form').on('submit', function() {
			var content = $('#summernote').summernote('code');
			$('#content').val(content);
		});

		// Aktualizácia hidden input pri zmene layoutu
		$('#layoutSelect').change(function() {
			var layout = $(this).val();
			var content = '';
			switch (layout) {
				case 'layout1':
					content = `
                    <div class="article-layout">
                        <h1 style="text-align: center;">Artikelüberschrift</h1>
                        <h2 style="text-align: center;">Artikelunterüberschrift</h2>
                        <p style="text-align: justify;">Einleitungstext des Artikels. Dieser Abschnitt bietet grundlegende Informationen und führt den Leser in das Thema des Artikels ein. Dieser Text sollte in mehrere Absätze unterteilt werden, um die Lesbarkeit zu verbessern.</p>
                        <img src="https://via.placeholder.com/800x400" alt="Platzhalterbild" style="display: block; margin: 20px auto;">
                        <p style="text-align: justify;">Der Haupttext des Artikels geht hier weiter. Dies ist der Ort, an dem Sie weitere Bilder und detailliertere Informationen hinzufügen können.</p>
                        <img src="https://via.placeholder.com/400x300" alt="Platzhalterbild" style="float: left; margin: 10px 20px 10px 0;">
                        <p style="text-align: justify;">Fortsetzung des Textes, der weitere Details und erweiterte Informationen enthält.</p>
                        <img src="https://via.placeholder.com/400x300" alt="Platzhalterbild" style="float: right; margin: 10px 0 10px 20px;">
                        <p style="text-align: justify;">Schluss des Artikels. Dieser Text schließt das Thema ab und bietet abschließende Gedanken und Informationen.</p>
                    </div>`;
					break;
				case 'layout2':
					content = `
                    <div class="article-layout">
                        <h1 style="font-size: 36px; color: #333;">Artikelüberschrift</h1>
                        <p style="font-size: 18px; color: #666;">Einleitungstext des Artikels. Dieser Abschnitt bietet einen kurzen Überblick über den Inhalt des Artikels.</p>
                        <img src="https://via.placeholder.com/600x300" alt="Platzhalterbild" style="width: 100%; margin: 20px 0;">
                        <p style="font-size: 16px; color: #444;">Haupttext des Artikels. Dies ist der Ort, an dem Sie detailliertere Informationen und Inhalte hinzufügen können. Der Text kann in mehrere Absätze unterteilt werden, um die Lesbarkeit zu verbessern.</p>
                        <img src="https://via.placeholder.com/600x300" alt="Platzhalterbild" style="width: 100%; margin: 20px 0;">
                        <p style="font-size: 16px; color: #444;">Fortsetzung des Haupttextes des Artikels. Sie können weitere Bilder und Grafikelemente nach Bedarf hinzufügen.</p>
                    </div>`;
					break;
				case 'layout3':
					content = `
                    <div class="article-layout">
                        <h1 style="text-align: left;">Artikelüberschrift</h1>
                        <h2 style="text-align: left;">Artikelunterüberschrift</h2>
                        <p style="text-align: justify;">Einleitungstext des Artikels. Dieser Abschnitt dient der Vorstellung des Hauptthemas und der Einstimmung des Lesers.</p>
                        <img src="https://via.placeholder.com/800x400" alt="Platzhalterbild" style="display: block; margin: 20px auto;">
                        <p style="text-align: justify;">Der Haupttext des Artikels enthält detailliertere Informationen, die in mehrere Absätze unterteilt sind. Dies ermöglicht ein leichteres Lesen und Verstehen des Inhalts.</p>
                        <p style="text-align: justify;">Weiterer Text des Artikels mit Hinzufügung von Bildern.</p>
                        <img src="https://via.placeholder.com/400x300" alt="Platzhalterbild" style="float: left; margin: 10px 20px 10px 0;">
                        <p style="text-align: justify;">Ergänzende Informationen und erweiterter Text des Artikels.</p>
                        <img src="https://via.placeholder.com/400x300" alt="Platzhalterbild" style="float: right; margin: 10px 0 10px 20px;">
                        <p style="text-align: justify;">Schluss des Artikels. Bietet eine Zusammenfassung der Informationen und abschließende Gedanken.</p>
                    </div>`;
					break;
			}
			$('#summernote').summernote('code', content);
			$('#content').val(content);
		});
	});


</script>







