$(document).ready(function(){
	$('.news-carousel').owlCarousel({
		items: 4,
		margin: 10,
		loop: true,
		nav: false,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true
	});
});

$(window).on('load', function(){
	var productCarousel = $('.product-carousel').owlCarousel({
		items: 6,
		loop: true,
		nav: false,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		smartSpeed: 1000,
		fluidSpeed: true
	});

	$('.custom-next').click(function() {
		productCarousel.trigger('next.owl.carousel');
	});
	$('.custom-prev').click(function() {
		productCarousel.trigger('prev.owl.carousel');
	});
});

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
