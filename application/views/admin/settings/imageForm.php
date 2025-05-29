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
						$original_path = $image->image_path;
						$parts = pathinfo($original_path);
						$thumb_name = $parts['filename'] . '_thumb.' . $parts['extension'];
						$clean_dirname = ltrim($parts['dirname'], './'); // odstráni ./ alebo /
						$thumb_url = base_url($clean_dirname . '/' . $thumb_name);
						?>
						<div class="thumbnail" data-id="<?= $image->id ?>" data-order="<?= $image->order_position ?>">
							<img src="<?= $thumb_url ?>" alt="Thumbnail">
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
		handleFiles(e.dataTransfer.files);
	});

	dropzone.addEventListener('click', () => {
		fileInput.click();
	});

	fileInput.addEventListener('change', () => {
		handleFiles(fileInput.files);
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
		filesToUpload.forEach(file => formData.append('images[]', file));
		formData.append('gallery_id', <?= $gallery->id ?>);

		fetch('<?= base_url('admin/image/save') ?>', {
			method: 'POST',
			body: formData
		})
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					filesToUpload = [];
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
					location.reload();
				} else {
					alert('Fehler beim Hochladen: ' + data.message);
				}
			})
			.catch(err => {
				console.error(err);
				alert('Fehler beim Hochladen der Bilder.');
			});
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
