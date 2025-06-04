<div class="form-group pb-3">
	<h3 class="fw-bold mb-1" style="border-left:4px solid #28a745; padding-left:10px;">
		Sektion Empfohlene Produkte
	</h3>
	<small class="text-muted ms-3">Diese Sektion kann leer bleiben, oder eine oder zwei Produktreihen enthalten.
		<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Abschnitt, in dem bis zu zwei Produktreihen mit jeweils drei Produkten hinzugefügt werden können. Jedes Produkt kann einen Namen, eine Beschreibung, ein Bild und eine URL haben."></i>
	</small>

	<div id="product-sets-container">
		<!-- Produkt sets will be dynamically inserted here -->
	</div>

	<div class="d-flex justify-content-start gap-2 mt-2">
		<button type="button" class="btn btn-sm btn-success" id="add-product-set">+ Produktreihe hinzufügen</button>
	</div>
</div>

<script>
	let productSetCount = 0;
	const maxProductSets = 2;
	const productsPerSet = 3;
	const articleData = <?php echo json_encode($article ?? []); ?>;

	function renderProductSet(setIndex, articleData = {}) {
		let html = `<div class="product-set border p-3 mb-4 rounded" data-index="${setIndex}">
        <h4 class="fw-bold mb-3" style="border-left:4px solid #28a745; padding-left:10px; font-size:1rem;">
            Produktreihe #${setIndex + 1}
        </h4>
        <div class="row">`;

		for (let i = 1; i <= productsPerSet; i++) {
			const suffix = (setIndex * productsPerSet) + i;
			const setNum = setIndex + 1;
			const prodNum = i;
			html += `
            <div class="col-md-4 mb-4">
                <div class="mb-2">
                    <label class="col-form-label">Produktname</label>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Name des Produkts in dieser Reihe. Wird in der Produktansicht angezeigt."></i>
                    <input type="text" name="product_name${suffix}" class="form-control" value="${articleData[`product_set${setNum}_product${prodNum}_name`] || ''}">
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Beschreibung</label>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Eine kurze Beschreibung des Produkts. Wird unter dem Produktnamen angezeigt."></i>
                    <textarea name="product_description${suffix}" class="form-control" rows="2">${articleData[`product_set${setNum}_product${prodNum}_description`] || ''}</textarea>
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Bild hochladen</label>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht das Hochladen eines Bildes für dieses Produkt. Unterstützte Formate: JPG, PNG, GIF, WEBP."></i>
                    <input type="file" name="product_image${suffix}" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Titel des Bildes (SEO)</label>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Der SEO-Titel des Produktbildes. Wird als Alt-Text verwendet, um die Suchmaschinenoptimierung zu verbessern."></i>
                    <input type="text" name="product_image${suffix}_title" class="form-control" value="${articleData[`product_set${setNum}_product${prodNum}_image_title`] || ''}">
                </div>
                <input type="hidden" name="ftp_product_image${suffix}" id="ftp_product_image${suffix}" value="${articleData[`product_set${setNum}_product${prodNum}_image`] || ''}">
                <input type="hidden" name="old_product_image${suffix}" value="${articleData[`product_set${setNum}_product${prodNum}_image`] || ''}">
                <div class="mb-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm ftp-picker" data-ftp-target="ftp_product_image${suffix}" data-preview-target="productImagePreview${suffix}">Bild aus FTP wählen</button>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Ermöglicht die Auswahl eines Bildes aus einem FTP-Verzeichnis für dieses Produkt."></i>
                </div>
                <div id="productImagePreview${suffix}" class="mb-2">
                    ${articleData[`product_set${setNum}_product${prodNum}_image`] ? `<img src="<?php echo base_url(); ?>${articleData[`product_set${setNum}_product${prodNum}_image`]}" style="max-width:100%;max-height:150px;object-fit:contain;">` : ''}
                </div>
                <div class="mb-2">
                    <label class="col-form-label">Produkt-URL</label>
                    <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Die URL, zu der dieses Produkt verlinkt. Kann eine interne oder externe Seite sein."></i>
                    <input type="text" name="product_url${suffix}" class="form-control" value="${articleData[`product_set${setNum}_product${prodNum}_url`] || ''}">
                </div>
            </div>`;
		}

		html += `</div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-sm btn-danger remove-product-set">Entfernen</button>
        </div>
    </div>`;
		document.getElementById('product-sets-container').insertAdjacentHTML('beforeend', html);
	}

	function loadExistingProductSets(articleData) {
		for (let setIndex = 0; setIndex < maxProductSets; setIndex++) {
			let hasData = false;
			for (let i = 1; i <= productsPerSet; i++) {
				const setNum = setIndex + 1;
				const prodNum = i;
				if (
					articleData[`product_set${setNum}_product${prodNum}_name`] ||
					articleData[`product_set${setNum}_product${prodNum}_description`] ||
					articleData[`product_set${setNum}_product${prodNum}_image`] ||
					articleData[`product_set${setNum}_product${prodNum}_image_title`] ||
					articleData[`product_set${setNum}_product${prodNum}_url`]
				) {
					hasData = true;
					break;
				}
			}
			if (hasData) {
				renderProductSet(setIndex, articleData);
				productSetCount++;
			}
		}
	}

	window.addEventListener('DOMContentLoaded', () => {
		loadExistingProductSets(articleData);

		document.getElementById('add-product-set').addEventListener('click', () => {
			if (productSetCount < maxProductSets) {
				renderProductSet(productSetCount, {});
				productSetCount++;
			} else {
				alert('Maximal 2 Produktreihen erlaubt.');
			}
		});

		document.getElementById('product-sets-container').addEventListener('click', function (e) {
			if (e.target.classList.contains('remove-product-set')) {
				e.target.closest('.product-set').remove();
				productSetCount--;
			}
		});

		document.getElementById('product-sets-container').addEventListener('click', function (e) {
			if (e.target.classList.contains('ftp-picker')) {
				const ftpTarget = e.target.getAttribute('data-ftp-target');
				const previewTarget = e.target.getAttribute('data-preview-target');
				// This aligns with the FTP picker functionality in article_form.php
				// The actual FTP modal is handled in article_form.php, so we ensure the event is captured
				// Placeholder for FTP picker preview (consistent with article_form.php)
				const mockFtpImage = 'https://via.placeholder.com/150';
				document.getElementById(ftpTarget).value = mockFtpImage;
				document.getElementById(previewTarget).innerHTML = `<img src="${mockFtpImage}" style="max-width:100%;max-height:150px;object-fit:contain;">`;
			}
		});
	});
</script>
