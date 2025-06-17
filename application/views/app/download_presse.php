<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-4"><?= $title ?></h1>
				<p class="text-muted lead mb-0"><?= nl2br(htmlspecialchars($description)) ?></p>
			</div>
		</div>
	</div>
</section>


<section id="examples" class="py-5" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">

				<h4 class="mb-4">Image Horizontal</h4>

				<p class="mb-4 text-muted">
					Unsere Philosophie basiert auf der Überzeugung, dass echte Schönheit durch Natürlichkeit, Nachhaltigkeit und Verantwortung gegenüber Mensch und Umwelt entsteht.
					Daher setzen wir ausschließlich auf sorgfältig ausgewählte Inhaltsstoffe, die aus kontrolliert biologischem Anbau stammen und möglichst regional bezogen werden.<br><br>
					In unserem Unternehmen vereinen wir traditionelles Wissen mit moderner Forschung, um innovative Pflegeprodukte zu entwickeln, die sowohl wirksam als auch hautverträglich sind.
					Dabei legen wir großen Wert auf Transparenz und Nachvollziehbarkeit in der gesamten Produktionskette – vom Rohstoff bis zum fertigen Produkt.<br><br>
					Mit Leidenschaft, Präzision und einem hohen Anspruch an Qualität möchten wir einen Beitrag zu einer bewussteren und nachhaltigeren Lebensweise leisten.
				</p>

				<div class="card mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
					<div class="row g-0">
						<div class="col-lg-4">
							<img src="<?=BASE_URL.'img/image/bilddatenbank.png'?>" class="img-fluid rounded-start" alt="datenbank_bilder_image">
						</div>
						<div class="col-lg-8">
							<div class="card-body">
								<h3 class="card-title mb-1 text-4 font-weight-bold">Produktbilder</h3>
								<p class="card-text mb-2">Mit den nachstehenden Links können Sie Produktbilder und Imagebilder von STYX Naturcosmetic in Druckqualität herunterladen. Kontaktieren Sie uns bezüglich der Zugangsdaten gerne per E-Mail oder Telefon <strong>+43 (0) 2747 3250.</strong></p>
								<a href="/" class="read-more text-color-primary font-weight-semibold text-2">STYX Bilddatenbank | zum Login<i class="fas fa-angle-right position-relative top-1 ms-1"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
					<div class="row g-0">
						<div class="col-lg-4">
							<img src="<?=BASE_URL.'img/image/Katalog.jpg'?>" class="img-fluid rounded-start" alt="STYX_katalog_bild">
						</div>
						<div class="col-lg-8">
							<div class="card-body">
								<h3 class="card-title mb-1 text-4 font-weight-bold">STYX Katalog</h3>
								<p class="card-text mb-2">Mit unserem Katalog fällt die Übersicht über die STYX Produkte leicht. Hier finden Sie alles, was Sie über unsere Naturkosmetik-Linien wissen sollten!</p>

								<a href="<?= base_url('pdf/STYX-Katalog.pdf') ?>"
								   class="read-more text-color-primary font-weight-semibold text-2"
								   download>
									Katalog als PDF Herunterladen <i class="fas fa-angle-right position-relative top-1 ms-1"></i>
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>


