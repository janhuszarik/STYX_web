document.addEventListener('DOMContentLoaded', function () {

	let currentSlide = 0;
	const slides = document.querySelectorAll('.slider-wrapper');
	const pauseBtn = document.getElementById('pauseBtn');
	const ring = document.querySelector('.progress-ring-circle');

	const radius = 22;
	const circumference = 2 * Math.PI * radius;

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
		resetProgress();
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
		setProgress(0);
		clearInterval(progressInterval);
		let progress = 0;
		const step = 100 / (slideIntervalTime * 1000 / 50);

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
		resetProgress();
	}

	function stopSlider() {
		clearInterval(interval);
		clearInterval(progressInterval);
	}

	// Funkcia čakajúca na načítanie všetkých obrázkov v kontajneri
	function allImagesLoaded(containerSelector, callback) {
		const container = document.querySelector(containerSelector);
		if (!container) return;

		const images = container.querySelectorAll('img');
		let loadedCount = 0;

		if (images.length === 0) {
			callback(); // žiadne obrázky = rovno pokračuj
			return;
		}

		images.forEach((img) => {
			if (img.complete) {
				loadedCount++;
			} else {
				img.addEventListener('load', () => {
					loadedCount++;
					if (loadedCount === images.length) {
						callback();
					}
				});
				img.addEventListener('error', () => {
					loadedCount++;
					if (loadedCount === images.length) {
						callback();
					}
				});
			}
		});

		if (loadedCount === images.length) {
			callback();
		}
	}

	// Po načítaní všetkých obrázkov inicializuj slider
	allImagesLoaded('.popular-products-carousel', function () {

		ring.style.strokeDasharray = `${circumference}`;
		ring.style.strokeDashoffset = `${circumference}`;

		if (slides.length > 0) {
			showSlide(currentSlide);
			startSlider();
		}

		// Pauza/Play tlačidlo
		pauseBtn.addEventListener('click', () => {
			isPaused = !isPaused;
			const icon = pauseBtn.querySelector('i');
			icon.classList.toggle('fa-pause', !isPaused);
			icon.classList.toggle('fa-play', isPaused);
			pauseBtn.setAttribute('aria-label', isPaused ? 'Play slider' : 'Pause slider');
		});

		document.querySelectorAll('.next').forEach(btn => {
			btn.addEventListener('click', () => {
				stopSlider();
				nextSlide();
				if (!isPaused) startSlider();
			});
		});

		document.querySelectorAll('.prev').forEach(btn => {
			btn.addEventListener('click', () => {
				stopSlider();
				prevSlide();
				if (!isPaused) startSlider();
			});
		});

		console.log('Všetky obrázky načítané, slider inicializovaný.');

	});
});
