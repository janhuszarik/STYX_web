document.addEventListener('DOMContentLoaded', function() {
	document.querySelector('.header-nav-features-toggle').addEventListener('click', function() {
		setTimeout(() => {
			document.querySelector('#headerSearch').focus();
		}, 200); // Oneskorenie, aby sa dropdown stihol otvoriť
	});
});
