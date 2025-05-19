<section role="main" class="content-body">
	<header class="page-header">
		<h2><?= isset($edit) ? 'Upraviť kategóriu' : 'Pridať kategóriu' ?></h2>
	</header>

	<form method="post" action="">
		<div class="form-group">
			<label for="name">Názov kategórie</label>
			<input type="text" name="name" class="form-control" required value="<?= isset($edit) ? htmlspecialchars($edit->name) : '' ?>">
		</div>

		<div class="form-group">
			<label for="active">Aktívna</label>
			<select name="active" class="form-control">
				<option value="1" <?= isset($edit) && $edit->active ? 'selected' : '' ?>>Áno</option>
				<option value="0" <?= isset($edit) && !$edit->active ? 'selected' : '' ?>>Nie</option>
			</select>
		</div>

		<button type="submit" class="btn btn-success">Uložiť</button>
		<a href="<?= BASE_URL ?>admin/article_categories" class="btn btn-secondary">Späť</a>
	</form>
</section>
