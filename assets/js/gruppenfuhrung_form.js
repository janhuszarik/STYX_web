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

	if (input) {
		input.addEventListener('input', function () {
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
		});
	}

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
	}

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
						} else if (selectedValue !== 'silber' && r.value === 'silber') {
							r.disabled = false;
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

	const addressRadios = document.querySelectorAll('input[name="rechnung_adresse"]');
	const otherAddressField = document.querySelector('textarea[name="andere_adresse"]');
	if (addressRadios.length > 0 && otherAddressField) {
		addressRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				if (this.value === 'gleich') {
					otherAddressField.disabled = true;
					otherAddressField.value = '';
				} else if (this.value === 'andere') {
					otherAddressField.disabled = false;
				}
			});
		});
		const defaultRadio = document.querySelector('input[name="rechnung_adresse"][value="gleich"]');
		if (defaultRadio) {
			defaultRadio.checked = true;
			otherAddressField.disabled = true;
		}
	}
});

function toggleCheckbox(el) {
	const checkbox = el.querySelector('input[type="checkbox"]');
	if (checkbox) {
		checkbox.checked = !checkbox.checked;
		el.classList.toggle('active', checkbox.checked);
	}
}

function selectCard(element, group) {
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
			radio.disabled = false;
			radio.checked = true;

			radio.dispatchEvent(new Event('change', { bubbles: true }));

			if (group === 'tour_type') {
				handleTourSelection(element);
			}
		}
	}
}

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
