
	<style>
		.dropzone {
			border: 2px dashed #ccc;
			padding: 20px;
			text-align: center;
			margin-bottom: 20px;
			cursor: pointer;
			transition: background 0.2s;
			background: #fafafa;
			font-size: 17px;
			font-weight: 500;
			color: #2a2a2a;
		}
		.dropzone.dragover {
			background-color: #e1e1e1;
		}
		.thumbnails.thumbnails-grid {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}
		.thumbnails.thumbnails-grid .thumbnail {
			flex: 0 0 calc(10% - 10px);
			max-width: calc(10% - 10px);
			box-sizing: border-box;
		}
		@media (max-width: 1400px) {
			.thumbnails.thumbnails-grid .thumbnail {
				flex: 0 0 calc(14.28% - 10px);
				max-width: calc(14.28% - 10px);
			}
		}
		@media (max-width: 1200px) {
			.thumbnails.thumbnails-grid .thumbnail {
				flex: 0 0 calc(16.66% - 10px);
				max-width: calc(16.66% - 10px);
			}
		}
		@media (max-width: 992px) {
			.thumbnails.thumbnails-grid .thumbnail {
				flex: 0 0 calc(20% - 10px);
				max-width: calc(20% - 10px);
			}
		}
		@media (max-width: 768px) {
			.thumbnails.thumbnails-grid .thumbnail {
				flex: 0 0 calc(33.33% - 10px);
				max-width: calc(33.33% - 10px);
			}
		}
		@media (max-width: 576px) {
			.thumbnails.thumbnails-grid .thumbnail {
				flex: 0 0 calc(50% - 10px);
				max-width: calc(50% - 10px);
			}
		}
		.thumbnail {
			position: relative;
			width: 100px;
			height: 100px;
			cursor: move;
			border: 1px solid #eaeaea;
			background: #fff;
			border-radius: 6px;
			overflow: hidden;
			transition: box-shadow 0.2s;
			box-shadow: 0 1px 2px #0001;
		}
		.thumbnail img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: 6px;
		}
		.thumbnail .delete-btn {
			position: absolute;
			top: 5px;
			right: 5px;
			background: #e30000;
			color: white;
			border: none;
			border-radius: 50%;
			width: 20px;
			height: 20px;
			cursor: pointer;
			font-size: 15px;
			line-height: 18px;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 1px 3px #0003;
			transition: background 0.15s;
			z-index: 2;
		}
		.thumbnail .delete-btn:hover {
			background: #bb0000;
		}
		.upload-controls {
			display: flex;
			justify-content: flex-start;
			align-items: center;
			gap: 15px;
			margin-bottom: 16px;
		}
		.upload-controls .btn-primary {
			min-width: 210px;
			font-size: 15px;
			font-weight: 500;
			border-radius: 6px;
		}
		/* Modal upload */
		.modal .progress-container {
			margin-bottom: 15px;
		}
		.modal .progress {
			width: 100%;
			height: 20px;
			background-color: #f3f3f3;
			border-radius: 4px;
			overflow: hidden;
			margin-top: 7px;
			box-shadow: 0 1px 2px #0001;
		}
		.modal .progress-bar {
			background: linear-gradient(90deg, #28a745, #34d058);
			width: 0;
			height: 100%;
			transition: width 0.5s cubic-bezier(.4,1,.8,1), background 0.3s;
		}
		.modal .progress-bar.pulse {
			animation: pulse 1.5s infinite;
		}
		@keyframes pulse {
			0% { opacity: 1; }
			50% { opacity: 0.7; }
			100% { opacity: 1; }
		}
		.modal .progress-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 8px;
		}
		.modal .progress-percent {
			font-weight: bold;
			font-size: 18px;
			color: #267d18;
			letter-spacing: 1px;
		}
		.modal .progress-ok {
			color: #21a500;
			font-weight: bold;
			font-size: 18px;
			margin-left: 10px;
			display: none;
		}
		.upload-details-box {
			width: 100%;
			margin: 18px 0 0 0;
			background: #fdfdfd;
			border-radius: 7px;
			padding: 13px 18px 13px 18px;
			overflow-y: auto;
			border: 1px solid #e5e5e5;
			box-shadow: 0 1px 6px #0001;
			word-break: break-all;
			max-height: 350px;
			transition: background 0.3s;
			font-size: 15px;
			line-height: 1.7;
		}
		.upload-details-box b { font-weight: 700; }
		.upload-details-box .ok { color: #1cb50a; }
		.upload-details-box .err { color: #e30000; font-weight: 600;}
		.upload-details-box .wait { color: #1176b0; }
		.upload-details-box .upld {
			display: flex;
			align-items: center;
			margin-bottom: 1px;
			padding: 2px 0 2px 0;
		}
		.upload-details-box .upld:last-child { margin-bottom: 0; }
		.upload-details-box .upld .dot {
			display: inline-block;
			width: 10px; height: 10px; border-radius: 50%;
			margin-right: 8px;
		}
		.upload-details-box .upld .dot.ok { background: #1cb50a; }
		.upload-details-box .upld .dot.err { background: #e30000; }
		.upload-details-box .upld .dot.wait { background: #1176b0; }
		.upload-details-box .upld .dot.load { background: #f1c232; animation: pulse 1s infinite; }
		.upload-details-box .upld .filename { flex: 1 1 0%; margin-right: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
		.upload-details-box .upld .statustext { min-width: 90px; text-align: right; }
		.upload-details-box .done {
			margin-top: 7px;
			font-weight: 600;
			color: #189801;
			font-size: 15px;
		}
		.upload-details-box .fail {
			margin-top: 7px;
			font-weight: 600;
			color: #e30000;
			font-size: 17px;
		}
	</style>


	<div class="row">
		<div class="col-12">
			<section class="card card-yellow" style="margin-left:0; margin-right:0;">
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
					<div class="upload-controls mb-3">
						<button class="btn btn-primary" id="uploadBtn">Bilder hochladen</button>
					</div>
					<div id="uploadAlert" class="alert alert-success d-none" role="alert" style="font-size: 15px;">
					</div>
					<div class="thumbnails thumbnails-grid" id="thumbnails">
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

<!-- MODAL UPLOAD PROGRESS -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="uploadModalLabel">Upload-Fortschritt</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
			</div>
			<div class="modal-body">
				<div class="progress-container" id="modalProgressContainer" style="margin-bottom: 20px;">
					<div class="progress">
						<div class="progress-bar" id="modalProgressBar"></div>
					</div>
					<div class="progress-row" style="margin-top: 10px;">
						<span class="progress-percent" id="modalProgressPercent">0%</span>
						<span class="progress-ok" id="modalProgressOk">OK</span>
					</div>
				</div>
				<div id="modalUploadDetails" class="upload-details-box"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="modalCloseBtn" data-bs-dismiss="modal" disabled>Schließen</button>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>const dropzone = document.getElementById('dropzone');
	const fileInput = document.getElementById('fileInput');
	const uploadBtn = document.getElementById('uploadBtn');
	const thumbnails = document.getElementById('thumbnails');
	const uploadAlert = document.getElementById('uploadAlert');
	let filesToUpload = [];

	// Dropzone events
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

	// Schovaj alert pri novom nahrávaní
	function hideUploadAlert() {
		uploadAlert.classList.add('d-none');
	}
	fileInput.addEventListener('change', hideUploadAlert);
	dropzone.addEventListener('drop', hideUploadAlert);
	uploadBtn.addEventListener('click', hideUploadAlert);

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

	// MODAL upload
	const uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
	const modalProgressBar = document.getElementById('modalProgressBar');
	const modalProgressPercent = document.getElementById('modalProgressPercent');
	const modalProgressOk = document.getElementById('modalProgressOk');
	const modalUploadDetails = document.getElementById('modalUploadDetails');
	const modalCloseBtn = document.getElementById('modalCloseBtn');

	uploadBtn.addEventListener('click', async () => {
		if (filesToUpload.length === 0) {
			alert('Bitte wählen Sie Bilder zum Hochladen aus.');
			return;
		}
		// Otvor modal
		modalProgressBar.style.width = '0%';
		modalProgressBar.classList.add('pulse');
		modalProgressPercent.textContent = '0%';
		modalProgressOk.style.display = 'none';
		modalUploadDetails.innerHTML = '';
		modalCloseBtn.disabled = true;
		uploadModal.show();

		let completed = 0;
		let total = filesToUpload.length;
		let errorCount = 0;
		let uploadLog = [];

		for (let i = 0; i < total; i++) {
			uploadLog.push(
				`<div class="upld" id="upload-row-${i}">
				<span class="dot wait"></span>
				<span class="filename"><b>Bild ${i + 1} / ${total}:</b> ${filesToUpload[i].name}</span>
				<span class="statustext wait" id="file-status-${i}">Wartet...</span>
			</div>`
			);
		}
		modalUploadDetails.innerHTML = uploadLog.join('');

		for (let i = 0; i < total; i++) {
			document.getElementById('file-status-' + i).innerHTML = 'Wird hochgeladen...';
			document.getElementById('file-status-' + i).className = 'statustext load';
			document.getElementById('upload-row-' + i).querySelector('.dot').className = 'dot load';

			const file = filesToUpload[i];
			const formData = new FormData();
			formData.append('images[]', file);
			formData.append('gallery_id', <?= $gallery->id ?>);

			let xhr = new XMLHttpRequest();

			await new Promise((resolve) => {
				xhr.upload.addEventListener('progress', (e) => {
					if (e.lengthComputable) {
						const percent = Math.round((e.loaded / e.total) * 100);
						let overall = Math.round(((completed + (percent / 100)) / total) * 100);
						modalProgressBar.style.width = overall + '%';
						modalProgressPercent.textContent = overall + '%';
					}
				});
				xhr.onreadystatechange = () => {
					if (xhr.readyState === 4) {
						const statSpan = document.getElementById('file-status-' + i);
						const dot = document.getElementById('upload-row-' + i).querySelector('.dot');
						try {
							const response = JSON.parse(xhr.responseText);
							if (xhr.status === 200 && response.success) {
								statSpan.innerHTML = 'Fertig!';
								statSpan.className = 'statustext ok';
								dot.className = 'dot ok';
							} else {
								statSpan.innerHTML = `Fehler: ${response.message || 'unbekannter Fehler'}`;
								statSpan.className = 'statustext err';
								dot.className = 'dot err';
								errorCount++;
							}
						} catch {
							statSpan.innerHTML = 'Fehler beim Verarbeiten!';
							statSpan.className = 'statustext err';
							dot.className = 'dot err';
							errorCount++;
						}
						completed++;
						resolve();
					}
				};
				xhr.onerror = () => {
					const statSpan = document.getElementById('file-status-' + i);
					const dot = document.getElementById('upload-row-' + i).querySelector('.dot');
					statSpan.innerHTML = 'Netzwerkfehler!';
					statSpan.className = 'statustext err';
					dot.className = 'dot err';
					errorCount++;
					completed++;
					resolve();
				};
				xhr.open('POST', '<?= base_url('admin/image/save') ?>', true);
				xhr.send(formData);
			});
		}

		modalProgressBar.classList.remove('pulse');
		modalProgressBar.style.width = '100%';
		modalProgressPercent.textContent = '100%';
		modalProgressOk.style.display = 'inline';
		modalCloseBtn.disabled = false;
		if (errorCount > 0) {
			modalUploadDetails.innerHTML += `<div class="fail">Upload abgeschlossen – mit ${errorCount} Fehler(n)!</div>`;
		} else {
			modalUploadDetails.innerHTML += `<div class="done">Alle Bilder wurden erfolgreich hochgeladen.</div>`;
		}

		// Po uploadovaní zobraz alert nad galériou
		setTimeout(() => {
			uploadModal.hide();

			let uploadedCount = total - errorCount;
			let alertText = '';
			if (uploadedCount > 0 && errorCount === 0) {
				alertText = `${uploadedCount} Bild${uploadedCount > 1 ? 'er' : ''} wurden erfolgreich in die Galerie '<?= htmlspecialchars($gallery->name) ?>' hochgeladen.`;
			} else if (uploadedCount > 0 && errorCount > 0) {
				alertText = `${uploadedCount} Bild${uploadedCount > 1 ? 'er' : ''} erfolgreich, ${errorCount} Fehler beim Hochladen!`;
			} else {
				alertText = `Es gab nur Fehler beim Hochladen (${errorCount}).`;
			}
			uploadAlert.classList.remove('d-none', 'alert-danger', 'alert-success');
			uploadAlert.textContent = alertText;
			uploadAlert.classList.add(errorCount === 0 ? 'alert-success' : 'alert-danger');

			// Ak chceš reload, odkomentuj: location.reload();
		}, 800);
	});

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

	// Drag&Drop usporiadanie (ak používaš SortableJS)
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

