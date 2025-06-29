<style>
	#ftpImagePreview img {
		max-width: 200px; /* Zväčšený náhľad pre náhľadové okno */
		max-height: 200px;
		object-fit: contain;
	}
	#ftp-browser-container {
		max-height: 600px; /* Väčší kontajner pre obsah */
		overflow-y: auto;
	}
	.modal-dialog {
		max-width: 90vw; /* Väčší width, 90% šírky obrazovky */
	}
	#ftp-items-list {
		display: grid;
		grid-template-columns: repeat(2, 1fr); /* Dva stĺpce */
		gap: 10px;
	}
	.ftp-item {
		padding: 12px;
		cursor: pointer;
		border: 1px solid #dee2e6;
		border-radius: 4px;
		display: flex;
		align-items: center;
		gap: 10px;
		background-color: #fff;
	}
	.ftp-item:hover {
		background-color: #f8f9fa;
	}
	.ftp-item i {
		font-size: 24px; /* Väčšie ikony */
	}
	.ftp-item img {
		width: 60px; /* Väčší náhľad */
		height: 60px;
		object-fit: cover;
		border: 1px solid #ddd;
	}
	.ftp-breadcrumb {
		font-size: 14px;
		margin-bottom: 10px;
	}
	.ftp-breadcrumb a {
		color: #007bff;
		text-decoration: none;
	}
	.ftp-breadcrumb a:hover {
		text-decoration: underline;
	}
	#ftp-back-btn:disabled {
		opacity: 0.5;
		cursor: not-allowed;
	}
	.ftp-loading {
		text-align: center;
		padding: 20px;
		color: #666;
		grid-column: span 2; /* Zaberá oba stĺpce */
	}
</style>

<div id="ftp-browser-container">
	<div class="mb-2 d-flex align-items-center">
		<button type="button" id="ftp-back-btn" class="btn btn-sm btn-secondary me-2">
			<i class="bi bi-arrow-left"></i> Zurück
		</button>
		<button type="button" id="ftp-home-btn" class="btn btn-sm btn-secondary me-2">
			<i class="bi bi-house"></i> Start
		</button>
		<strong>Aktueller Pfad:</strong>
		<span id="ftp-breadcrumb" class="ms-2"></span>
	</div>
	<div id="ftp-folder-contents">
		<div id="ftp-items-list"></div>
	</div>
</div>

<script>
	const BASE_URL = "<?= base_url() ?>";

	document.addEventListener("DOMContentLoaded", () => {
		const modalEl = document.getElementById("ftpModal"),
			modal = new bootstrap.Modal(modalEl),
			itemsList = document.getElementById("ftp-items-list"),
			breadcrumb = document.getElementById("ftp-breadcrumb"),
			backBtn = document.getElementById("ftp-back-btn"),
			homeBtn = document.getElementById("ftp-home-btn");

		let pathHistory = [''];
		let currentPathIndex = 0;

		function updateBreadcrumb(path) {
			const parts = path ? path.split('/') : [];
			let html = '<a href="#" data-path="">/</a>';
			let currentPath = '';
			parts.forEach((part, index) => {
				if (part) {
					currentPath += (currentPath ? '/' : '') + part;
					html += ` / <a href="#" data-path="${currentPath}">${part}</a>`;
				}
			});
			breadcrumb.innerHTML = html;

			breadcrumb.querySelectorAll('a').forEach(link => {
				link.addEventListener('click', e => {
					e.preventDefault();
					const newPath = link.dataset.path;
					while (pathHistory.length - 1 > currentPathIndex) {
						pathHistory.pop();
					}
					pathHistory.push(newPath);
					currentPathIndex = pathHistory.length - 1;
					loadFolder(newPath);
				});
			});
		}

		function loadFolder(path) {
			itemsList.innerHTML = '<div class="ftp-loading">Lade...</div>';
			backBtn.disabled = currentPathIndex === 0;

			fetch(BASE_URL + "admin/ftpmanager/load_folder", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: new URLSearchParams({ folder: path })
			})
				.then(res => res.json())
				.then(data => {
					if (data.error) {
						itemsList.innerHTML = `<div class="alert alert-danger">Fehler: ${data.error}</div>`;
						return;
					}

					let html = '';
					data.forEach(item => {
						const isImage = item.type === 'file' && /\.(jpg|jpeg|png|gif|webp)$/i.test(item.name);
						const icon = item.type === 'dir'
							? '<i class="bi bi-folder-fill text-warning"></i>'
							: (isImage
								? `<img src="${item.url}" alt="${item.name}" loading="lazy">`
								: '<i class="bi bi-file-earmark-fill text-primary"></i>');
						const actionClass = item.type === 'dir' ? 'ftp-folder' : (isImage ? 'ftp-image-choose' : '');
						const size = item.size && item.size !== -1 ? (item.size / 1024).toFixed(2) + ' KB' : '-';

						html += `
                            <div class="ftp-item ${actionClass}" data-path="${item.path}" data-url="${item.url || ''}">
                                <div>${icon}</div>
                                <div>${item.name}</div>
                                <div style="margin-left: auto;">${size}</div>
                            </div>`;
					});
					itemsList.innerHTML = html || '<div class="ftp-loading">Der Ordner ist leer.</div>';

					itemsList.querySelectorAll('.ftp-folder').forEach(item => {
						item.addEventListener('click', e => {
							e.preventDefault();
							const newPath = item.dataset.path;
							pathHistory.push(newPath);
							currentPathIndex++;
							loadFolder(newPath);
						});
					});

					itemsList.querySelectorAll('.ftp-image-choose').forEach(img => {
						img.addEventListener('click', e => {
							e.preventDefault();
							const path = img.dataset.url;
							const targetInput = document.getElementById(lastTarget);
							const previewDiv = document.getElementById(lastPreview);
							targetInput.value = path;
							previewDiv.innerHTML = `<img src="${path}" class="img-fluid border mt-2">`;
							modal.hide();
							document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
							document.body.classList.remove('modal-open');
							document.body.style.overflow = '';
							document.body.style.paddingRight = '';
						});
					});

				})
				.catch(err => {
					itemsList.innerHTML = `<div class="alert alert-danger">Fehler: ${err.message}</div>`;
				});

			updateBreadcrumb(path);
		}

		backBtn.addEventListener('click', e => {
			e.preventDefault();
			if (currentPathIndex > 0) {
				currentPathIndex--;
				loadFolder(pathHistory[currentPathIndex]);
			}
		});

		homeBtn.addEventListener('click', e => {
			e.preventDefault();
			pathHistory = [''];
			currentPathIndex = 0;
			loadFolder('');
		});

		modalEl.addEventListener('hidden.bs.modal', () => {
			const backdrop = document.querySelector('.modal-backdrop');
			if (backdrop) {
				backdrop.remove();
			}
			document.body.classList.remove('modal-open');
			document.body.style.overflow = '';
			document.body.style.paddingRight = '';
		});

		document.body.addEventListener('click', function (e) {
			if (!e.target.matches('.ftp-picker')) return;
			lastTarget = e.target.dataset.ftpTarget;
			lastPreview = e.target.dataset.previewTarget;
			modal.show();
			loadFolder(pathHistory[currentPathIndex]);
		});
	});
</script>
