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
			const zahlung = form.querySelector('input[name="zahlung"]:checked');
			if (!zahlung) {
				alert('Bitte wählen Sie eine Zahlungsart.');
				event.preventDefault();
			}
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

	// Podmienka pre Tour auswahl
	const tourRadios = document.querySelectorAll('input[name="tour_type"]');
	if (tourRadios.length > 0) {
		tourRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				const selectedValue = this.value;
				tourRadios.forEach(r => {
					const card = r.closest('.select-card');
					if (card) {
						if (selectedValue === 'silber' && r.value !== 'silber') {
							r.disabled = true;
							card.classList.remove('active');
							console.log(`Disabled ${r.value} due to Silber selection`);
						} else if (selectedValue !== 'silber' && r.value === 'silber') {
							r.disabled = false;
							console.log(`Enabled Silber as another option is selected`);
						} else if (selectedValue !== r.value) {
							r.disabled = false;
							card.classList.remove('active');
						}
					}
				});
				selectCard(this.closest('.select-card'), 'tour_type');
			});
		});
	}

	// Podmienka pre Rechnungsadresse
	const addressRadios = document.querySelectorAll('input[name="rechnung_adresse"]');
	const otherAddressField = document.querySelector('textarea[name="andere_adresse"]');
	if (addressRadios.length > 0 && otherAddressField) {
		addressRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				if (this.value === 'gleich') {
					otherAddressField.disabled = true;
					otherAddressField.value = ''; // Vymaže obsah pri deaktivácii
					console.log('Disabled andere_adresse field');
				} else if (this.value === 'andere') {
					otherAddressField.disabled = false;
					console.log('Enabled andere_adresse field');
				}
			});
		});
		// Nastavenie počiatočného stavu (predvolená hodnota je 'gleich')
		const defaultRadio = document.querySelector('input[name="rechnung_adresse"][value="gleich"]');
		if (defaultRadio) {
			defaultRadio.checked = true;
			otherAddressField.disabled = true;
		}
	}
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

function selectCard(element, group) {
	try {
		console.log('selectCard called for group:', group, 'element:', element);

		// Zruš aktívne triedy z ostatných kariet v tejto skupine
		document.querySelectorAll(`input[name="${group}"]`).forEach(input => {
			const card = input.closest('.select-card');
			if (card) {
				card.classList.remove('active');
			}
			input.checked = false;
		});

		if (element) {
			element.classList.add('active');

			const radio = element.querySelector(`input[type="radio"][name="${group}"]`);
			if (radio) {
				// Priamo nastavíme checked, bez click(), kvôli problémom s required
				radio.disabled = false;
				radio.checked = true;

				radio.dispatchEvent(new Event('change', { bubbles: true }));

				console.log('Checked radio button:', radio);

				if (group === 'tour_type') {
					handleTourSelection(element);
				}
			}
		}
	} catch (error) {
		console.error('Error in selectCard:', error);
	}
}


// Funkcia na deaktiváciu všetkých extra možností mimo vybratej karty
function handleTourSelection(selectedCard) {
	const allCards = document.querySelectorAll('.select-card');
	allCards.forEach(card => {
		const inputs = card.querySelectorAll('input[type="radio"], input[type="checkbox"]');
		const isCurrent = card === selectedCard;

		inputs.forEach(input => {
			if (!isCurrent) {
				input.disabled = true;
				input.checked = false;
			} else {
				input.disabled = false;
			}
		});
	});
}

