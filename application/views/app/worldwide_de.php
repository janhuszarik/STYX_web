<style>
	.land {
		fill: #ccc;
		fill-opacity: 1;
		stroke: white;
		stroke-opacity: 1;
		stroke-width: 0.5;
		transition: 0.2s ease-out;
		cursor: pointer; /* Pridáme kurzor pointer, aby bolo vidieť, že je to klikateľné */
	}

	/* Farby pre rôzne skupiny štátov */
	.group-1 {
		fill: #f40000;
	}
	.group-3 {
		fill: #1b6ac1;
	}
	.group-4 {
		fill: #33a02c;
	}

	.land:hover {
		fill: #cca728;
	}

	.modal {
		display: none; /* Skryjeme modal, pokiaľ nie je aktívny */
		position: fixed;
		z-index: 1;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		background-color: #fefefe;
		margin: 15% auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
	}

	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.tooltipStyle {
		color: #0a0e14;
		font-weight: bold;
		font-size: 16px;
		background-color: #f1f1f1;
	}

	.list-containerMap {
		display: flex;
		flex-wrap: wrap;
		gap: 60px;
	}
</style>
<div role="main" class="main">
	<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-primary overlay-show overlay-op-9 mb-0" style="background-image: url(<?=$image1?>);">
		<div class="container translucent-background">
			<div class="row">
				<div class="col align-self-center p-static text-center">
					<h1 style="color:#000;"><?=$title?></h1>
					<span style="color: #0a0a0a" class="sub-title"><?=$description?></span>
				</div>
			</div>
		</div>
	</section>
	<section class="page-header bg-color-light border-bottom border-width-2 translucent-background">
		<div class="container">
			<div class="row">
				<div class="col align-self-center p-static">
					<ul class="breadcrumb d-block">
						<li><a href="<?=BASE_URL?>">Home</a></li>
						<li class="active"><?=$title?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="container py-4">
	<div class="row">
		<div class="col">
			<div class="blog-posts single-post">
				<article class="post post-large blog-single-post border-0 m-0 p-0">
					<div class="post-content ms-0">
						<h2 style="color: #aad998" class="font-weight-semi-bold">Ihr zuverlässiger Partner</h2>
						<div class="post-meta">
							<h4 class="text-color-black">Hier finden Sie alle Kontaktadressen unserer weltweiten Vertriebspartner.
								<br> Bitte wenden Sie sich an die untenstehenden Kontakte Ihres Landes. <br>
								Sollte in Ihrem Land kein Kontakt vorhanden sein, freuen wir uns unter export@styx.at auf Ihre Anfrage – Anita Wittmann, Export
							</h4>
						</div>
						<div id="myModal" class="modal">
							<div class="modal-content">
								<span class="close">&times;</span>
								<p id="countryInfo">.</p>
							</div>
						</div>
						<br><br>
						<strong class="text-color-black"><?=lang('MAP_LEGENDE')?>:</strong>
						<div class="col-lg-12">
							<div class="list-containerMap">
								<ul class="list list-icons list-icons-style-3 list-primary">
									<li><i class="fas fa-location"></i> <?=lang('WORLD_PARTNER_GREEN')?></li>
								</ul>

								<ul class="list list-icons list-icons-style-3 list-tertiary">
									<li><i class="fas fa-location"></i> <?=lang('WORLD_PARTNER_BLUE')?></li>
								</ul>

								<ul class="list list-icons list-icons-style-3 list-yellow">
									<li><i class="fas fa-location"></i> <?=lang('WORLD_PARTNER_YELLOW')?></li>
								</ul>

								<ul class="list list-icons list-icons-style-3 list-white">
									<li><i class="fas fa-check"></i> <?=lang('WORLD_PARTNER_OTHER_COUNTRIES')?></li>
								</ul>
							</div>
						</div>

						<div class="wrap text-center">
							<div class="tooltipStyle" id="tooltip"><?=lang('SELECT_COUNTRY')?></div>
							<br><br>

							<svg id="map" viewBox="0 0 1050 650" xmlns="http://www.w3.org/2000/svg">
								<g>
									<path id="AE" title="United Arab Emirates" class="land" d="M619.87,393.72L620.37,393.57L620.48,394.41L622.67,393.93L624.99,394.01L626.68,394.1L628.6,392.03L630.7,390.05L632.47,388.15L633,389.2L633.38,391.64L631.95,391.65L631.72,393.65L632.22,394.07L630.95,394.67L630.94,395.92L630.12,397.18L630.05,398.39L629.48,399.03L621.06,397.51L619.98,394.43z"/>
									<path id="AF" title="Afghanistan" class="land" d="M646.88,356.9L649.74,358.2L651.85,357.74L652.44,356.19L654.65,355.67L656.23,354.62L656.79,351.83L659.15,351.15L659.59,349.9L660.92,350.84L661.76,350.95L663.32,350.98L665.44,351.72L666.29,352.14L668.32,351.02L669.27,351.69L670.17,350.09L671.85,350.16L672.28,349.64L672.58,348.21L673.79,346.98L675.3,347.78L675,348.87L675.85,349.04L675.58,351.99L676.69,353.14L677.67,352.4L678.92,352.06L680.66,350.49L682.59,350.75L685.49,350.75L685.99,351.76L684.35,352.15L682.93,352.8L679.71,353.2L676.7,353.93L675.06,355.44L675.72,356.9L676.05,358.6L674.65,360.03L674.77,361.33L674,362.55L671.33,362.44L672.43,364.66L670.65,365.51L669.46,367.51L669.61,369.49L668.51,370.41L667.48,370.11L665.33,370.54L665.03,371.45L662.94,371.45L661.38,373.29L661.28,376.04L657.63,377.37L655.68,377.09L655.11,377.79L653.44,377.39L650.63,377.87L645.94,376.23L648.48,373.3L648.25,371.2L646.13,370.65L645.91,368.56L644.99,365.92L646.19,364.09L644.97,363.6L645.74,361.15z"/>
								</g>
							</svg>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', (event) => {
		const map = document.getElementById('map');
		const toolTip = document.getElementById('tooltip');
		const message = toolTip.innerHTML;
		const modal = document.getElementById("myModal");
		const span = document.getElementsByClassName("close")[0];
		const countryInfo = document.getElementById('countryInfo');

		// grab the country name and display
		function showCountryName(event) {
			let countryName = event.target.getAttribute('title');
			toolTip.innerHTML = countryName;
		}

		// show the default text
		function hideCountryName() {
			toolTip.innerHTML = message;
		}

		// set event listener on the map
		map.addEventListener('mouseover', function(event){
			// if the mouse hovers over a country
			if (event.target.classList.contains('land')) {
				showCountryName(event);
			} else {
				hideCountryName();
			}
		});

		// set event listener on click for showing country name
		map.addEventListener('click', function(event){
			// if the country is clicked
			if (event.target.classList.contains('land')) {
				let countryName = event.target.getAttribute('title');
				let countryDescription = countryDescriptions[countryName];
				countryInfo.innerHTML = `<strong>${countryName}</strong>: ${countryDescription}`; // Zmeňte obsah podľa potreby
				modal.style.display = "block";
			}
		});

		// close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}

		// Country descriptions
		const countryDescriptions = {
			"United Arab Emirates": `Popis pre Spojené arabské emiráty v zvolenom jazyku. <a href="https://example.com">Viac informácií</a>`,
			"Afghanistan": `Zastúpenie pre krajinu Azerbaijan je. <a href="https://sultansaba.az/sultansabais/" target="_blank">Sultan Saba</a>`
			// Pridajte ďalšie krajiny a ich popisy podľa potreby
		};
	});
</script>


