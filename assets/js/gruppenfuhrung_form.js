document.addEventListener('DOMContentLoaded', function () {
	// Inicializácia dynamického výstupu pre počet osôb
	const input = document.getElementById('num_persons_input');
	const output = document.getElementById('person_info_output');
	if (!input || !output) {
		console.warn('Input or output element not found, functionality may be limited:', { input, output });
	}

	const options = [
		{ range: [20, 40], text: '20–40 Pers.', time: '2 h' },
		{ range: [41, 60], text: '41–60 Pers.', time: '2,5 h' },
		{ range: [61, 80], text: '61–80 Pers.', time: '3 h' },
		{ range: [81, 100], text: '81–100 Pers.', time: '3,5 h' },
		{ range: [101, 150], text: '101–150 Pers.', time: '4 h' }
	];

	if (input) {
		input.addEventListener('input', function () {
			try {
				const val = parseInt(input.value, 10) || 0;
				if (val < 1) {
					if (output) {
						output.classList.add('d-none');
						output.innerHTML = '';
					}
					return;
				}
				if (output) {
					let match = options.find(opt => val >= opt.range[0] && val <= opt.range[1]);
					output.classList.remove('d-none');
					output.innerHTML = match
						? `Für <strong>${val} Personen</strong> haben wir das Paket im Bereich von <strong>${match.text}</strong> mit einer ungefähren Dauer von <strong>${match.time}</strong> zur Verfügung.`
						: `Für <strong>${val} Personen</strong> haben wir derzeit kein passendes Paket verfügbar. Bitte kontaktieren Sie uns direkt.`;
				}
			} catch (error) {
				console.error('Error in num_persons_input handler:', error);
				if (output) {
					output.classList.add('d-none');
					output.innerHTML = '';
				}
			}
		});
	}

	// Kontrola odoslania formulára
	const formSelector = 'form[action*="send_gruppenfuhrung"]';
	const form = document.querySelector(formSelector);
	if (form) {
		form.addEventListener('submit', function (event) {
			console.log('Form submit triggered, form data:', new FormData(form));
		});
	} else {
		console.warn('Form element not found with selector:', formSelector);
	}

	// Kontrola načítania reCAPTCHA
	window.addEventListener('load', function () {
		if (typeof grecaptcha !== 'undefined') {
			console.log('reCAPTCHA loaded successfully');
		} else {
			console.warn('reCAPTCHA failed to load, check network or sitekey');
		}
	});
});

// Funkcia pre prepínanie zaškrtávacích políčok
function toggleCheckbox(el) {
	try {
		const checkbox = el.querySelector('input[type="checkbox"]');
		if (checkbox) {
			checkbox.checked = !checkbox.checked;
			el.classList.toggle('active', checkbox.checked);
			console.log('Toggled checkbox:', { checked: checkbox.checked, element: el });
		} else {
			console.error('Checkbox not found in toggleCheckbox:', el);
		}
	} catch (error) {
		console.error('Error in toggleCheckbox:', error);
	}
}

// Funkcia pre výber kariet s rádiovými tlačidlami
function selectCard(element, group) {
	try {
		console.log('selectCard called for group:', group, 'element:', element);
		document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
			const card = input.closest('.select-card');
			if (card) {
				card.classList.remove('active');
				console.log('Removed active from card:', card);
			}
		});
		if (element) {
			element.classList.add('active');
			console.log('Added active to element:', element);
			const radio = element.querySelector('input[type="radio"]');
			if (radio) {
				radio.checked = true;
				console.log('Checked radio button:', radio);
			} else {
				console.error('Radio button not found in selectCard:', element);
				const fallbackRadio = document.querySelector(`input[name="${group}"]`);
				if (fallbackRadio) {
					fallbackRadio.checked = true;
					console.log('Fallback radio button checked:', fallbackRadio);
				}
			}
		}
	} catch (error) {
		console.error('Error in selectCard:', error);
	}
}
