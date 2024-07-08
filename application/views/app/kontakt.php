<style>
	.text-background {
		display: inline-block;
		background-color: rgba(255, 255, 255, 0.8); /* Jemne biele pozadie */
		color: black;
		padding: 30px;
		border-radius: 5px;
	}
	.info-card {
		border: 1px solid #ccc;
		border-radius: 5px;
		padding: 20px;
		margin-bottom: 20px;
		text-align: center;
		background-color: #f9f9f9;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		height: 100%;
	}
	.info-card-header {
		background-color: rgba(255, 255, 255, 0.03);
		color: #6780dd;
		padding: 10px;
		border-radius: 15px;

	}
	.info-card-header i {
		font-size: 24px;
		margin-bottom: 5px;
	}
	.info-title {
		font-size: 18px;
		font-weight: bold;
		margin-top: 10px;
	}
	.info-content {
		font-size: 16px;
		padding: 10px;
	}
	.row-equal {
		display: flex;
	}
	.row-equal > [class*='col-'] {
		display: flex;
		flex-direction: column;
	}
</style>

<div role="main" class="main">
	<section class="page-header page-header-modern page-header-background page-header-background-md" style="background-image: url(<?=BASE_URL?>img/remise/remiseBanner.jpg);">
		<div class="container">
			<div class="row mt-5">
				<div class="col-md-12 align-self-center p-static order-2 text-center">
					<div class="text-background">
						<h1 style="color: #0a0a0a" class="text-9 font-weight-bold"><?=$title?></h1>
						<span style="color: #0a0a0a" class="sub-title">REMISE | STYX Naturcosmetic</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="container mt-5">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="font-weight-bold text-8 mt-2 mb-0">Kontakt - Anfahrt - Anreise</h2>
				<p class="mb-4">Die Anreise ist mit dem Auto, per Bus oder ganz bequem mit der <a href="https://www.mariazellerbahn.at/">Mariazellerbahn</a> möglich. Ausreichend <b>Parkplätze</b> stehen ebenfalls zur Verfügung!</p>
			</div>
		</div>
		<div class="row row-equal py-4">
			<div class="col-lg-4 mb-4">
				<div class="info-card">
					<div class="info-card-header">
						<i class="fas fa-map-marker-alt"></i>
						<div class="info-title">Adresse</div>
					</div>
					<div class="info-content">
						<?='<strong>'.COMPANY.'</strong>'.'<br>'.ADRESS.'<br>'.ZIP.' '.CITY?>
					</div>
				</div>
			</div>
			<div class="col-lg-4 mb-4">
				<div class="info-card">
					<div class="info-card-header">
						<i class="fas fa-phone"></i>
						<div class="info-title">Telefon</div>
					</div>
					<div class="info-content">
						<?='<strong>'.FIRMA_PERSON.'</strong>'.' <br> '.PHONE.'<br>'.TELEFON?>
					</div>
				</div>
			</div>
			<div class="col-lg-4 mb-4">
				<div class="info-card">
					<div class="info-card-header">
						<i class="fas fa-envelope"></i>
						<div class="info-title">E-mail</div>
					</div>
					<div class="info-content">
						<a href="mailto:sonja.faschingeder@styx.at">Betriebsführung</a>
					</div>
					<div class="info-content">
						<a href="mailto:<?=MAIL_ADMIN?>"><?=MAIL_ADMIN?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2661.869863464505!2d15.536554076961217!3d48.151314071245146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477279d3e6303193%3A0x9c939830e3fcc535!2sSTYX%20Remise!5e0!3m2!1ssk!2sat!4v1720016434071!5m2!1ssk!2sat" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
