
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
}

	function nextSlide() {
	currentSlide = (currentSlide + 1) % slides.length;
	showSlide(currentSlide);
}

	function startSlider() {
	stopSlider();
	let progress = 0;
	const step = 100 / (slideIntervalTime * 1000 / 50); // každých 50ms

	interval = setInterval(() => {
	if (!isPaused) {
	nextSlide();
	progress = 0;
}
}, slideIntervalTime * 1000);

	progressInterval = setInterval(() => {
	if (!isPaused) {
	progress += step;
	if (progress > 100) progress = 100;
	setProgress(progress / 100);
}
}, 50);
}

	function stopSlider() {
	clearInterval(interval);
	clearInterval(progressInterval);
}

	pauseBtn.addEventListener('click', () => {
	isPaused = !isPaused;
	pauseBtn.textContent = isPaused ? '▶️' : '⏸️';
});

	document.querySelector('.next')?.addEventListener('click', () => {
	nextSlide();
});

	document.querySelector('.prev')?.addEventListener('click', () => {
	currentSlide = (currentSlide - 1 + slides.length) % slides.length;
	showSlide(currentSlide);
});

	startSlider();
});
