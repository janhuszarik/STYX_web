<div class="row">
	<div class="col-lg-8">
		<section class="card">
			<header class="card-header">
				<h2 class="card-title">
					<?= isset($article->id) ? 'Artikel bearbeiten' : 'Neuer Artikel' ?>
				</h2>
				<p class="card-subtitle">Bitte füllen Sie die Felder aus</p>
			</header>
			<div class="card-body">
				<form action="<?= base_url('admin/articles/save') ?>" method="post">
					<?php if (isset($article->id)): ?>
						<input type="hidden" name="id" value="<?= $article->id ?>">
					<?php endif; ?>

					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="slug">Slug</label>
							<input type="text" class="form-control" name="slug" id="slug" value="<?= $article->slug ?? '' ?>" required>
						</div>
						<div class="col-md-6">
							<label for="title">Titel</label>
							<input type="text" class="form-control" name="title" id="title" value="<?= $article->title ?? '' ?>" required>
						</div>
					</div>

					<div class="form-group pb-3">
						<label for="text">Text</label>
						<textarea class="form-control" name="text" id="text" rows="5"><?= $article->text ?? '' ?></textarea>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="keywords">Keywords</label>
							<input type="text" class="form-control" name="keywords" id="keywords" value="<?= $article->keywords ?? '' ?>">
						</div>
						<div class="col-md-6">
							<label for="meta">Meta Tags</label>
							<input type="text" class="form-control" name="meta" id="meta" value="<?= $article->meta ?? '' ?>">
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-md-6">
							<label for="created_at">Erstellt am</label>
							<input type="datetime-local" class="form-control" name="created_at" id="created_at" value="<?= isset($article->created_at) ? date('Y-m-d\TH:i', strtotime($article->created_at)) : '' ?>">
						</div>
						<div class="col-md-6">
							<label for="updated_at">Aktualisiert am</label>
							<input type="datetime-local" class="form-control" name="updated_at" id="updated_at" value="<?= isset($article->updated_at) ? date('Y-m-d\TH:i', strtotime($article->updated_at)) : '' ?>">
						</div>
					</div>

					<div class="form-group pb-3">
						<label for="active">Status</label>
						<select class="form-control" name="active" id="active">
							<option value="J" <?= isset($article->active) && $article->active === 'J' ? 'selected' : '' ?>>Aktiv</option>
							<option value="N" <?= isset($article->active) && $article->active === 'N' ? 'selected' : '' ?>>Inaktiv</option>
						</select>
					</div>

					<footer class="text-end">
						<button type="submit" class="btn btn-primary">Speichern</button>
					</footer>
				</form>
			</div>
		</section>
	</div>
</div>
