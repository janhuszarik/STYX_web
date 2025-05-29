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
				<div class="thumbnails" id="thumbnails">
					<?php foreach ($images as $image): ?>
						<?php
						// Generovanie cesty k náhľadu
						$thumb_path = obrpridajthumb($image->image_path);
						$thumb_webp_path = str_replace('.' . pathinfo($thumb_path, PATHINFO_EXTENSION), '.webp', $thumb_path);
						// Úplná cesta na serveri pre file_exists()
						$server_thumb_webp_path = FCPATH . ltrim($thumb_webp_path, './');
						$server_thumb_path = FCPATH . ltrim($thumb_path, './');
						// Cesta pre base_url()
						$thumb_webp_url = ltrim($thumb_webp_path, './');
						$thumb_url = ltrim($thumb_path, './');
						// Použijeme WebP, ak existuje, inak fallback na thumbnail
						$final_url = file_exists($server_thumb_webp_path) ? $thumb_webp_url : (file_exists($server_thumb_path) ? $thumb_url : ''); // Ak ani jeden súbor neexistuje, prázdna cesta
						?>
						<div class="thumbnail" data-id="<?= $image->id ?>" data-order="<?= $image->order_position ?>">
							<?php if ($final_url): ?>
								<img src="<?= base_url($final_url) ?>" alt="Thumbnail">
							<?php else: ?>
								<img src="<?= base_url('assets/images/placeholder.jpg') ?>" alt="Placeholder" title="Bild nicht gefunden">
							<?php endif; ?>
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
		const files = e.dataTransfer.files;
		handleFiles(files);
	});

	dropzone.addEventListener('click', () => {
		fileInput.click();
	});

	fileInput.addEventListener('change', () => {
		const files = fileInput.files;
		handleFiles(files);
	});

	function handleFiles(files) {
		for (let file of files) {
			if (file.type.startsWith('image/')) {
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

	uploadBtn.addEventListener('click', () => {
		if (filesToUpload.length === 0) {
			alert('Bitte wählen Sie Bilder zum Hochladen aus.');
			return;
		}

		const formData = new FormData();
		filesToUpload.forEach((file) => {
			formData.append('images[]', file);
		});
		formData.append('gallery_id', <?= $gallery->id ?>);

		fetch('<?= base_url('admin/image/save') ?>', {
			method: 'POST',
			body: formData
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					filesToUpload = [];
					data.files.forEach(file => {
						const thumbnail = document.createElement('div');
						thumbnail.classList.add('thumbnail');
						thumbnail.setAttribute('data-id', 'new');
						thumbnail.setAttribute('data-order', '0');
						// Generovanie cesty k náhľadu
						const thumbPath = file.path.replace(/(\.[^.]+)$/, '_thumb.webp');
						const correctedThumbPath = thumbPath.replace(/^\.\//, '');
						// Fallback na _thumb.jpg
						const thumbFallbackPath = file.path.replace(/(\.[^.]+)$/, '_thumb.jpg').replace(/^\.\//, '');
						const finalThumbPath = correctedThumbPath; // Môžete pridať kontrolu existencie súboru cez AJAX, ak je potrebné
						thumbnail.innerHTML = `
                            <img src="<?= base_url() ?>${finalThumbPath}" alt="Thumbnail">
                            <button class="delete-btn" onclick="deleteImage('new')">X</button>
                        `;
						thumbnails.appendChild(thumbnail);
					});
					location.reload();
				} else {
					alert('Fehler beim Hochladen: ' + data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Fehler beim Hochladen der Bilder.');
			});
	});

	function deleteImage(imageId) {
		fetch('<?= base_url('admin/image/delete/') ?>' + imageId, {
			method: 'POST'
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					const thumbnail = document.querySelector(`.thumbnail[data-id="${imageId}"]`);
					if (thumbnail) {
						thumbnail.remove();
					}
				} else {
					alert('Fehler beim Löschen: ' + data.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Fehler beim Löschen des Bildes.');
			});
	}

	new Sortable(thumbnails, {
		animation: 150,
		onEnd: (evt) => {
			const thumbnailsList = document.querySelectorAll('.thumbnail');
			thumbnailsList.forEach((thumbnail, index) => {
				const imageId = thumbnail.getAttribute('data-id');
				if (imageId !== 'new') {
					fetch('<?= base_url('admin/image/update_order') ?>', {
						method: 'POST',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						body: `image_id=${imageId}&order_position=${index + 1}`
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								thumbnail.setAttribute('data-order', index + 1);
							}
						});
				}
			});
		}
	});
</script>
