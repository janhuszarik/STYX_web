// -----------------------------------------------------------------------------------------------------------------------
// js nastavenie pre slider:
$(window).on('load', function () {
	$(".owl-carousel").owlCarousel();
});

$(document).ready(function () {
	var slides = $('.slider-section');
	var currentIndex = 0;
	var slideInterval = setInterval(showNextSlide, 6000); // Change slide every 6 seconds

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
// -----------------------------------------------------------------------------------------------------------------------
// js nastavenie pre menu:

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

	// Ensure the dropdown stays open on hover and click for larger screens
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

	// Added script to ensure language flags are clickable and change language
	var langLinks = document.querySelectorAll('.lang a');
	langLinks.forEach(function (link) {
		link.addEventListener('click', function (event) {
			event.preventDefault();
			window.location.href = link.getAttribute('href');
		});
	});

	// New script to move language flags to the bottom or top of the menu on mobile
	function moveLanguageFlags() {
		var flagsContainer = document.querySelector('.mobile-lang-flags');
		if (window.innerWidth <= 768) {
			var nav = document.querySelector('.header-nav-main nav');
			if (flagsContainer) {
				// Move flags to the bottom of the menu
				nav.appendChild(flagsContainer);
				// Or move flags to the top of the menu
				// nav.insertBefore(flagsContainer, nav.firstChild);
			}
		}
	}

	moveLanguageFlags();
	window.addEventListener('resize', moveLanguageFlags);
});

// koniec js pre menu:
// ------------------------------------------------------------------------------------------------------------------------



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
		iframe.src = ""; // Clear the iframe source to stop loading
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			iframe.src = ""; // Clear the iframe source to stop loading
		}
	}
});

// koniec js pre modal okno kupovania lístkov:
// ------------------------------------------------------------------------------------------------------------------------

