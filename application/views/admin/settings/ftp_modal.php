<style>
	#ftpImagePreview img {
		max-width: 200px;
		max-height: 200px;
		object-fit: contain;
	}
	#ftp-browser-container {
		max-height: calc(80vh - 100px);
		overflow-y: auto;
	}
	.modal-dialog {
		position: fixed;
		top: 50%;
		left: 50%;
		width: 80vw;
		height: 80vh;
		margin-top: -40vh;
		margin-left: -40vw;
		max-width: 80vw;
		max-height: 80vh;
		display: flex;
		flex-direction: column;
	}
	.modal-content {
		height: 100%;
		display: flex;
		flex-direction: column;
	}
	#ftp-folder-contents {
		flex: 1;
	}
	#ftp-items-list {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
		word-break: break-all;
	}
	.ftp-item:hover {
		background-color: #f8f9fa;
	}
	.ftp-item i {
		font-size: 24px;
	}
	.ftp-item img {
		width: 60px;
		height: 60px;
		object-fit: cover;
		border: 1px solid #ddd;
	}
	.ftp-breadcrumb {
		font-size: 14px;
		margin-bottom: 10px;
		word-break: break-all;
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
		grid-column: 1 / -1;
	}
</style>

<div id="ftp-browser-container">
	<div class="mb-2 d-flex align-items-center flex-wrap">
		<button type="button" id="ftp-back-btn" class="btn btn-sm btn-secondary me-2">
			<i class="fa fa-arrow-left"></i> Zurück
		</button>
		<button type="button" id="ftp-home-btn" class="btn btn-sm btn-secondary me-2">
			<i class="fa fa-home"></i> Start
		</button>
		<strong class="me-2">Aktueller Pfad:</strong>
		<span id="ftp-breadcrumb"></span>
	</div>

	<div class="input-group my-2">
		<input type="text" id="ftp-search-input" class="form-control form-control-sm" placeholder="Suchen im aktuellen Verzeichnis...">
		<button type="button" id="ftp-search-btn" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
	</div>

	<div id="ftp-folder-contents">
		<div id="ftp-items-list"></div>
	</div>
</div>

