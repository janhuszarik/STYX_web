<?php /* bestProduct_form.php */ ?>
<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">
                    <?= isset($product->id) ? 'Produkt bearbeiten: ' . htmlspecialchars($product->name) : 'Produkt hinzufügen' ?>
                </h2>
                <p class="card-subtitle">
                    <?= isset($product->id) ? 'Bearbeiten Sie bestehendes Produkt nach Bedarf.' : 'Geben Sie die Daten für das neue Produkt ein.' ?>
                </p>
            </header>

            <div class="card-body">
                <form method="post" action="<?= base_url('admin/bestProduct/save') ?>" enctype="multipart/form-data">
                    <?php if (!empty($product->id)): ?>
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                    <?php endif; ?>

                    <div class="row form-group pb-3">
                        <div class="col-lg-6">
                            <label class="col-form-label">Sprache
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Sprachauswahl, in der dieses Produkt angezeigt wird."></i>
                            </label>
                            <select class="form-control" name="lang">
                                <option value="de" <?= ($product->lang ?? '') == 'de' ? 'selected' : '' ?>>Deutsch</option>
                                <option value="en" <?= ($product->lang ?? '') == 'en' ? 'selected' : '' ?>>English</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">Aktiv?
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Bestimmen Sie, ob das Produkt sichtbar ist."></i>
                            </label>
                            <select name="active" class="form-control">
                                <option value="1" <?= !empty($product->active) ? 'selected' : '' ?>>Ja</option>
                                <option value="0" <?= empty($product->active) ? 'selected' : '' ?>>Nein</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group pb-3">
                        <div class="col-lg-6">
                            <label class="col-form-label">Hauptüberschrift
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Titel des Produkts, wird auf der Webseite angezeigt."></i>
                            </label>
                            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($product->name ?? '') ?>">
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">URL
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Link zur Produktseite oder extern."></i>
                            </label>
                            <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($product->url ?? '') ?>">
                        </div>
                    </div>

                    <div class="row form-group pb-3">
                        <div class="col-lg-6">
                            <label class="col-form-label">Bild hochladen
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Empfohlen: JPG/PNG/WebP"></i>
                            </label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($product->image)): ?>
                                <img src="<?= base_url($product->image) ?>" height="50" class="mt-2">
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">Position
                                <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Anzeigereihenfolge auf der Webseite."></i>
                            </label>
                            <input type="number" name="orderBy" class="form-control" min="0" value="<?= htmlspecialchars($product->orderBy ?? '') ?>">
                        </div>
                    </div>

                    <div class="row form-group pb-3">
                        <div class="col-lg-6">
                            <label class="col-form-label">Startdatum</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $product->start_date ?? '' ?>">
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label">Enddatum</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $product->end_date ?? '' ?>">
                        </div>
                    </div>

                    <div class="row form-group pb-3">
                        <div class="col-lg-4">
                            <label class="col-form-label">Ist Aktion?</label>
                            <select name="action" class="form-control">
                                <option value="1" <?= ($product->action ?? 0) == 1 ? 'selected' : '' ?>>Ja</option>
                                <option value="0" <?= ($product->action ?? 0) == 0 ? 'selected' : '' ?>>Nein</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Aktion Bezeichnung</label>
                            <input type="text" name="aktion_name" class="form-control" value="<?= htmlspecialchars($product->aktion_name ?? '') ?>">
                        </div>
                        <div class="col-lg-4">
                            <label class="col-form-label">Preis</label>
                            <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($product->price ?? '') ?>">
                        </div>
                    </div>

                    <footer class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <?= isset($product->id) ? 'Speichern' : 'Erstellen' ?>
                        </button>
                        <a href="<?= base_url('admin/bestProduct') ?>" class="btn btn-danger">Zurück zur Liste</a>
                    </footer>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
