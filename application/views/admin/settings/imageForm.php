<style>
	.dropzone {
		border: 2px dashed #ccc;
		padding: 20px;
		text-align: center;
		margin-bottom: 20px;
		cursor: pointer;
	}
	.dropzone.dragover {
		background-color: #e1e1e1;
	}
	.thumbnails {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}
	.thumbnail {
		position: relative;
		width: 100px;
		height: 100px;
		cursor: move;
	}
	.thumbnail img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
	.thumbnail .delete-btn {
		position: absolute;
		top: 5px;
		right: 5px;
		background: red;
		color: white;
		border: none;
		border-radius: 50%;
		width: 20px;
		height: 20px;
		cursor: pointer;
	}
	.upload-controls {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
	}
	.progress-container {
		position: relative;
		width: 900px;
	}
	.progress {
		height: 20px;
		background-color: #f5f5f5;
		border-radius: 4px;
		overflow: hidden;
	}
	.progress-bar {
		background: linear-gradient(90deg, #28a745, #34d058);
		width: 0;
		height: 100%;
		transition: width 0.5s ease-in-out, background 0.3s ease;
	}
	.progress-bar.pulse {
		animation: pulse 1.5s infinite;
	}
	@keyframes pulse {
		0% { opacity: 1; }
		50% { opacity: 0.7; }
		100% { opacity: 1; }
	}
	.progress-text {
		position: absolute;
		top: -20px;
		right: 0;
		font-weight: bold;
		display: flex;
		align-items: center;
	}
	.progress-text .dots {
		margin-left: 5px;
		display: inline-block;
	}
	.progress-text .dots::after {
		content: '...';
		display: inline-block;
		width: 20px;
		text-align: left;
		animation: dot-elastic 1.5s infinite;
	}
	@keyframes dot-elastic {
		0% { content: '...'; }
		33% { content: '..'; }
		66% { content: '.'; }
		100% { content: '...'; }
	}
	.progress-ok {
		position: absolute;
		top: -20px;
		right: 0;
		color: green;
		font-weight: bold;
		display: none;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<section class="card card-yellow">
			<header class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h3 class="card-title mb-0">Bilder in Galerie: <?= htmlspecialchars($gallery->name) ?></h3>
					<p class="card-subtitle">Kategorie: <a href="<?= base_url('admin/galleries_in_category/' . $category->id) ?>"><?= htmlspecialchars($category->name) ?></a></p>
				</div>
			</header>
			<div class="card-body">
				<div class="dropzone" id="dropzone">
					Bilder hierher ziehen oder klicken zum Auswählen
					<input type="file" id="fileInput" name="images[]" multiple accept="image/*" style="display: none;">
				</div>
				<div class="upload-controls">
					<button class="btn btn-primary" id="uploadBtn">Bilder hochladen</button>
					<div class="progress-container" id="uploadProgress" style="display: none;">
						<span class="progress-text" id="progressText">0%<span class="dots"></span></span>
						<span class="progress-ok" id="progressOk">OK</span>
						<div class="progress">
							<div class="progress-bar" id="progressBar"></div>
						</div>
						<div id="uploadDetails" style="margin-top:10px; font-size:15px;"></div>
					</div>

				</div>
				<div class="thumbnails" id="thumbnails">
					<?php foreach ($images as $image): ?>
						<?php
						$original_path = $image->image_path;
						$parts = pathinfo($original_path);
						$webp_name = $parts['filename'] . '.webp';
						$clean_dirname = ltrim($parts['dirname'], './');
						$webp_url = base_url($clean_dirname . '/' . $webp_name);
						?>
						<div class="thumbnail" data-id="<?= $image->id ?>" data-order="<?= $image->order_position ?>">
							<img src="<?= $webp_url ?>" alt="Vorschau">
							<button class="delete-btn" onclick="deleteImage(<?= $image->id ?>)">X</button>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
	const dropzone = document.getElementById('dropzone');
	const fileInput = document.getElementById('fileInput');
	const uploadBtn = document.getElementById('uploadBtn');
	const thumbnails = document.getElementById('thumbnails');
	const progressBar = document.getElementById('progressBar');
	const progressText = document.getElementById('progressText');
	const progressOk = document.getElementById('progressOk');
	const progressContainer = document.getElementById('uploadProgress');
	const uploadDetails = document.getElementById('uploadDetails');
	let filesToUpload = [];

	// Dropzone funkcie
	dropzone.addEventListener('dragover', (e) => {
		e.preventDefault();
		dropzone.classList.add('dragover');
	});
	dropzone.addEventListener('dragleave', () => {
		dropzone.classList.remove('dragover');
	});
	dropzone.addEventListener('drop', (e) => {
		e.preventDefault();
		dropzone.classList.remove('dragover');
		handleFiles(e.dataTransfer.files);
	});
	dropzone.addEventListener('click', () => {
		fileInput.click();
	});
	fileInput.addEventListener('change', () => {
		handleFiles(fileInput.files);
		fileInput.value = '';
	});
	function handleFiles(files) {
		for (let file of files) {
			if (file.type.startsWith('image/') && !filesToUpload.some(f => f.name === file.name && f.size === file.size)) {
				filesToUpload.push(file);
				const reader = new FileReader();
				reader.onload = (e) => {
					const thumbnail = document.createElement('div');
					thumbnail.classList.add('thumbnail');
					thumbnail.innerHTML = `
                    <img src="${e.target.result}" alt="Vorschau">
                    <button class="delete-btn" onclick="removeThumbnail(this)">X</button>
                `;
					thumbnails.appendChild(thumbnail);
				};
				reader.readAsDataURL(file);
			}
		}
	}
	function removeThumbnail(btn) {
		const thumbnail = btn.parentElement;
		const index = Array.from(thumbnails.children).indexOf(thumbnail);
		filesToUpload.splice(index, 1);
		thumbnail.remove();
	}

	// HLAVNÁ časť – PODROBNÝ UPLOAD
	uploadBtn.addEventListener('click', async () => {
		if (filesToUpload.length === 0) {
			alert('Bitte wählen Sie Bilder zum Hochladen aus.');
			return;
		}

		progressContainer.style.display = 'block';
		progressBar.style.width = '0%';
		progressText.innerHTML = '0%<span class="dots"></span>';
		progressOk.style.display = 'none';
		progressBar.classList.add('pulse');
		uploadDetails.innerHTML = '';
		uploadBtn.disabled = true;

		let completed = 0;
		let total = filesToUpload.length;
		let errorCount = 0;
		let uploadLog = [];

		// Na začiatku vypíš všetky obrázky so statusom "Wartet..."
		for (let i = 0; i < total; i++) {
			uploadLog.push(
				`<div id="upload-row-${i}">Bild <b>${i + 1} / ${total}</b>: <span style="color:#007bff">${filesToUpload[i].name}</span> – <span id="file-status-${i}">Wartet...</span></div>`
			);
		}
		uploadDetails.innerHTML = uploadLog.join('');

		// Upload postupne po jednom obrázku
		for (let i = 0; i < total; i++) {
			// Označ aktuálny ako "Wird hochgeladen..."
			document.getElementById('file-status-' + i).innerHTML = 'Wird hochgeladen...';

			const file = filesToUpload[i];
			const formData = new FormData();
			formData.append('images[]', file);
			formData.append('gallery_id', <?= $gallery->id ?>);

			let xhr = new XMLHttpRequest();

			await new Promise((resolve) => {
				xhr.upload.addEventListener('progress', (e) => {
					if (e.lengthComputable) {
						// Percento aktuálneho obrázka
						const percent = Math.round((e.loaded / e.total) * 100);
						// Celkový progres všetkých obrázkov
						let overall = Math.round(((completed + (percent / 100)) / total) * 100);
						progressBar.style.width = overall + '%';
						progressText.innerHTML = overall + '%<span class="dots"></span>';
					}
				});

				xhr.onreadystatechange = () => {
					if (xhr.readyState === 4) {
						let statSpan = document.getElementById('file-status-' + i);
						try {
							const response = JSON.parse(xhr.responseText);
							if (xhr.status === 200 && response.success) {
								statSpan.innerHTML = '<span style="color:green;">Fertig!</span>';
							} else {
								statSpan.innerHTML = `<span style="color:red;">Fehler: ${response.message || 'unbekannter Fehler'}</span>`;
								errorCount++;
							}
						} catch {
							statSpan.innerHTML = '<span style="color:red;">Fehler beim Verarbeiten!</span>';
							errorCount++;
						}
						completed++;
						resolve();
					}
				};

				xhr.onerror = () => {
					let statSpan = document.getElementById('file-status-' + i);
					statSpan.innerHTML = '<span style="color:red;">Netzwerkfehler!</span>';
					errorCount++;
					completed++;
					resolve();
				};

				xhr.open('POST', '<?= base_url('admin/image/save') ?>', true);
				xhr.send(formData);
			});
		}

		// Dokončené
		progressBar.style.width = '100%';
		progressText.innerHTML = '100%';
		progressBar.classList.remove('pulse');
		progressOk.style.display = 'block';
		uploadBtn.disabled = false;

		if (errorCount > 0) {
			uploadDetails.innerHTML += `<br><b style="color:red;">Hochladen abgeschlossen – mit ${errorCount} Fehler(n)!</b>`;
		} else {
			uploadDetails.innerHTML += `<br><b style="color:green;">Alle Bilder wurden erfolgreich hochgeladen.</b>`;
		}

		// Reload alebo vyčistiť podľa potreby
		setTimeout(() => {
			progressContainer.style.display = 'none';
			progressText.style.display = 'block';
			progressOk.style.display = 'none';
			location.reload();
		}, 2000);
	});

	// Mazanie obrázkov
	function deleteImage(imageId) {
		fetch('<?= base_url('admin/image/delete/') ?>' + imageId, { method: 'POST' })
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					const el = document.querySelector(`.thumbnail[data-id="${imageId}"]`);
					if (el) el.remove();
				} else {
					alert('Fehler beim Löschen: ' + data.message);
				}
			})
			.catch(() => {
				alert('Fehler beim Löschen des Bildes.');
			});
	}

	// Drag&Drop usporiadanie
	new Sortable(thumbnails, {
		animation: 150,
		onEnd: () => {
			document.querySelectorAll('.thumbnail').forEach((el, idx) => {
				const imageId = el.getAttribute('data-id');
				if (imageId !== 'new') {
					fetch('<?= base_url('admin/image/update_order') ?>', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: `image_id=${imageId}&order_position=${idx + 1}`
					}).then(res => res.json()).then(data => {
						if (data.success) el.setAttribute('data-order', idx + 1);
					});
				}
			});
		}
	});

</script>
