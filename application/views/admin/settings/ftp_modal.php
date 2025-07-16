<style>
	/* Váš existujúci CSS je v poriadku, ponechávam ho bez zmeny */
	#ftpImagePreview img { max-width: 200px; max-height: 200px; object-fit: contain; }
	#ftp-browser-container { max-height: 60vh; overflow-y: auto; }
	.modal-dialog { max-width: 90vw; }
	#ftp-items-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 10px; }
	.ftp-item { padding: 12px; cursor: pointer; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; gap: 12px; background-color: #fff; transition: background-color 0.2s; }
	.ftp-item:hover { background-color: #f8f9fa; }
	.ftp-item i { font-size: 24px; }
	.ftp-item .item-icon img { width: 60px; height: 60px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; }
	.ftp-item .item-name { font-weight: 500; word-break: break-all; }
	.ftp-item .item-size { margin-left: auto; color: #6c757d; font-size: 0.9em; }
	.ftp-breadcrumb { font-size: 14px; margin-bottom: 10px; }
	.ftp-breadcrumb a { color: #007bff; text-decoration: none; }
	.ftp-breadcrumb a:hover { text-decoration: underline; }
	#ftp-back-btn:disabled { opacity: 0.5; cursor: not-allowed; }
	.ftp-loading, .ftp-empty { text-align: center; padding: 20px; color: #666; grid-column: 1 / -1; }
</style>

<div id="ftp-browser-container">
	<div class="mb-2 d-flex align-items-center p-2 bg-light border-bottom">
		<button type="button" id="ftp-back-btn" class="btn btn-sm btn-secondary me-2">
			<i class="fas fa-arrow-left"></i> Zurück
		</button>
		<button type="button" id="ftp-home-btn" class="btn btn-sm btn-secondary me-2">
			<i class="fas fa-home"></i> Start
		</button>
		<strong class="ms-2">Pfad:</strong>
		<span id="ftp-breadcrumb" class="ms-2"></span>
	</div>
	<div id="ftp-folder-contents" class="p-2">
		<div id="ftp-items-list"></div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", () => {
		const BASE_URL = "<?= base_url() ?>";
		const modalEl = document.getElementById("ftpModal");
		const itemsList = document.getElementById("ftp-items-list");
		const breadcrumbEl = document.getElementById("ftp-breadcrumb");
		const backBtn = document.getElementById("ftp-back-btn");
		const homeBtn = document.getElementById("ftp-home-btn");

		// ✅ Správna deklarácia premenných
		let pathHistory = [''];
		let currentPathIndex = 0;
		let lastTarget = null;
		let lastPreview = null;

		// --- Navigácia a načítavanie dát ---
		const loadFolder = async (path) => {
			itemsList.innerHTML = '<div class="ftp-loading">Lade...</div>';
			backBtn.disabled = currentPathIndex === 0;
			updateBreadcrumb(path);

			try {
				const response = await fetch(`${BASE_URL}admin/ftpmanager/load_folder`, {
					method: "POST",
					headers: { "Content-Type": "application/x-www-form-urlencoded" },
					body: new URLSearchParams({ folder: path })
				});

				if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

				const data = await response.json();

				if (data.error) throw new Error(data.error);

				renderItems(data);

			} catch (err) {
				itemsList.innerHTML = `<div class="alert alert-danger m-2">${err.message}</div>`;
				console.error(err);
			}
		};

		// --- Vykresľovanie ---
		const renderItems = (items) => {
			if (items.length === 0) {
				itemsList.innerHTML = '<div class="ftp-empty">Der Ordner ist leer.</div>';
				return;
			}

			// Vytriedime: najprv priečinky, potom súbory podľa mena
			items.sort((a, b) => {
				if (a.type === 'dir' && b.type !== 'dir') return -1;
				if (a.type !== 'dir' && b.type === 'dir') return 1;
				return a.name.localeCompare(b.name);
			});

			const html = items.map(item => {
				const isImage = item.type === 'file' && /\.(jpg|jpeg|png|gif|webp)$/i.test(item.name);
				const icon = item.type === 'dir'
					? '<i class="fas fa-folder text-warning"></i>'
					: (isImage
						? `<img src="${item.url}" alt="${item.name}" loading="lazy">`
						: '<i class="fas fa-file-alt text-primary"></i>');

				const actionClass = item.type === 'dir' ? 'is-folder' : (isImage ? 'is-image' : '');
				const size = item.size ? `${(item.size / 1024).toFixed(2)} KB` : '';

				return `
                <div class="ftp-item ${actionClass}" data-path="${item.path}" data-url="${item.url || ''}">
                    <div class="item-icon">${icon}</div>
                    <div class="item-name">${item.name}</div>
                    <div class="item-size">${size}</div>
                </div>`;
			}).join('');

			itemsList.innerHTML = html;
		};

		const updateBreadcrumb = (path) => {
			const parts = path ? path.split('/').filter(Boolean) : [];
			let pathAccumulator = '';
			const links = parts.map(part => {
				pathAccumulator += (pathAccumulator ? '/' : '') + part;
				return `<a href="#" data-path="${pathAccumulator}">${part}</a>`;
			});
			breadcrumbEl.innerHTML = `<a href="#" data-path="">/</a> ${parts.length > 0 ? '/ ' : ''} ${links.join(' / ')}`;
		};

		// --- Spracovanie udalostí (Event Handling) ---

		// ✅ Event Delegation: Jeden listener pre všetky kliknutia v zozname
		itemsList.addEventListener('click', (e) => {
			const item = e.target.closest('.ftp-item');
			if (!item) return;

			if (item.classList.contains('is-folder')) {
				const newPath = item.dataset.path;
				// Odstránime "forward" históriu, ak existuje
				pathHistory.splice(currentPathIndex + 1);
				pathHistory.push(newPath);
				currentPathIndex++;
				loadFolder(newPath);
			} else if (item.classList.contains('is-image')) {
				const imageUrl = item.dataset.url;
				if (!imageUrl || !lastTarget || !lastPreview) return;

				document.getElementById(lastTarget).value = imageUrl;
				document.getElementById(lastPreview).innerHTML = `<img src="${imageUrl}" class="img-fluid border mt-2">`;

				const modalInstance = bootstrap.Modal.getInstance(modalEl);
				if(modalInstance) modalInstance.hide();
			}
		});

		breadcrumbEl.addEventListener('click', (e) => {
			if (e.target.tagName !== 'A') return;
			e.preventDefault();
			const newPath = e.target.dataset.path;
			pathHistory.splice(currentPathIndex + 1);
			pathHistory.push(newPath);
			currentPathIndex++;
			loadFolder(newPath);
		});

		backBtn.addEventListener('click', () => {
			if (currentPathIndex > 0) {
				currentPathIndex--;
				loadFolder(pathHistory[currentPathIndex]);
			}
		});

		homeBtn.addEventListener('click', () => {
			pathHistory.splice(1); // Ponecháme len root
			currentPathIndex = 0;
			loadFolder('');
		});

		// Udalosť, ktorá sa spustí pred zobrazením modalu
		modalEl.addEventListener('show.bs.modal', (e) => {
			// Zistíme, ktorý button modal otvoril a uložíme si jeho data-atribúty
			lastTarget = e.relatedTarget.dataset.ftpTarget;
			lastPreview = e.relatedTarget.dataset.previewTarget;
			// Načítame aktuálny alebo koreňový priečinok
			loadFolder(pathHistory[currentPathIndex]);
		});
	});
</script>
