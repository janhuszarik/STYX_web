<?php
$actionUrl = isset($article) ? 'admin/article_save/edit/' . $article->id : 'admin/article_save';
?>

	<form method="post" action="<?= base_url($actionUrl) ?>">
		<input type="hidden" name="category_id" value="<?= $categoryId ?>">

		<div class="form-group pb-3">
			<label for="title">Titel</label>
			<input type="text" class="form-control" name="title" id="title" value="<?= isset($article) ? htmlspecialchars($article->title) : '' ?>" required>
		</div>

		<div class="form-group pb-3">
			<label for="slug">Slug</label>
			<input type="text" class="form-control" name="slug" id="slug" value="<?= isset($article) ? $article->slug : '' ?>">
		</div>

		<div class="form-group pb-3">
			<label for="text">Beschreibung</label>
			<textarea class="form-control" name="text" id="text" rows="4"><?= isset($article) ? htmlspecialchars($article->text) : '' ?></textarea>
		</div>

		<div class="form-group pb-3">
			<label for="keywords">Keywords</label>
			<input type="text" class="form-control" name="keywords" id="keywords" value="<?= isset($article) ? htmlspecialchars($article->keywords) : '' ?>">
		</div>

		<div class="form-group pb-3">
			<label for="meta">Meta</label>
			<input type="text" class="form-control" name="meta" id="meta" value="<?= isset($article) ? htmlspecialchars($article->meta) : '' ?>">
		</div>

		<div class="form-group pb-3">
			<label for="active">Status</label>
			<select name="active" class="form-control" id="active">
				<option value="J" <?= isset($article) && $article->active == 'J' ? 'selected' : '' ?>>Aktiv</option>
				<option value="N" <?= isset($article) && $article->active == 'N' ? 'selected' : '' ?>>Inaktiv</option>
			</select>
		</div>
		<?php if (isset($article)): ?>
			<input type="hidden" name="id" value="<?= $article->id ?>">
		<?php endif; ?>

		<button type="submit" class="btn btn-primary">Speichern</button>
		<a href="<?= base_url('admin/articles_in_category/' . $categoryId) ?>" class="btn btn-secondary">Zurück</a>
	</form>

