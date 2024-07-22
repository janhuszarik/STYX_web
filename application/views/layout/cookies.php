<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STYX</title>
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/custom.css">
</head>
<body>
<!-- Obsah stránky -->

<!-- HTML pre banner -->
<!-- HTML pre banner -->
<div id="customCookieConsentBanner" class="custom-banner">
	<div class="custom-banner-content">
		<div class="custom-banner-text-container">
			<h2 class="custom-banner-heading">Hallo STYX-Webseitenbenutzer, es ist Zeit für Cookies!</h2>
			<p class="custom-banner-text">Unsere Website verwendet notwendige Cookies, um die ordnungsgemäße Funktion sicherzustellen, und Tracking-Cookies, um zu verstehen, wie Sie mit ihnen interagieren. Cookies werden erst nach Ihrer Zustimmung gesetzt</p>
			<a href="<?=BASE_URL.'cookies'?>" class="custom-banner-link">Mehr erfahren</a>
		</div>
		<div class="custom-banner-buttons-container">
			<button id="customAgreeAll" class="btn btn-primary custom-button">Alles akzeptieren</button>
			<button id="customSettings" class="btn btn-secondary custom-button">Einstellungen</button>
		</div>
	</div>
</div>

<!-- HTML pre modal okno -->
<div id="customCookieConsentModal" class="custom-modal" style="display: none;">
	<div class="custom-modal-content">
		<h2 class="custom-modal-heading">Cookie-Einstellungen</h2>

		<div class="custom-cookie-section card card-default">
			<div class="card-header d-flex justify-content-between align-items-center" id="customCollapseNecessaryHeading">
				<h4 class="card-title m-0">
					<a class="accordion-toggle text-color-dark font-weight-normal collapsed" data-bs-toggle="collapse" data-bs-target="#customCollapseNecessary" aria-expanded="false" aria-controls="customCollapseNecessary">
						<span class="accordion-arrow">➤</span> Notwendige Cookies
					</a>
				</h4>
				<label class="switch">
					<input type="checkbox" checked disabled>
					<span class="slider round"></span>
				</label>
			</div>
			<div id="customCollapseNecessary" class="collapse" aria-labelledby="customCollapseNecessaryHeading">
				<div class="card-body pt-0">
					<p class="custom-cookie-description">Notwendige Cookies tragen dazu bei, nutzbare Websites zu erstellen, indem sie Funktionen wie die Seitenavigation und den Zugang zu sicheren Bereichen von Websites ermöglichen. Websites können ohne notwendige Cookies nicht ordnungsgemäß funktionieren. Eine Einschränkung ihrer Verarbeitung kann zu einer fehlerhaften Funktion der Website oder einer Einschränkung der Website-Funktionalität führen. Rechtliche Grundlage für die Verarbeitung notwendiger Cookies - gemäß dem Gesetz ist es möglich, notwendige Cookies ohne Zustimmung der betroffenen Person zu verarbeiten.</p>
				</div>
			</div>
		</div>

		<div class="custom-cookie-section card card-default">
			<div class="card-header d-flex justify-content-between align-items-center" id="customCollapsePerformanceHeading">
				<h4 class="card-title m-0">
					<a class="accordion-toggle text-color-dark font-weight-normal collapsed" data-bs-toggle="collapse" data-bs-target="#customCollapsePerformance" aria-expanded="false" aria-controls="customCollapsePerformance">
						<span class="accordion-arrow">➤</span> Performance Cookies
					</a>
				</h4>
				<label class="switch">
					<input type="checkbox" id="customPerformanceCookies">
					<span class="slider round"></span>
				</label>
			</div>
			<div id="customCollapsePerformance" class="collapse" aria-labelledby="customCollapsePerformanceHeading">
				<div class="card-body pt-0">
					<p class="custom-cookie-description">Performance-Cookies helfen uns zu verstehen, wie Benutzer unsere Website nutzen, z.B. welche Seiten am häufigsten besucht werden oder ob Benutzer Fehlermeldungen von Webseiten erhalten. Diese Cookies sammeln keine Informationen, die einen Besucher identifizieren könnten. Alle Informationen, die diese Cookies sammeln, sind anonym und dienen nur dazu, die Funktionsweise der Website zu verbessern.</p>
				</div>
			</div>
		</div>

		<div class="custom-cookie-section card card-default">
			<div class="card-header d-flex justify-content-between align-items-center" id="customCollapseFunctionalHeading">
				<h4 class="card-title m-0">
					<a class="accordion-toggle text-color-dark font-weight-normal collapsed" data-bs-toggle="collapse" data-bs-target="#customCollapseFunctional" aria-expanded="false" aria-controls="customCollapseFunctional">
						<span class="accordion-arrow">➤</span> Funktionale Cookies
					</a>
				</h4>
				<label class="switch">
					<input type="checkbox" id="customFunctionalCookies">
					<span class="slider round"></span>
				</label>
			</div>
			<div id="customCollapseFunctional" class="collapse" aria-labelledby="customCollapseFunctionalHeading">
				<div class="card-body pt-0">
					<p class="custom-cookie-description">Funktionale Cookies ermöglichen es der Website, sich Ihre Auswahl zu merken (z.B. Benutzername, Sprache oder Region) und erweiterte, persönlichere Funktionen bereitzustellen. Die Informationen, die diese Cookies sammeln, können anonymisiert werden und können Ihre Aktivitäten auf anderen Websites nicht nachverfolgen.</p>
				</div>
			</div>
		</div>

		<div class="custom-cookie-section card card-default">
			<div class="card-header d-flex justify-content-between align-items-center" id="customCollapseTargetingHeading">
				<h4 class="card-title m-0">
					<a class="accordion-toggle text-color-dark font-weight-normal collapsed" data-bs-toggle="collapse" data-bs-target="#customCollapseTargeting" aria-expanded="false" aria-controls="customCollapseTargeting">
						<span class="accordion-arrow">➤</span> Targeting Cookies
					</a>
				</h4>
				<label class="switch">
					<input type="checkbox" id="customTargetingCookies">
					<span class="slider round"></span>
				</label>
			</div>
			<div id="customCollapseTargeting" class="collapse" aria-labelledby="customCollapseTargetingHeading">
				<div class="card-body pt-0">
					<p class="custom-cookie-description">Targeting-Cookies werden verwendet, um Besucher auf Websites zu verfolgen. Ziel ist es, Anzeigen anzuzeigen, die für den einzelnen Benutzer relevant und ansprechend sind. Diese Cookies merken sich, dass Sie eine Website besucht haben, und diese Informationen werden mit anderen Organisationen wie Werbeunternehmen geteilt.</p>
				</div>
			</div>
		</div>

		<div class="custom-contact-card card card-default">
			<div class="custom-contact-card-body d-flex justify-content-between align-items-center">
				<p class="custom-contact-text">Bei Fragen können Sie uns gerne kontaktieren.</p>
				<a href="<?=BASE_URL.'kontakt'?>"><button class="btn btn-primary custom-contact-button">Kontaktieren Sie uns</button></a>
			</div>
		</div>

		<div class="custom-modal-buttons">
			<button id="customSavePreferences" class="btn btn-success custom-button">Speichern</button>
			<button id="customAcceptNecessaryOnly" class="btn btn-info custom-button">Akzeptieren Sie nur notwendige Cookies</button>
		</div>
	</div>
</div>

<!-- HTML pre ikonu v rohu -->
<div id="customCookieIcon" class="custom-cookie-icon" style="display: none;">
	<img src="<?=BASE_URL?>img/cookies.png" alt="Cookies" />
</div>



<script src="<?=BASE_URL?>assets/js/custom.js"></script>
</body>
</html>
