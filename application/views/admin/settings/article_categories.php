<div class="col-lg-12">
	<div class="row">
		<!-- FORMULÁR VĽAVO -->
		<div class="col-lg-6">
			<section class="card">
				<header class="card-header">
					<h2 class="card-title"><?= isset($edit) ? 'Kategóriu upraviť' : 'Pridať kategóriu' ?></h2>
					<p class="card-subtitle">Zadajte údaje pre kategóriu článkov</p>
				</header>
				<div class="card-body">
					<form action="<?= base_url('admin/article_categories/' . (isset($edit) ? 'edit/' . $edit->id : 'add')) ?>" method="post">
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<label class="col-form-label">Jazyk</label>
								<select class="form-control" name="lang">
									<option value="sk" <?= isset($edit) && $edit->lang == 'sk' ? 'selected' : '' ?>>Slovensky</option>
									<option value="de" <?= isset($edit) && $edit->lang == 'de' ? 'selected' : '' ?>>Deutsch</option>
								</select>
							</div>
							<div class="col-lg-6">
								<label class="col-form-label">Aktívna?</label>
								<select name="active" class="form-control">
									<option value="1" <?= isset($edit) && $edit->active ? 'selected' : '' ?>>Áno</option>
									<option value="0" <?= isset($edit) && !$edit->active ? 'selected' : '' ?>>Nie</option>
								</select>
							</div>
						</div>

						<div class="form-group pb-3">
							<label class="col-form-label">Názov kategórie</label>
							<input type="text" name="name" class="form-control" required value="<?= isset($edit) ? htmlspecialchars($edit->name) : '' ?>">
						</div>

						<footer class="card-footer text-end">
							<button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Uložiť zmeny' : 'Pridať kategóriu' ?></button>
						</footer>
					</form>
				</div>
			</section>
		</div>

		<!-- TABUĽKA VPRAVO -->
		<div class="col-lg-6">
			<section class="card card-yellow">
				<header class="card-header">
					<h3 class="card-title">Zoznam kategórií</h3>
					<p class="card-subtitle">Počet: <?= count($list) ?></p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered mb-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Názov</th>
								<th>Slug</th>
								<th>Jazyk</th>
								<th>Aktívna</th>
								<th>Akcia</th>
							</tr>
							</thead>
							<tbody>
							<?php if (empty($list)): ?>
								<tr><td colspan="6" class="text-center">Žiadne dáta</td></tr>
							<?php else: foreach ($list as $k => $r): ?>
								<tr>
									<td><?= ++$k ?></td>
									<td><?= htmlspecialchars($r->name) ?></td>
									<td><?= $r->slug ?></td>
									<td><?= strtoupper($r->lang) ?></td>
									<td><?= $r->active ? 'Áno' : 'Nie' ?></td>
									<td class="text-center">
										<a href="<?= base_url('admin/article_categories/edit/' . $r->id) ?>"><i class="fa fa-edit text-success"></i></a>
										&nbsp;
										<a href="<?= base_url('admin/article_categories/delete/' . $r->id) ?>" onclick="return confirm('Naozaj chcete vymazať?')"><i class="fa fa-trash text-danger"></i></a>
									</td>
								</tr>
							<?php endforeach; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
