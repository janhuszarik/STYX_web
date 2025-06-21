<style>
	.flip-card {
		width: 100%;
		height: 400px;
		perspective: 1000px;
	}

	.flip-card-inner {
		position: relative;
		width: 100%;
		height: 100%;
		transition: transform 0.8s;
		transform-style: preserve-3d;
	}

	.flip-card:hover .flip-card-inner {
		transform: rotateY(180deg);
	}

	.flip-card-front, .flip-card-back {
		position: absolute;
		width: 100%;
		height: 100%;
		backface-visibility: hidden;
		border: 1px solid #ddd;
		border-radius: 10px;
		overflow: hidden;
		padding: 15px;
		box-shadow: 0 5px 15px rgba(0,0,0,0.1);
		display: flex;
		flex-direction: column;
		justify-content: start;
		align-items: center;
	}

	.flip-card-front {
		background-color: #fff;
		text-align: center;
	}

	.flip-card-back {
		background-color: #f5f5f5;
		transform: rotateY(180deg);
		text-align: center;
		font-size: 14px;
		display: flex;
		flex-direction: column;
		justify-content: flex-start;
	}
	.flip-card-back h4 {
		font-size: 1.5rem;
		margin: 10px 0 0 0;
	}
	.card-image-fix {
		width: 100%;
		max-height: 300px;
		object-fit: cover;
		margin-bottom: 30px;
	}

	.flip-card-front h3 {
		font-size: 1.5rem;
		margin: 10px 0;
		padding: 13px 0;
	}
	.flip-card-front h4 {
		font-size: 1.5rem;
		padding: 3px 0;
	}

	.flip-card-back p {
		margin: 0 10px 10px 10px;
		flex-grow: 0;
		margin-top: 5px;
	}

	.flip-card-back .btn-sm {
		margin-top: auto;
	}


	.img-fluid {
		max-height: 80px;
		object-fit: contain;
	}
</style>
<section class="home-intro light border border-bottom-0 mb-0 newsletter-section" aria-labelledby="newsletter-heading" style="font-family: 'Poppins', Arial, sans-serif; font-size: 16px;">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-10 text-center">
				<h1 id="article-heading" class="font-weight-bold mb-3"><?= $title ?></h1>
				<p class="text-muted lead mb-0"><?= htmlspecialchars($description) ?></p>
			</div>
		</div>
	</div>
</section>

