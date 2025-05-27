<!-- ftp_modal.php -->
<div id="ftp-browser-container">
	<div class="mb-2 d-flex align-items-center">
		<button id="ftp-back-btn" class="btn btn-sm btn-secondary me-2" style="display: none;">
			<i class="bi bi-arrow-left"></i> Zurück
		</button>
		<strong>Aktueller Ordner:</strong>
		<span id="current-folder" class="ms-2">/</span>
	</div>
	<div id="ftp-folder-contents">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th style="text-align: center;">Typ</th>
				<th>Name</th>
				<th>Pfad</th>
				<th>Größe</th>
				<th>Aktionen</th>
			</tr>
			</thead>
			<tbody id="ftp-table-body">
			<tr>
				<td colspan="5">Lade...</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>

<script>
	const BASE_URL = "<?= base_url() ?>";

	document.addEventListener("DOMContentLoaded", () => {
		const btn = document.getElementById("chooseFtpImage"),
			modalEl = document.getElementById("ftpModal"),
			modal = new bootstrap.Modal(modalEl),
			browserContainer = document.getElementById("ftp-table-body"),
			currentFolderLabel = document.getElementById("current-folder"),
			backBtn = document.getElementById("ftp-back-btn"),
			preview = document.getElementById("ftpImagePreview"),
			hiddenInput = document.getElementById("ftpImageInput");

		let currentPath = "";

		// Funktion zum Laden des Ordnerinhalts von FTP
		function loadFolder(path) {
			currentPath = path;
			currentFolderLabel.textContent = '/' + (path || '');
			browserContainer.innerHTML = '<tr><td colspan="5">Lade...</td></tr>';

			// Aktualisierung des "Zurück"-Buttons
			if (path) {
				backBtn.style.display = 'inline-block';
			} else {
				backBtn.style.display = 'none';
			}

			fetch(BASE_URL + "admin/ftpmanager/load_folder", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: new URLSearchParams({ folder: path })
			})
				.then(res => res.json())
				.then(data => {
					if (data.error) {
						browserContainer.innerHTML = `<tr><td colspan="5"><div class="alert alert-danger">Fehler: ${data.error}</div></td></tr>`;
						return;
					}

					let html = '';
					data.forEach(item => {
						let typeContent = '';
						if (item.type === 'dir') {
							typeContent = '<i class="bi bi-folder-fill text-warning" style="font-size: 24px;"></i>';
						} else if (item.type === 'file' && /\.(jpg|jpeg|png|gif|webp)$/i.test(item.name)) {
							typeContent = `<img src="${item.url}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">`;
						} else {
							typeContent = '<i class="bi bi-file-earmark-fill text-primary" style="font-size: 24px;"></i>';
						}
						const size = item.size && item.size !== -1 ? (item.size / 1024).toFixed(2) + ' KB' : '-';
						const action = item.type === 'dir'
							? `<a href="#" class="ftp-folder" data-path="${item.path}">Öffnen</a>`
							: (/\.(jpg|jpeg|png|gif|webp)$/i.test(item.name)
								? `<a href="#" class="ftp-image-choose" data-path="${item.url}">Auswählen</a>`
								: '-');

						html += `
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">${typeContent}</td>
                        <td>${item.name}</td>
                        <td>${item.path}</td>
                        <td>${size}</td>
                        <td>${action}</td>
                    </tr>`;
					});
					browserContainer.innerHTML = html || '<tr><td colspan="5">Der Ordner ist leer.</td></tr>';

					// Navigation für Ordner
					browserContainer.querySelectorAll('.ftp-folder').forEach(a => {
						a.addEventListener('click', e => {
							e.preventDefault();
							loadFolder(a.dataset.path);
						});
					});

					// Auswahl von Bildern
					browserContainer.querySelectorAll('.ftp-image-choose').forEach(img => {
						img.addEventListener('click', e => {
							e.preventDefault();
							const path = img.dataset.path;
							hiddenInput.value = path;
							preview.innerHTML = `<img src="${path}" class="img-fluid border mt-2">`;
							modal.hide();
						});
					});
				})
				.catch(err => {
					browserContainer.innerHTML = `<tr><td colspan="5"><div class="alert alert-danger">Fehler: ${err.message}</div></td></tr>`;
				});
		}

		// Navigation zurück
		backBtn.addEventListener('click', () => {
			const parentPath = currentPath.includes('/') ? currentPath.substring(0, currentPath.lastIndexOf('/')) : '';
			loadFolder(parentPath);
		});

		// Öffnen des Modals und Laden des Wurzelordners
		btn.addEventListener("click", () => {
			modal.show();
			loadFolder(currentPath);
		});
	});
</script>
