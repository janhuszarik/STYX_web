
	document.addEventListener('DOMContentLoaded', function () {
	const imgs = document.querySelectorAll('img');
	const lightbox = document.getElementById('lightbox-modal');
	const lightboxImg = document.getElementById('lightbox-img');

	imgs.forEach(img => {
	img.style.cursor = 'zoom-in';
	img.addEventListener('click', function () {
	lightboxImg.src = this.src;
	lightbox.style.display = 'flex';
});
});

	// ESC zatvorenie
	document.addEventListener('keydown', function(e) {
	if (e.key === "Escape") closeLightbox();
});

	// klik mimo obrázka zatvorí lightbox
	lightbox.addEventListener('click', function (e) {
	if (e.target === lightbox) closeLightbox();
});
});

	function closeLightbox() {
	document.getElementById('lightbox-modal').style.display = 'none';
}