<section class="container py-5">
	<h1 class="text-center text-success">WORLD OF STYX – Ihr Ausflugsziel im Mostviertel</h1>
	<p class="mb-4">
		Eine Reise durch die faszinierende Welt von STYX bietet unvergessliche Erlebnisse für alle Sinne. <br>
		Tauchen Sie ein in die Produktion von duftender Naturkosmetik, verkosten Sie handgemachte BIO-Schokolade
		und entdecken Sie beim entspannten Shoppen einzigartige Produkte, die unter die Haut gehen!
	</p>
	<img src="<?= base_url('img/logo/world_of_styx.png') ?>" alt="World of STYX" class="img-fluid my-4 d-block mx-auto" style="max-height: 160px;">

	<div class="mt-5">
		<h2 class="h4 fw-bold mb-3">Onlinebuchung</h2>
		<p class="mb-3">Hier können Sie bequem online Ihre nächste Betriebsführung buchen.</p>

		<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bookingModal">
			Tickets kaufen <i class="bi bi-box-arrow-up-right ms-1"></i>
		</button>
	</div>

	<h3 class="text-success mt-5">Erlebniswelt</h3>
	<div class="row text-center">
		<!-- 1 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/TopAusflugsziel.jpg') ?>" alt="World of STYX" class="card-image-fix mb-2">
						<h3 class="mt-2">World of STYX</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">World of STYX</h4>
						<p><strong>Blicken Sie mit uns hinter die Kulissen!</strong></p>
						<p>Eine Reise durch die faszinierende Welt von STYX bietet unvergessliche Erlebnisse für alle Sinne. Tauchen Sie ein in die Produktion von duftender Naturkosmetik, verkosten Sie handgemachte BIO-Schokolade und entdecken Sie beim entspannten Shoppen einzigartige Produkte, die unter die Haut gehen!</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>

		<!-- 2 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/bahnhofsbraeu.jpg') ?>" alt="Biererlebnis" class="card-image-fix mb-2">
						<h3 class="mt-2">Biererlebnis</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">Biererlebnis</h4>
						<p>Verkosten Sie unser hauseigenes Bier im Bistro, oder im Bahnhofsbräu in Kombitation mit einem unser Speisenangebote für Gruppen.</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>

		<!-- 3 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/bahnSTYX.jpg') ?>" alt="Bahnerlebnis" class="card-image-fix mb-2">
						<h3 class="mt-2">Bahnerlebnis</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">Bahnerlebnis</h4>
						<p>Erleben Sie die Faszination der Dampflokomotiven und entdecken Sie die Geschichte der längsten Schmalspurbahn Österreichs – ein Erlebnis für die ganze Familie!</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>

		<!-- 4 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/kraeutergarten.jpg') ?>" alt="Kräutergarten" class="card-image-fix mb-2">
						<h3 class="mt-2">Kräutergarten</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">Kräutergarten</h4>
						<p><strong>Natur im Garten Schaugarten</strong></p>
						<p>Unser Schaugarten „Natur im Garten“ gibt Einblick in die Welt der Kräuter und Blüten – informativ, entspannend und nachhaltig zugleich.</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>

		<!-- 5 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/stelze_bahnhofsbraeu.jpg') ?>" alt="Kulinarik für Gruppen" class="card-image-fix mb-2">
						<h3 class="mt-2">Kulinarik für Gruppen</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">Kulinarik für Gruppen</h4>
						<p>Entdecken Sie unsere maßgeschneiderten Kulinarik-Angebote für Gruppen – vom Bier bis zur BIO-Schokolade, alles in entspannter Atmosphäre.</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>

		<!-- 6 -->
		<div class="col-md-4 col-12 mb-4">
			<div class="flip-card">
				<div class="flip-card-inner">
					<div class="flip-card-front">
						<img src="<?= base_url('img/image/card_wcc.jpg') ?>" alt="Ermäßigungen" class="card-image-fix mb-2">
						<h3 class="mt-2">Ermäßigungen</h3>
					</div>
					<div class="flip-card-back">
						<h4 class="text-center text-success">Ermäßigungen</h4>
						<p>Profitieren Sie von attraktiven Vorteilen mit der NÖ-Card, Familienpass oder Wilde Wunder Card – ideal für Ihren Ausflug ins Pielachtal!</p>
						<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
					</div>
				</div>
			</div>
		</div>
		<h3 class="text-success mt-5">Preise & Öffnungszeiten</h3>
		<div class="row text-center">
			<!-- 1 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/individual.jpg') ?>" alt="Individualbesucher" class="card-image-fix mb-2">
							<h3 class="mt-2">Individualbesucher</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Individualbesucher</h4>
							<p>Besuchen Sie uns individuell zwischen April und Oktober – entdecken Sie die Welt von STYX auf eigene Faust oder bei einer offenen Führung.</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 2 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/gruppen.jpg') ?>" alt="Gruppenangebote" class="card-image-fix mb-2">
							<h3 class="mt-2">Gruppenangebote</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Gruppenangebote</h4>
							<p>Erleben Sie maßgeschneiderte Führungen für Gruppen – mit optionalem Bier, Schokolade oder kulinarischem Rahmenprogramm.</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 3 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/wcc_fuehrung.jpg') ?>" alt="Touren auf Englisch" class="card-image-fix mb-2">
							<h3 class="mt-2">Touren auf Englisch</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Touren auf Englisch</h4>
							<p>We also offer guided tours in English for groups or individual visitors. Please contact us in advance for available dates.</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h3 class="text-success mt-5">Angebote für Kinder</h3>
		<div class="row text-center">
			<!-- 1 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/kinder1.jpg') ?>" alt="Kinderführungen" class="card-image-fix mb-2">
							<h3 class="mt-2">Kinderführungen</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Kinderführungen</h4>
							<p>Kindgerechte Erlebnisse mit spannenden Einblicken in die Welt der Naturkosmetik und Schokolade. Ferienangebote inklusive!</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 2 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/schulen.jpg') ?>" alt="Angebote für Schulen" class="card-image-fix mb-2">
							<h3 class="mt-2">Angebote für Schulen</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Angebote für Schulen</h4>
							<p>Interaktive Führungen und Workshops speziell für Schulklassen. Lernen durch Erleben in der World of STYX!</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 3 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/kindergeburtstage.jpg') ?>" alt="Kindergeburtstage" class="card-image-fix mb-2">
							<h3 class="mt-2">Kindergeburtstage</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Kindergeburtstage</h4>
							<p>Feiern Sie Kindergeburtstage der besonderen Art – mit Naturkosmetik oder Schokoladenworkshop als Highlight!</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Mehr Informationen</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<h3 class="text-success mt-5">Kontakt & Anfahrt</h3>
		<div class="row text-center">
			<!-- 1 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/wcc_gebeude.jpg') ?>" alt="Kontakt" class="card-image-fix mb-2">
							<h3 class="mt-2">Kontakt</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Kontakt</h4>
							<p>STYX Welcome Center<br>Ritzersdorfer Straße 11, 3200 Ober-Grafendorf<br>Telefon: +43 2747 3250 51<br>Email: firmenbesichtigung@styx.at</p>
							<a href="mailto:firmenbesichtigung@styx.at" class="btn btn-outline-success btn-sm mt-auto">E-Mail schreiben</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 2 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/stender_wcc.jpg') ?>" alt="Anfahrt" class="card-image-fix mb-2">
							<h3 class="mt-2">Anfahrt</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Anfahrt</h4>
							<p>Reisen Sie umweltfreundlich mit der Mariazellerbahn an. Vom Bahnhof Ober-Grafendorf sind es nur 150 m bis zur World of STYX!</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Zur Anfahrtskarte</a>
						</div>
					</div>
				</div>
			</div>

			<!-- 3 -->
			<div class="col-md-4 col-12 mb-4">
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<img src="<?= base_url('img/image/gutzuwissen.jpg') ?>" alt="Gut zu wissen" class="card-image-fix mb-2">
							<h3 class="mt-2">Gut zu wissen</h3>
						</div>
						<div class="flip-card-back">
							<h4 class="text-success text-center">Gut zu wissen</h4>
							<p>Barrierefreiheit, Ermäßigungen, Partnerkarten und vieles mehr – alles was Sie für Ihren Besuch wissen sollten.</p>
							<a href="#" class="btn btn-outline-success btn-sm mt-auto">Alle Infos</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="text-center mt-4">
		<a href="#" class="btn btn-success me-2 px-4">Partnerbetriebe</a>
		<a href="#" class="btn btn-success px-4">Feedback geben</a>
	</div>
	<h3 class="text-success mt-5">Unsere Vorteilspartner</h3>
	<div class="row text-center justify-content-center align-items-center gy-4">
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://www.top-ausflug.at/" target="_blank">
				<img src="<?= base_url('img/image/top_ausflugsziel.jpg') ?>" class="img-fluid" alt="TOP-Ausflugsziel">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://www.niederoesterreich-card.at/" target="_blank">
				<img src="<?= base_url('img/image/card_niederosterreich.jpg') ?>" class="img-fluid" alt="NÖ-Card">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://familienpass.at/" target="_blank">
				<img src="<?= base_url('img/image/familienpass.jpg') ?>" class="img-fluid" alt="Familienpass">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://www.mostviertel.at/wilde-wunder-card" target="_blank">
				<img src="<?= base_url('img/image/WWC_Erwachsene_freigestellt_schraegNEU B990.png') ?>" class="img-fluid" alt="Wilde Wunder Card">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://family-cherries.com/events/styx/world-of-styx-1" target="_blank">
				<img src="<?= base_url('img/image/Partner_Logo_ohne-URL.png') ?>" class="img-fluid" alt="Family Bonus Card">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="https://www.naturimgarten.at/schaug%C3%A4rten.html" target="_blank">
				<img src="<?= base_url('img/image/Schaugarten_logo.jpg') ?>" class="img-fluid" alt="Partnerkarte 1">
			</a>
		</div>
		<div class="col-lg-1 col-md-2 col-3">
			<a href="<?=BASE_URL?>" target="_blank">
				<img src="<?= base_url('img/image/wirfurweinburg.jpg') ?>" class="img-fluid" alt="Partnerkarte 2">
			</a>
		</div>
	</div>


</section>
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="bookingModalLabel">Onlinebuchung – STYX Erlebnisführung</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
			</div>
			<div class="modal-body" style="height:80vh;">
				<iframe src="https://styx.regiondo.de/bookingwidget/vendor/34660/id/167063"
						width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen>
				</iframe>
			</div>
		</div>
	</div>
</div>
