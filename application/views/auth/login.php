<!--<!DOCTYPE html>-->
<!--<html lang="de">-->
<!--<head>-->
<!--	<meta charset="UTF-8">-->
<!--	<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--	<title>--><?php //= $title ?? 'Anmeldung' ?><!--</title>-->
<!--	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">-->
<!--	<link rel="shortcut icon" href="--><?php //= BASE_URL ?><!--img/icon/favicon.ico" type="image/x-icon">-->
<!--	<link rel="stylesheet" href="--><?php //= BASE_URL ?><!--assets/css/login/my-custom.css">-->
<!---->
<!--</head>-->
<!--<body>-->
<!---->
<!--<div class="login-container">-->
<!--	<div class="logo">-->
<!--		<a href="--><?php //= BASE_URL ?><!--">-->
<!--			<img src="--><?php //= BASE_URL . LOGO ?><!--" alt="Logo">-->
<!--		</a>-->
<!--	</div>-->
<!---->
<!--	<h3>Anmeldung im Konto</h3>-->
<!---->
<!--	<form method="post" action="--><?php //= BASE_URL ?><!--login">-->
<!--		<div class="form-group">-->
<!--			--><?php //= form_input($identity, '', 'class="form-control" placeholder="E-Mail-Adresse"') ?>
<!--		</div>-->
<!--		<div class="form-group">-->
<!--			--><?php //= form_input($password, '', 'class="form-control" placeholder="Passwort"') ?>
<!--		</div>-->
<!--		<div class="form-group">-->
<!--			<button type="submit" class="btn-login">Einloggen</button>-->
<!--		</div>-->
<!--	</form>-->
<!--</div>-->
<!---->
<!--</body>-->
<!--</html>-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Analog Clock with Language Selector</title>
	<style>
		*, ::before, ::after {
			box-sizing: border-box;
		}
		:root {
			--bg-clr: rgb(3, 3, 3);
			--clock-size: 800px;
			--clock-clr: rgb(12, 74, 110);
			--clock-numbers-clr: white;
			--clock-mask-clr: black;
			--clock-mask-opacity: 0.85;
			--clock-mask-inset: 2px;
			--clock-center-border-clr: rgba(255, 255, 255, 0.25);
			--clock-dialog-bg-clr: rgba(8, 47, 73, 0.5);
			--separator-offset-x1: calc(var(--clock-size) * 0.35375);
			--separator-offset-x2: calc(var(--clock-size) * 0.3125);
			--separator-offset-y: -10px;
		}
		body {
			margin: 0;
			min-height: 100svh;
			display: grid;
			place-content: center;
			font-family: system-ui, sans-serif;
			background-color: var(--bg-clr);
			background-image: radial-gradient(rgb(8, 47, 73), rgb(8, 47, 60));
		}
		.clock {
			position: fixed;
			place-content: center;
			inset: 0;
			margin: auto;
			width: var(--clock-size);
			height: var(--clock-size);
			aspect-ratio: 1;
			background: var(--clock-clr);
			border-radius: 50%;
		}
		@media (width < 800px) {
			.clock {
				left: 0;
				right: auto;
				translate: calc((50% - 2rem) * -1) 0;
			}
		}
		.clock::before {
			content: "";
			position: absolute;
			inset: var(--clock-mask-inset);
			margin: auto;
			border-radius: 50%;
			z-index: 20;
			clip-path: polygon(0 0, 100% 0, 100% 48%, 50% 48%, 50% 52%, 100% 52%, 100% 100%, 0 100%);
			background-color: var(--clock-mask-clr);
			opacity: var(--clock-mask-opacity);
		}
		.clock > div {
			position: absolute;
			inset: 0;
			margin: auto;
			width: var(--clock-d);
			height: var(--clock-d);
			font-size: var(--f-size, 0.9rem);
			aspect-ratio: 1;
			isolation: isolate;
			border-radius: 50%;
		}
		.clock > div:nth-of-type(1) { --clock-d: calc(var(--clock-size) - 20px); }
		.clock > div:nth-of-type(2) { --clock-d: calc(var(--clock-size) - 130px); }
		.clock > div:nth-child(3) { --clock-d: calc(var(--clock-size) - 195px); }
		.clock > div:nth-child(4) { --clock-d: calc(var(--clock-size) - 260px); }
		.clock > div:nth-child(5) { --clock-d: calc(var(--clock-size) - 350px); }
		.clock > div:nth-child(6) { --clock-d: calc(var(--clock-size) - 470px); }
		.clock > div:nth-child(7) { --clock-d: calc(var(--clock-size) - 600px); }
		.clock-face {
			position: relative;
			width: 100%;
			height: 100%;
			aspect-ratio: 1;
			border-radius: 50%;
			transition: transform 300ms linear;
		}
		.clock-face > * {
			position: absolute;
			transform-origin: center;
			white-space: nowrap;
			color: var(--clock-numbers-clr);
			opacity: 0.75;
		}
		.clock-face > *.active {
			opacity: 1;
		}
		.current-lang-display {
			position: absolute;
			inset: 0;
			margin: auto;
			z-index: 100;
			display: grid;
			place-content: center;
			background-color: var(--clock-clr);
			border: 1px solid var(--clock-center-border-clr);
			color: white;
			border-radius: 50%;
			width: 40px;
			height: 40px;
			aspect-ratio: 1/1;
			cursor: pointer;
			transition: background-color 300ms ease-in-out;
			font-size: 1.5rem;
			outline: none;
		}
		.current-lang-display:focus-visible,
		.current-lang-display:hover {
			background-color: white;
			color: var(--clock-clr);
		}
		.current-lang-display::before,
		.current-lang-display::after {
			content: ":";
			color: var(--clock-numbers-clr);
			position: absolute;
			z-index: 199;
			top: 50%;
			right: 0;
			font-size: 0.9rem;
			transform: translate(var(--separator-offset-x1), var(--separator-offset-y));
		}
		.current-lang-display::after {
			transform: translate(var(--separator-offset-x2), var(--separator-offset-y));
		}
		dialog {
			width: min(calc(100% - 2rem), 380px);
			padding: 1rem;
			border: none;
			border-radius: 999px;
			background: var(--clock-dialog-bg-clr);
			text-align: center;
			aspect-ratio: 1;
			overflow: visible;
			transition: opacity 500ms ease-in, scale 500ms cubic-bezier(0.28, -0.55, 0.27, 1.55);
		}
		dialog[open] {
			opacity: 1;
			scale: 1;
		}
		dialog::backdrop {
			background-color: rgba(0, 0, 0, 0.5);
			backdrop-filter: blur(3px);
			opacity: 0;
			transition: opacity 1000ms ease-in;
		}
		dialog[open]::backdrop {
			opacity: 1;
		}
		dialog .btn-dialog-close {
			position: absolute;
			top: 0rem;
			right: 25%;
			aspect-ratio: 1;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: var(--clock-dialog-bg-clr);
			font-size: 1.2rem;
			color: white;
			border: none;
			outline: none;
			cursor: pointer;
			transition: rotate 300ms ease-in-out;
		}
		dialog .btn-dialog-close:focus-visible,
		dialog .btn-dialog-close:hover {
			rotate: 90deg;
		}
		.language-options {
			position: absolute;
			inset: 0;
			margin: auto;
			border-radius: 50%;
			aspect-ratio: 1/1;
			overflow: hidden;
		}
		.language-options > label {
			position: absolute;
			transform: translate(-50%, -50%);
			cursor: pointer;
			font-size: 0.9rem;
			aspect-ratio: 1/1;
			border-radius: 50%;
			width: 36px;
			height: 36px;
			transition: scale 300ms ease-in-out;
			display: grid;
			place-content: center;
			transform-origin: center;
		}
		.language-options > label.active {
			color: white;
			background: var(--clock-clr);
		}
		.language-options > label:focus-visible,
		.language-options > label:hover {
			scale: 1.1;
			z-index: 2;
		}
		.language-title {
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			pointer-events: none;
			color: white;
			font-size: 1.2rem;
			opacity: 0;
			transition: opacity 300ms ease-in-out;
		}
		.language-title.active {
			opacity: 1;
		}
		.flag-icon {
			font-size: 1.5rem;
			display: grid;
			place-content: center;
		}
		.language-options input[type="radio"] {
			position: absolute;
			width: 1px;
			height: 1px;
			margin: -1px;
			padding: 0;
			border: 0;
			clip: rect(0, 0, 0, 0);
			overflow: hidden;
		}
	</style>
