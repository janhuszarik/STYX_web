// -----------------------------------------------------------------------------------------------------------------------
// Nastavenie karuselu s lazy loading
// Tento kód inicializuje dva karusely s rôznymi počtami kariet pri načítaní okna
$(document).ready(function(){
	$('.news-carousel').owlCarousel({
		items: 4,
	});

	$('.product-carousel').owlCarousel({
		items: 6,
		loop: true,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000, // 5 sekúnd
		autoplayHoverPause: true,
		smartSpeed: 1000, // Rýchlosť animácie
		fluidSpeed: true, // Plynulý prechod
	});
});

// Koniec nastavenia karuselu
// -----------------------------------------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------------------------------------
// Automatický posun snímok
// Tento kód nastavuje automatický posun snímok každých 6 sekúnd a umožňuje manuálny posun snímok kliknutím na tlačidlá
$(document).ready(function () {
	var slides = $('.slider-section');
	var currentIndex = 0;
	var slideInterval = setInterval(showNextSlide, 6000); // Zmena snímky každých 6 sekúnd

	function showNextSlide() {
		slides.eq(currentIndex).removeClass('active');
		currentIndex = (currentIndex + 1) % slides.length;
		slides.eq(currentIndex).addClass('active');
	}

	function showPrevSlide() {
		slides.eq(currentIndex).removeClass('active');
		currentIndex = (currentIndex - 1 + slides.length) % slides.length;
		slides.eq(currentIndex).addClass('active');
	}

	$('.next').click(function () {
		clearInterval(slideInterval);
		showNextSlide();
		slideInterval = setInterval(showNextSlide, 6000);
	});

	$('.prev').click(function () {
		clearInterval(slideInterval);
		showPrevSlide();
		slideInterval = setInterval(showNextSlide, 6000);
	});
});
// Koniec automatického posunu snímok
// -----------------------------------------------------------------------------------------------------------------------


// -----------------------------------------------------------------------------------------------------------------------
// Nastavenie rozbaľovacieho menu
// Tento kód zabezpečuje správne správanie rozbaľovacích menu na rôznych veľkostiach obrazovky a umožňuje klikateľnosť jazykových vlajok
document.addEventListener("DOMContentLoaded", function () {
	var toggles = document.querySelectorAll(".dropdown-toggle");
	toggles.forEach(function (toggle) {
		toggle.addEventListener("click", function (e) {
			if (window.innerWidth <= 768) {
				e.preventDefault();
				var menu = this.nextElementSibling;
				if (menu.style.display === "block") {
					menu.style.display = "none";
				} else {
					menu.style.display = "block";
				}
			}
		});
	});

	// Uistite sa, že rozbaľovacie menu zostane otvorené pri hover a kliknutí na väčších obrazovkách
	var dropdowns = document.querySelectorAll('.dropdown-menu');
	dropdowns.forEach(function (dropdown) {
		dropdown.addEventListener('mouseenter', function () {
			this.style.display = 'block';
		});
		dropdown.addEventListener('mouseleave', function () {
			if (window.innerWidth > 768) {
				this.style.display = 'none';
			}
		});
		dropdown.addEventListener('click', function (e) {
			e.stopPropagation();
		});
	});

	var navItems = document.querySelectorAll('.nav-item.dropdown');
	navItems.forEach(function (navItem) {
		navItem.addEventListener('click', function (e) {
			if (window.innerWidth > 768 && window.innerWidth < 1025) {
				e.preventDefault();
				var dropdown = this.querySelector('.dropdown-menu');
				if (dropdown.style.display === 'block') {
					dropdown.style.display = 'none';
				} else {
					dropdown.style.display = 'block';
				}
			}
		});
	});

	document.addEventListener('click', function (e) {
		if (window.innerWidth > 768 && window.innerWidth < 1025) {
			dropdowns.forEach(function (dropdown) {
				dropdown.style.display = 'none';
			});
		}
	});

	// Pridanie skriptu na zabezpečenie klikateľnosti jazykových vlajok a zmenu jazyka
	var langLinks = document.querySelectorAll('.lang a');
	langLinks.forEach(function (link) {
		link.addEventListener('click', function (event) {
			event.preventDefault();
			window.location.href = link.getAttribute('href');
		});
	});

	// Skript na presun jazykových vlajok na spodok alebo vrch menu na mobilných zariadeniach
	function moveLanguageFlags() {
		var flagsContainer = document.querySelector('.mobile-lang-flags');
		if (window.innerWidth <= 768) {
			var nav = document.querySelector('.header-nav-main nav');
			if (flagsContainer) {
				// Presun vlajok na spodok menu
				nav.appendChild(flagsContainer);
				// Alebo presun vlajok na vrch menu
				// nav.insertBefore(flagsContainer, nav.firstChild);
			}
		}
	}

	moveLanguageFlags();
	window.addEventListener('resize', moveLanguageFlags);
});
// Koniec nastavenia rozbaľovacieho menu
// ------------------------------------------------------------------------------------------------------------------------

// -----------------------------------------------------------------------------------------------------------------------
// Modal okno pre kupovanie lístkov
// Tento kód zabezpečuje otváranie a zatváranie modal okna pre kupovanie lístkov
document.addEventListener('DOMContentLoaded', (event) => {
	var modal = document.getElementById("wordOfStyx-myModal");
	var btn = document.getElementById("wordOfStyx-openModalBtn");
	var span = document.getElementsByClassName("wordOfStyx-close")[0];
	var iframe = document.getElementById("wordOfStyx-modalFrame");

	btn.onclick = function() {
		iframe.src = "https://styx.regiondo.de/bookingwidget/vendor/34660/id/167063";
		modal.style.display = "block";
	}

	span.onclick = function() {
		modal.style.display = "none";
		iframe.src = ""; // Vyčistenie zdroja iframe, aby sa zastavilo načítavanie
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			iframe.src = ""; // Vyčistenie zdroja iframe, aby sa zastavilo načítavanie
		}
	}
});
// Koniec modal okna pre kupovanie lístkov
// ------------------------------------------------------------------------------------------------------------------------
