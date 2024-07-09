$(document).ready(function() {
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

	$('.next').click(function() {
		clearInterval(slideInterval);
		showNextSlide();
		slideInterval = setInterval(showNextSlide, 6000);
	});

	$('.prev').click(function() {
		clearInterval(slideInterval);
		showPrevSlide();
		slideInterval = setInterval(showNextSlide, 6000);
	});
});