</head>
<body>
<div class="clock" data-date="2024-12-25">
	<div><div data-clock="years" data-numbers="101" class="clock-face"></div></div>
	<div><div data-clock="seconds" data-numbers="60" class="clock-face"></div></div>
	<div><div data-clock="minutes" data-numbers="60" class="clock-face"></div></div>
	<div><div data-clock="hours" data-numbers="24" class="clock-face"></div></div>
	<div><div data-clock="days" data-numbers="31" class="clock-face"></div></div>
	<div><div data-clock="months" data-numbers="12" class="clock-face"></div></div>
	<div><div data-clock="day-names" data-numbers="7" class="clock-face"></div></div>
	<button type="button" id="current-lang" class="current-lang-display" aria-label="Select language">en</button>
</div>
<dialog id="language-dialog" aria-labelledby="language-dialog-title">
	<button type="button" id="btn-dialog-close" class="btn-dialog-close" aria-label="Close language selector">✕</button>
	<div id="language-options" class="language-options"></div>
</dialog>
<script>
	const languageFlags = [
		{ code: 'ar-SA', name: 'Arabic (Saudi Arabia)', flag: '🇸🇦' },
		{ code: 'cs-CZ', name: 'Czech (Czech Republic)', flag: '🇨🇿' },
		{ code: 'da-DK', name: 'Danish (Denmark)', flag: '🇩🇰' },
		{ code: 'de-DE', name: 'German (Germany)', flag: '🇩🇪' },
		{ code: 'el-GR', name: 'Greek (Greece)', flag: '🇬🇷' },
		{ code: 'en-US', name: 'English (US)', flag: '🇺🇸' },
		{ code: 'en-GB', name: 'English (UK)', flag: '🇬🇧' },
		{ code: 'es-ES', name: 'Spanish (Spain)', flag: '🇪🇸' },
		{ code: 'es-MX', name: 'Spanish (Mexico)', flag: '🇲🇽' },
		{ code: 'fi-FI', name: 'Finnish (Finland)', flag: '🇫🇮' },
		{ code: 'fr-CA', name: 'French (Canada)', flag: '🇨🇦' },
		{ code: 'fr-FR', name: 'French (France)', flag: '🇫🇷' },
		{ code: 'he-IL', name: 'Hebrew (Israel)', flag: '🇮🇱' },
		{ code: 'hi-IN', name: 'Hindi (India)', flag: '🇮🇳' },
		{ code: 'hu-HU', name: 'Hungarian (Hungary)', flag: '🇭🇺' },
		{ code: 'it-IT', name: 'Italian (Italy)', flag: '🇮🇹' },
		{ code: 'ja-JP', name: 'Japanese (Japan)', flag: '🇯🇵' },
		{ code: 'ko-KR', name: 'Korean (South Korea)', flag: '🇰🇷' },
		{ code: 'nl-NL', name: 'Dutch (Netherlands)', flag: '🇳🇱' },
		{ code: 'no-NO', name: 'Norwegian (Norway)', flag: '🇳🇴' },
		{ code: 'pl-PL', name: 'Polish (Poland)', flag: '🇵🇱' },
		{ code: 'pt-BR', name: 'Portuguese (Brazil)', flag: '🇧🇷' },
		{ code: 'pt-PT', name: 'Portuguese (Portugal)', flag: '🇵🇹' },
		{ code: 'ro-RO', name: 'Romanian (Romania)', flag: '🇷🇴' },
		{ code: 'ru-RU', name: 'Russian (Russia)', flag: '🇷🇺' },
		{ code: 'sv-SE', name: 'Swedish (Sweden)', flag: '🇸🇪' },
		{ code: 'th-TH', name: 'Thai (Thailand)', flag: '🇹🇭' },
		{ code: 'tr-TR', name: 'Turkish (Turkey)', flag: '🇹🇷' },
		{ code: 'vi-VN', name: 'Vietnamese (Vietnam)', flag: '🇻🇳' },
		{ code: 'zh-CN', name: 'Chinese (Simplified, China)', flag: '🇨🇳' },
	];
	const RADIUS = 140;
	const defaultRegions = languageFlags.reduce((map, lang) => {
		const baseLang = lang.code.split('-')[0];
		if (!map[baseLang]) map[baseLang] = lang.code;
		return map;
	}, {});
	function getLocale() {
		let language = (navigator.languages && navigator.languages[0]) || navigator.language || 'en-US';
		if (language.length === 2) {
			language = defaultRegions[language] || `${language}-${language.toUpperCase()}`;
		}
		return language;
	}
	let locale = getLocale();
	const currentLangDisplay = document.getElementById('current-lang');
	const languageDialog = document.getElementById('language-dialog');
	const languageOptionsContainer = document.getElementById('language-options');
	const closeButton = document.getElementById('btn-dialog-close');
	const clockElement = document.querySelector('.clock');
	const targetDate = clockElement.dataset.date ? new Date(clockElement.dataset.date) : null;
	const clockFacesData = new Map();
	function drawClockFaces() {
		const clockFaces = document.querySelectorAll('.clock-face');
		const referenceDate = targetDate || new Date();
		const currentDate = new Date();
		const currentDay = referenceDate.getDate();
		const currentMonth = referenceDate.getMonth();
		const currentYear = referenceDate.getFullYear();
		const currentWeekday = referenceDate.getDay();
		const currentHours = referenceDate.getHours();
		const currentMinutes = referenceDate.getMinutes();
		const currentSeconds = referenceDate.getSeconds();
		const totalDaysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
		const weekdayNames = Array.from({ length: 7 }, (_, i) =>
			new Intl.DateTimeFormat(locale, { weekday: 'long' }).format(new Date(2021, 0, i + 3))
		);
		const monthNames = Array.from({ length: 12 }, (_, i) =>
			new Intl.DateTimeFormat(locale, { month: 'long' }).format(new Date(2021, i))
		);
		clockFaces.forEach(clockFace => {
			const clockType = clockFace.getAttribute('data-clock');
			const numbers = parseInt(clockFace.getAttribute('data-numbers'), 10);
			if (!clockFacesData.has(clockType)) {
				const RADIUS = (clockFace.offsetWidth / 2) - 20;
				const center = clockFace.offsetWidth / 2;
				let valueSet;
				let currentValue;
				switch (clockType) {
					case 'seconds':
						valueSet = Array.from({ length: 60 }, (_, i) => String(i).padStart(2, '0'));
						currentValue = String(currentSeconds).padStart(2, '0');
						break;
					case 'minutes':
						valueSet = Array.from({ length: 60 }, (_, i) => String(i).padStart(2, '0'));
						currentValue = String(currentMinutes).padStart(2, '0');
						break;
					case 'hours':
						valueSet = Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0'));
						currentValue = String(currentHours).padStart(2, '0');
						break;
					case 'days':
						valueSet = Array.from({ length: totalDaysInMonth }, (_, i) => i + 1);
						currentValue = currentDay;
						break;
					case 'months':
						valueSet = monthNames;
						currentValue = currentMonth;
						break;
					case 'years':
						valueSet = Array.from({ length: 101 }, (_, i) => 2000 + i);
						currentValue = currentYear;
						break;
					case 'day-names':
						valueSet = weekdayNames;
						currentValue = currentWeekday;
						break;
					default:
						return;
				}
				clockFace.innerHTML = '';
				const elements = valueSet.map((value, i) => {
					const angle = (i * (360 / numbers));
					const x = center + RADIUS * Math.cos((angle * Math.PI) / 180);
					const y = center + RADIUS * Math.sin((angle * Math.PI) / 180);
					const element = document.createElement('span');
					element.classList.add('number');
					element.textContent = value;
					element.style.left = `${x}px`;
					element.style.top = `${y}px`;
					element.style.transform = `translate(-50%, -50%) rotate(${angle}deg)`;
					clockFace.appendChild(element);
					return element;
				});
				clockFacesData.set(clockType, { valueSet, elements });
			}
			const { valueSet, elements } = clockFacesData.get(clockType);
			let currentValue;
			switch (clockType) {
				case 'seconds': currentValue = String(currentSeconds).padStart(2, '0'); break;
				case 'minutes': currentValue = String(currentMinutes).padStart(2, '0'); break;
				case 'hours': currentValue = String(currentHours).padStart(2, '0'); break;
				case 'days': currentValue = currentDay; break;
				case 'months': currentValue = currentMonth; break;
				case 'years': currentValue = currentYear; break;
				case 'day-names': currentValue = currentWeekday; break;
			}
			const currentIndex = valueSet.indexOf(
				typeof valueSet[0] === 'string' ? String(currentValue) : currentValue
			);
			const rotationAngle = -((currentIndex / numbers) * 360);
			clockFace.style.transform = `rotate(${rotationAngle}deg)`;
			elements.forEach((element, index) => {
				element.classList.toggle('active', index === currentIndex);
			});
		});
	}
	function rotateClockFaces() {
		const clockFaces = document.querySelectorAll('.clock-face');
		const lastAngles = {};
		function updateRotations() {
			const now = targetDate || new Date();
			const currentSecond = now.getSeconds();
			const currentMinute = now.getMinutes();
			const currentHour = now.getHours();
			const currentDay = now.getDate();
			const currentMonth = now.getMonth();
			const currentYear = now.getFullYear();
			const currentWeekday = now.getDay();
			clockFaces.forEach(clockFace => {
				const clockType = clockFace.getAttribute('data-clock');
				const totalNumbers = parseInt(clockFace.getAttribute('data-numbers'), 10);
				let currentValue;
				switch (clockType) {
					case 'seconds': currentValue = currentSecond; break;
					case 'minutes': currentValue = currentMinute; break;
					case 'hours': currentValue = currentHour; break;
					case 'days': currentValue = currentDay - 1; break;
					case 'months': currentValue = currentMonth; break;
					case 'years': currentValue = currentYear - 2000; break;
					case 'day-names': currentValue = currentWeekday; break;
					default: return;
				}
				const targetAngle = (360 / totalNumbers) * currentValue;
				const clockId = clockFace.id || clockType;
				const lastAngle = lastAngles[clockId] || 0;
				const delta = targetAngle - lastAngle;
				const shortestDelta = ((delta + 540) % 360) - 180;
				const newAngle = lastAngle + shortestDelta;
				clockFace.style.transform = `rotate(${newAngle * -1}deg)`;
				lastAngles[clockId] = newAngle;
				const { elements } = clockFacesData.get(clockType);
				elements.forEach((number, index) => {
					number.classList.toggle('active', index === currentValue);
				});
			});
			requestAnimationFrame(updateRotations);
		}
		updateRotations();
	}
	function createLanguageOptions() {
		const centerX = languageOptionsContainer.offsetWidth / 2;
		const centerY = languageOptionsContainer.offsetHeight / 2;
		languageFlags.forEach((lang, index, arr) => {
			const angle = (index / arr.length) * 2 * Math.PI;
			const x = centerX + RADIUS * Math.cos(angle);
			const y = centerY + RADIUS * Math.sin(angle);
			const radioWrapper = document.createElement('label');
			radioWrapper.title = lang.name;
			radioWrapper.style.left = `${x}px`;
			radioWrapper.style.top = `${y}px`;
			radioWrapper.setAttribute('aria-label', `Select ${lang.name}`);
			const radioInput = document.createElement('input');
			radioInput.type = 'radio';
			radioInput.name = 'language';
			radioInput.value = lang.code;
			if (lang.code === locale) {
				radioInput.checked = true;
				radioWrapper.classList.add('active');
			}
			const flag = document.createElement('span');
			flag.classList.add('flag-icon');
			flag.innerText = lang.flag;
			radioWrapper.appendChild(radioInput);
			radioWrapper.appendChild(flag);
			languageOptionsContainer.appendChild(radioWrapper);
			radioWrapper.addEventListener('mouseover', () => showTitle(lang.name));
			radioWrapper.addEventListener('mouseleave', hideTitle);
			radioInput.addEventListener('change', () => {
				locale = radioInput.value;
				setCurrentLangDisplay(lang);
				drawClockFaces();
				document.querySelector('label.active')?.classList.remove('active');
				radioWrapper.classList.add('active');
				closeDialog();
			});
		});
	}
	let titleDisplay = null;
	function showTitle(languageName) {
		if (!titleDisplay) {
			titleDisplay = document.createElement('div');
			titleDisplay.classList.add('language-title');
			languageOptionsContainer.appendChild(titleDisplay);
		}
		titleDisplay.textContent = languageName;
		titleDisplay.classList.add('active');
	}
	function hideTitle() {
		if (titleDisplay) {
			titleDisplay.classList.remove('active');
		}
	}
	function setCurrentLangDisplay(lang) {
		currentLangDisplay.textContent = lang.flag;
		currentLangDisplay.title = lang.name;
		currentLangDisplay.setAttribute('aria-label', `Selected language: ${lang.name}`);
	}
	function openDialog() {
		languageDialog.showModal();
		createLanguageOptions();
		addDialogCloseListener();
	}
	function closeDialog() {
		languageDialog.close();
		removeLanguageOptions();
		removeDialogCloseListener();
	}
	function removeLanguageOptions() {
		languageOptionsContainer.innerHTML = '';
		titleDisplay = null;
	}
	function addDialogCloseListener() {
		languageDialog.addEventListener('click', closeDialogOnClickOutside);
	}
	function removeDialogCloseListener() {
		languageDialog.removeEventListener('click', closeDialogOnClickOutside);
	}
	function closeDialogOnClickOutside(e) {
		if (e.target === languageDialog) closeDialog();
	}
	closeButton.addEventListener('click', closeDialog);
	currentLangDisplay.addEventListener('click', openDialog);
	drawClockFaces();
	rotateClockFaces();
	setCurrentLangDisplay(languageFlags.find(lang => lang.code === locale));
</script>
</body>
</html>
