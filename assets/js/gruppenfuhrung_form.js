
	function selectCard(element, group) {
	document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
		const card = input.closest('.select-card');
		if (card) card.classList.remove('active');
	});
	element.classList.add('active');
	element.querySelector('input[type="radio"]').checked = true;
}

	document.addEventListener('DOMContentLoaded', function () {
	const input = document.getElementById('num_persons_input');
	const output = document.getElementById('person_info_output');
	const options = [
{ range: [20, 40], text: '20–40 Pers.', time: '2 h' },
{ range: [41, 60], text: '41–60 Pers.', time: '2,5 h' },
{ range: [61, 80], text: '61–80 Pers.', time: '3 h' },
{ range: [81, 100], text: '81–100 Pers.', time: '3,5 h' },
{ range: [101, 150], text: '101–150 Pers.', time: '4 h' }
	];
	input.addEventListener('input', function () {
	const val = parseInt(input.value, 10);
	if (!val || val < 1) {
	output.classList.add('d-none');
	output.innerHTML = '';
	return;
}
	let match = options.find(opt => val >= opt.range[0] && val <= opt.range[1]);
	if (match) {
	output.classList.remove('d-none');
	output.innerHTML = `Für <strong>${val} Personen</strong> haben wir das Paket im Bereich von <strong>${match.text}</strong> mit einer ungefähren Dauer von <strong>${match.time}</strong> zur Verfügung.`;
} else {
	output.classList.remove('d-none');
	output.innerHTML = `Für <strong>${val} Personen</strong> haben wir derzeit kein passendes Paket verfügbar. Bitte kontaktieren Sie uns direkt.`;
}
});
});

	function toggleCheckbox(el) {
	const checkbox = el.querySelector('input[type="checkbox"]');
	checkbox.checked = !checkbox.checked;
	el.classList.toggle('active', checkbox.checked);
}
	function selectCard(element, group) {
		try {
			document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
				const card = input.closest('.select-card');
				if (card) card.classList.remove('active');
			});
			element.classList.add('active');
			const radio = element.querySelector('input[type="radio"]');
			if (radio) {
				radio.checked = true;
			} else {
				console.error('Radio button not found in selectCard:', element);
				// Ak rádio tlačidlo nie je nájdené, vyber predvolenú hodnotu
				document.querySelector(`input[name="${group}"]`)?.checked = true;
			}
		} catch (error) {
			console.error('Error in selectCard:', error);
		}
	}
