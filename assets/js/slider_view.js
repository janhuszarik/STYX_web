document.addEventListener('DOMContentLoaded', function () {
	let currentSlide = 0;
	const slides = document.querySelectorAll('.slider-wrapper');
	const pauseBtn = document.getElementById('pauseBtn');
	const ring = document.querySelector('.progress-ring-circle');

	const radius = 22;
	const circumference = 2 * Math.PI * radius;

	ring.style.strokeDasharray = `${circumference}`;
	ring.style.strokeDashoffset = `${circumference}`;

	let slideIntervalTime = 5; // sekundy
	let isPaused = false;
	let interval, progressInterval;

	function setProgress(percent) {
		const offset = circumference - percent * circumference;
		ring.style.strokeDashoffset = offset;
	}

	function showSlide(index) {
		slides.forEach((s, i) => {
			s.classList.toggle('active', i === index);
			s.setAttribute('aria-hidden', i !== index);
		});
		resetProgress(); // Reset progresu pri zmene slidu
	}

	function nextSlide() {
		currentSlide = (currentSlide + 1) % slides.length;
		showSlide(currentSlide);
	}

	function prevSlide() {
		currentSlide = (currentSlide - 1 + slides.length) % slides.length;
		showSlide(currentSlide);
	}

	function resetProgress() {
		setProgress(0); // Reset progresného kruhu
		clearInterval(progressInterval); // Zastav starý progres
		let progress = 0;
		const step = 100 / (slideIntervalTime * 1000 / 50); // každých 50ms

		progressInterval = setInterval(() => {
			if (!isPaused) {
				progress += step;
				if (progress > 100) progress = 100;
				setProgress(progress / 100);
			}
		}, 50);
	}

	function startSlider() {
		stopSlider();
		interval = setInterval(() => {
			if (!isPaused) {
				nextSlide();
			}
		}, slideIntervalTime * 1000);
		resetProgress(); // Spusti progres pre prvý slide
	}

	function stopSlider() {
		clearInterval(interval);
		clearInterval(progressInterval);
	}

	// Pauza/Play tlačidlo
	pauseBtn.addEventListener('click', () => {
		isPaused = !isPaused;
		const icon = pauseBtn.querySelector('i');
		icon.classList.toggle('fa-pause', !isPaused);
		icon.classList.toggle('fa-play', isPaused);
		pauseBtn.setAttribute('aria-label', isPaused ? 'Play slider' : 'Pause slider');
	});

	// Navigácia - ďalej
	document.querySelectorAll('.next').forEach(btn => {
		btn.addEventListener('click', () => {
			stopSlider();
			nextSlide();
			if (!isPaused) {
				startSlider(); // Reštartuj slider, ak nie je pozastavený
			}
		});
	});

	// Navigácia - späť
	document.querySelectorAll('.prev').forEach(btn => {
		btn.addEventListener('click', () => {
			stopSlider();
			prevSlide();
			if (!isPaused) {
				startSlider(); // Reštartuj slider, ak nie je pozastavený
			}
		});
	});

	// Spusti slider, ak existujú slidy
	if (slides.length > 0) {
		showSlide(currentSlide);
		startSlider();
	}
});
