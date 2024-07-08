document.addEventListener("DOMContentLoaded", function() {
	var banner = document.getElementById("customCookieConsentBanner");
	var modal = document.getElementById("customCookieConsentModal");
	var agreeAllButton = document.getElementById("customAgreeAll");
	var settingsButton = document.getElementById("customSettings");
	var savePreferencesButton = document.getElementById("customSavePreferences");
	var acceptNecessaryOnlyButton = document.getElementById("customAcceptNecessaryOnly");
	var cookieIcon = document.getElementById("customCookieIcon");

	// Zobrazenie banneru, ak cookies neboli prijaté
	if (getCookie("cookie_consent") !== "true" && getCookie("cookie_consent") !== "false") {
		banner.style.display = "block";
	} else {
		cookieIcon.style.display = "block";
	}

	// Akcia pri kliknutí na tlačidlo "Alles akzeptieren"
	agreeAllButton.onclick = function() {
		setAllCookies(true);
		banner.style.display = "none";
		cookieIcon.style.display = "block";
	}

	// Akcia pri kliknutí na tlačidlo "Einstellungen"
	settingsButton.onclick = function() {
		banner.style.display = "none";
		modal.style.display = "block";
	}

	// Akcia pri kliknutí na tlačidlo "Speichern"
	savePreferencesButton.onclick = function() {
		setCookiesFromPreferences();
		modal.style.display = "none";
		cookieIcon.style.display = "block";
	}

	// Akcia pri kliknutí na tlačidlo "Akzeptieren Sie nur notwendige Cookies"
	acceptNecessaryOnlyButton.onclick = function() {
		setOnlyNecessaryCookies();
		modal.style.display = "none";
		cookieIcon.style.display = "block";
	}

	// Funkcia na nastavenie všetkých cookies
	function setAllCookies(accept) {
		setCookie('cookie_consent', accept ? 'true' : 'false');
		setCookie('performance_cookies', accept ? 'true' : 'false');
		setCookie('functional_cookies', accept ? 'true' : 'false');
		setCookie('targeting_cookies', accept ? 'true' : 'false');
	}

	// Funkcia na nastavenie len nevyhnutných cookies
	function setOnlyNecessaryCookies() {
		setCookie('cookie_consent', 'true');
		setCookie('performance_cookies', 'false');
		setCookie('functional_cookies', 'false');
		setCookie('targeting_cookies', 'false');
	}

	// Funkcia na nastavenie cookies podľa preferencií
	function setCookiesFromPreferences() {
		setCookie('cookie_consent', 'true');
		setCookie('performance_cookies', document.getElementById("customPerformanceCookies").checked ? 'true' : 'false');
		setCookie('functional_cookies', document.getElementById("customFunctionalCookies").checked ? 'true' : 'false');
		setCookie('targeting_cookies', document.getElementById("customTargetingCookies").checked ? 'true' : 'false');
	}

	// Funkcia na nastavenie cookies
	function setCookie(name, value) {
		document.cookie = name + "=" + value + "; path=/; max-age=" + 365*24*60*60;
	}

	// Funkcia na získanie hodnoty cookies
	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	// Zobrazenie modalu pri kliknutí na ikonu
	cookieIcon.onclick = function() {
		modal.style.display = "block";
	}
});
function getRandomAnimation() {
	const animations = ['bounce', 'flash', 'pulse', 'rubberBand', 'shakeX', 'shakeY', 'headShake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'backInDown', 'backInLeft', 'backInRight', 'backInUp', 'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'flip', 'flipInX', 'flipInY', 'lightSpeedInRight', 'lightSpeedInLeft', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp'];
	return animations[Math.floor(Math.random() * animations.length)];
}

$(document).ready(function() {
	$('#sliderCarousel').on('slide.bs.carousel', function () {
		const currentItem = $(this).find('.carousel-item.active');
		currentItem.find('.animate__animated').removeClass().addClass('animate__animated ' + getRandomAnimation());
	});
});