<script>
	const BASE_URL = "<?= base_url() ?>";

	document.addEventListener("DOMContentLoaded", () => {
		const modalEl = document.getElementById("ftpModal");
		const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
		const itemsList = document.getElementById("ftp-items-list");
		const breadcrumb = document.getElementById("ftp-breadcrumb");
		const backBtn = document.getElementById("ftp-back-btn");
		const homeBtn = document.getElementById("ftp-home-btn");
		const searchInput = document.getElementById("ftp-search-input");
		let lastTarget = null;
		let lastPreview = null;
		let debounceTimer;

		modalEl.addEventListener('show.bs.modal', () => {
			modalEl.querySelector('.modal-dialog').style.width = '80vw';
			modalEl.querySelector('.modal-dialog').style.height = '80vh';
			modalEl.querySelector('.modal-dialog').style.marginTop = '-40vh';
			modalEl.querySelector('.modal-dialog').style.marginLeft = '-40vw';
			document.getElementById('ftp-browser-container').style.maxHeight = 'calc(80vh - 100px)';
		});

		modalEl.addEventListener('hidden.bs.modal', () => {
			document.body.classList.remove('modal-open');
			document.body.style.overflow = '';
			document.body.style.paddingRight = '';
			const backdrops = document.querySelectorAll('.modal-backdrop');
			backdrops.forEach(backdrop => backdrop.remove());
		});

		let pathHistory = ['uploads'];
		let currentPathIndex = 0;

		function updateBreadcrumb(path) {
			const parts = path ? path.split('/') : ['uploads'];
			let html = `<a href="#" data-path="uploads">/uploads</a>`;
			let currentPath = 'uploads';
			parts.forEach((part, index) => {
				if (part && part !== 'uploads') {
					currentPath += (currentPath ? '/' : '') + part;
					html += ` / <a href="#" data-path="${currentPath}">${part}</a>`;
				}
			});
			breadcrumb.innerHTML = html;

			breadcrumb.querySelectorAll('a').forEach(link => {
				link.addEventListener('click', e => {
					e.preventDefault();
					const newPath = link.dataset.path;
					const existingIndex = pathHistory.indexOf(newPath);
					if (existingIndex > -1) {
						pathHistory.splice(existingIndex + 1);
						currentPathIndex = existingIndex;
					} else {
						pathHistory.push(newPath);
						currentPathIndex = pathHistory.length - 1;
					}
					searchInput.value = '';
					loadFolder(newPath);
				});
			});
		}

		function loadFolder(path, searchQuery = '') {
			itemsList.innerHTML = '<div class="ftp-loading">Lade...</div>';
			backBtn.disabled = path === 'uploads';

			fetch(BASE_URL + "admin/ftpmanager/load_folder", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: new URLSearchParams({ folder: path, q: searchQuery })
			})
				.then(res => res.json())
				.then(data => {
					if (data.error) {
						itemsList.innerHTML = `<div class="alert alert-danger">Fehler: ${data.error}</div>`;
						return;
					}

					let html = '';
					if (Array.isArray(data)) {
						data.forEach(item => {
							const isImage = item.type === 'file' && /\.(jpg|jpeg|png|gif|webp)$/i.test(item.name);
							const icon = item.type === 'dir'
								? '<i class="fa fa-folder" style="color: #f0ad4e;"></i>'
								: (isImage
									? `<img src="${item.url}" alt="${item.name}" loading="lazy">`
									: '<i class="fa fa-file" style="color: #999;"></i>');
							const actionClass = item.type === 'dir' ? 'ftp-folder' : (isImage ? 'ftp-image-choose' : '');
							const size = item.size && item.size !== -1 ? (item.size / 1024).toFixed(2) + ' KB' : '-';

							html += `
                            <div class="ftp-item ${actionClass}" data-path="${item.path}" data-url="${item.url || ''}">
                                <div>${icon}</div>
                                <div>${item.name}</div>
                                <div style="margin-left: auto;">${size}</div>
                            </div>`;
						});
					}

					itemsList.innerHTML = html || '<div class="ftp-loading">Der Ordner ist leer oder es wurden keine Ergebnisse gefunden.</div>';

					itemsList.querySelectorAll('.ftp-folder').forEach(item => {
						item.addEventListener('click', e => {
							e.preventDefault();
							const newPath = item.dataset.path;
							pathHistory.push(newPath);
							currentPathIndex++;
							searchInput.value = '';
							loadFolder(newPath);
						});
					});

					itemsList.querySelectorAll('.ftp-image-choose').forEach(img => {
						img.addEventListener('click', e => {
							e.preventDefault();
							const path = img.dataset.url;
							const targetInput = document.getElementById(lastTarget);
							const previewDiv = document.getElementById(lastPreview);

							if (targetInput) {
								targetInput.value = path;
							}
							if (previewDiv) {
								previewDiv.innerHTML = `<img src="${path}" class="img-fluid border mt-2" style="max-width:150px;max-height:150px;object-fit:contain;">`;
							}

							modal.hide();
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
				searchInput.value = '';
				loadFolder(pathHistory[currentPathIndex]);
			}
		});

		homeBtn.addEventListener('click', e => {
			e.preventDefault();
			pathHistory = ['uploads'];
			currentPathIndex = 0;
			searchInput.value = '';
			loadFolder('uploads');
		});

		searchInput.addEventListener('input', () => {
			clearTimeout(debounceTimer);
			debounceTimer = setTimeout(() => {
				const query = searchInput.value;
				const currentPath = pathHistory[currentPathIndex];
				loadFolder(currentPath, query);
			}, 300);
		});

		document.body.addEventListener('click', function (e) {
			if (!e.target.matches('.ftp-picker')) return;
			lastTarget = e.target.dataset.ftpTarget;
			lastPreview = e.target.dataset.previewTarget;
			modal.show();
			loadFolder(pathHistory[currentPathIndex], searchInput.value);
		});
	});
</script>
