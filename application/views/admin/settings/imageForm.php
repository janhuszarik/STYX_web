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
	.progress {
		height: 20px;
		background-color: #f5f5f5;
		border-radius: 4px;
		overflow: hidden;
	}
	.progress-bar {
		background-color: #007bff;
		color: white;
		text-align: center;
		line-height: 20px;
		transition: width 0.3s ease;
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
					Drag & Drop Bilder hier oder klicken Sie zum Auswählen
					<input type="file" id="fileInput" name="images[]" multiple accept="image/*" style="display: none;">
				</div>
				<button class="btn btn-primary mb-3" id="uploadBtn">Bilder hochladen</button>
				<!-- Add Progress Bar -->
				<div class="progress mb-3" id="uploadProgress" style="display: none;">
					<div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar">0%</div>
				</div>
				<div class="thumbnails" id="thumbnails">
					<?php foreach ($images as $image): ?>
						<?php
						$original_path = $image->image_path;
						$parts = pathinfo($original_path);
						$webp_name = $parts['filename'] . '.webp';
						$clean_dirname = ltrim($parts['dirname'], './'); // odstráni ./ alebo /
						$webp_url = base_url($clean_dirname . '/' . $webp_name);
						?>
						<div class="thumbnail" data-id="<?= $image->id ?>" data-order="<?= $image->order_position ?>">
							<img src="<?= $webp_url ?>" alt="Thumbnail">
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
	let filesToUpload = [];

	// Prevent duplicate event listeners by removing existing ones
	const clearEventListeners = (element, event) => {
		const clone = element.cloneNode(true);
		element.parentNode.replaceChild(clone, element);
		return clone;
	};

	// Reassign elements after clearing listeners
	const refreshedUploadBtn = clearEventListeners(uploadBtn, 'click');

	// Drag and Drop handling
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
		fileInput.value = ''; // Clear file input to prevent re-adding same files
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
                    <img src="${e.target.result}" alt="Thumbnail">
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

	refreshedUploadBtn.addEventListener('click', () => {
		if (filesToUpload.length === 0) {
			alert('Bitte wählen Sie Bilder zum Hochladen aus.');
			return;
		}

		const formData = new FormData();
		filesToUpload.forEach(file => formData.append('images[]', file));
		formData.append('gallery_id', <?= $gallery->id ?>);

		const xhr = new XMLHttpRequest();
		const progressBar = document.getElementById('progressBar');
		const progressContainer = document.getElementById('uploadProgress');

		// Show progress bar
		progressContainer.style.display = 'block';
		progressBar.style.width = '0%';
		progressBar.textContent = '0%';

		// Disable upload button to prevent multiple clicks
		refreshedUploadBtn.disabled = true;

		// Track upload progress
		xhr.upload.addEventListener('progress', (e) => {
			if (e.lengthComputable) {
				const percentComplete = Math.round((e.loaded / e.total) * 100);
				progressBar.style.width = percentComplete + '%';
				progressBar.textContent = percentComplete + '%';
			}
		});

		xhr.open('POST', '<?= base_url('admin/image/save') ?>', true);

		xhr.onload = () => {
			const data = JSON.parse(xhr.responseText);
			if (data.success) {
				// Clear files and thumbnails
				filesToUpload = [];
				thumbnails.innerHTML = ''; // Clear displayed thumbnails
				data.files.forEach(file => {
					const parts = file.path.split('/');
					const fullName = parts.pop();
					const dir = parts.join('/');
					const nameParts = fullName.split('.');
					const thumbName = nameParts[0] + '_thumb.' + nameParts[1];
					const fullThumb = `https://styx.styxnatur.at/${dir}/${thumbName}`;

					const thumbEl = document.createElement('div');
					thumbEl.classList.add('thumbnail');
					thumbEl.setAttribute('data-id', 'new');
					thumbEl.setAttribute('data-order', '0');
					thumbEl.innerHTML = `
                    <img src="${fullThumb}" alt="Thumbnail">
                    <button class="delete-btn" onclick="deleteImage('new')">X</button>
                `;
					thumbnails.appendChild(thumbEl);
				});
				// Hide progress bar and reload
				progressContainer.style.display = 'none';
				location.reload();
			} else {
				alert('Fehler beim Hochladen: ' + data.message);
				progressContainer.style.display = 'none';
			}
			// Re-enable upload button
			refreshedUploadBtn.disabled = false;
		};

		xhr.onerror = () => {
			alert('Fehler beim Hochladen der Bilder.');
			progressContainer.style.display = 'none';
			refreshedUploadBtn.disabled = false;
		};

		xhr.send(formData);
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
			.catch(err => {
				console.error(err);
				alert('Fehler beim Löschen des Bildes.');
			});
	}

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
