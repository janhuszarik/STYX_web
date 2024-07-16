<div class="col-xl-12">
	<div class="row">
		<div class="col-xl-6">
			<section class="card card-primary">
				<header class="card-header">
					<div class="card-actions">
						<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
						<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
					</div>
					<?php if (!empty($menu->id)){?>
						<input type="hidden" name="id" value="<?=$menu->id?>">
						<h3 class="card-title">MENU-Element bearbeiten</h3>
					<?php } else { ?>
						<h3 class="card-title">MENU-Element hinzufügen</h3>
					<?php } ?>
					<p class="card-subtitle">Erstellen Sie Text für das Menüelement</p>
				</header>
				<div class="card-body">
					<form action="<?=BASE_URL?>admin/menuSave" method="post" id="form">
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputLang">Sprache</label>
									<select class="form-control" name="lang" id="inputLang">
										<option value="de" <?php echo ($menu->lang == 'de') ? 'selected' : ''; ?>>Deutsch</option>
										<option value="en" <?php echo ($menu->lang == 'en') ? 'selected' : ''; ?>>English</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputDefault">Name des Menüelements</label>
									<input type="text" name="name" class="form-control" id="inputDefault" value="<?=!empty($menu->name)?$menu->name: ''?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputDefault">URL (//applications/config/routes.php)</label>
									<input type="text" name="url" class="form-control" id="inputDefault" value="<?=!empty($menu->url)?$menu->url: ''?>">
									<small>Soll die Unterseite einen klassischen Link zu einer anderen Website enthalten, muss diese den gesamten
										Link und das Präfix https:// enthalten, ansonsten erfolgt keine Verlinkung auf die Unterseite, sondern eine interne Weiterleitung.</small>
								</div>
							</div>
						</div>
						<div class="row form-group pb-3">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputDefaultMenu">Hauptmenüpunkt?</label>
									<select class="form-control" name="parent" id="inputDefaultMenu">
										<option value="0" <?php echo ($menu->parent == 0) ? 'selected' : ''; ?>>Ja, hauptmenü</option>
										<?php foreach ($menuparent as $menuItem): ?>
											<?php if ($menuItem->parent == 0): ?>
												<option value="<?php echo $menuItem->id; ?>" <?php echo ($menu->parent == $menuItem->id) ? 'selected' : ''; ?>><?php echo $menuItem->name; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-form-label" for="inputDefaultPosition">Auf Positionen anzeigen</label>
									<input type="number" name="orderBy" class="form-control" id="inputDefaultPosition" min="0" value="<?php echo isset($menu->orderBy) ? $menu->orderBy : ''; ?>">
								</div>
							</div>
						</div>
						<div class="form-group pb-3">
							<div class="checkbox-custom checkbox-primary">
								<input type="checkbox" name="active" id="checkboxExample2" value="1" <?php echo ($menu->active) ? 'checked' : ''; ?>>
								<label for="checkboxExample2">Aktiv?</label>
							</div>
						</div>
						<footer class="card-footer text-end">
							<?php if (!empty($menu->id)){?>
								<input type="hidden" name="id" value="<?=$menu->id?>">
								<button type="submit" class="btn btn-primary">Bearbeiten</button>
							<?php } else { ?>
								<button type="submit" class="btn btn-primary">Speichern</button>
							<?php } ?>
						</footer>
					</form>
				</div>
			</section>
		</div>
		<div class="col-xl-6">
			<section class="card card-yellow">
				<header class="card-header">
					<?php if (!empty($menu->id)){?>
						<input type="hidden" name="id" value="<?=$menu->id?>">
						<h3 class="card-title">MENU-liste| Edit</h3>
					<?php } else { ?>
						<h3 class="card-title">MENU-liste </h3>
					<?php } ?>
					<p class="card-subtitle">Liste aller Menüelemente: <?=count($menus).' | und dazu parrent: '.count($menuparent)?></p>
				</header>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
							<thead>
							<tr>
								<th>#</th>
								<th>Sprache</th>
								<th>Menü</th>
								<?php if ($showParentColumn) { ?>
									<th>Übergeordnet</th>
								<?php } ?>
								<th>URL</th>
								<th>Befehl</th>
								<th>Aktiv</th>
								<th></th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							<?php if (count($menus) == 0) { ?>
								<tr>
									<td colspan="<?php echo $showParentColumn ? '9' : '8'; ?>" class="text-center"><h5>Keine data</h5></td>
								</tr>
							<?php } else {
								$k = 0;
								foreach ($menus as $m) {
									$k++;
									?>
									<tr>
										<td class="text-center" title="<?=$m->id?>"><?=$k?></td>
										<?php if (count(getLanguages()) > 1){ ?>
											<td class="text-center"><img src="<?=langInfo($m->lang)['flag']?>" width="20px" alt=""></td>
										<?php } ?>
										<td><?php echo ($m->parent == 0 ? '<strong>' . $m->name . '</strong>' : ' - ' . $m->name); ?></td>
										<?php if ($showParentColumn) { ?>
											<td class="text-center"><?php echo ($m->parent == 0 ? '' : $m->parentName); ?></td>
										<?php } ?>
										<td class="text-center">
                    <span title="<?php echo $m->url; ?>">
                        <?php echo substr($m->url, 0, 10); ?>
                    </span>
										</td>
										<td class="text-center"><?php echo $m->orderBy; ?></td>
										<td class="text-center"><?= active($m->active); ?></td>
										<td data-title="Editovať" class="text-center"><a href="<?=BASE_URL.'admin/menu/edit/'.$m->id?>"><i style="color: green" class="fa fa-edit"></i></a></td>
										<td data-title="Zmazať" class="text-center"><a href="<?=BASE_URL.'admin/menu/del/'.$m->id?>" onclick="return confirm('Ste si istý/(á), že to chcete zmazať?!?')"><i style="color: red" class="fa fa-trash"></i></a></td>
									</tr>
									<?php
									if (isset($m->submenu)) {
										foreach ($m->submenu as $s) {
											?>
											<tr>
												<td class="text-center" title="<?=$s->id?>"><?=$k?></td>
												<?php if (count(getLanguages()) > 1){ ?>
													<td class="text-center"><img src="<?=langInfo($s->lang)['flag']?>" width="20px" alt=""></td>
												<?php } ?>
												<td><?php echo ($s->parent == 0 ? '<strong>' . $s->name . '</strong>' : ' - ' . $s->name); ?></td>
												<?php if ($showParentColumn) { ?>
													<td class="text-center"><?php echo ($s->parent == 0 ? '' : $s->parentName); ?></td>
												<?php } ?>
												<td class="text-center">
                            <span title="<?php echo $s->url; ?>">
                                <?php echo substr($s->url, 0, 10); ?>
                            </span>
												</td>
												<td class="text-center"><?php echo $s->orderBy; ?></td>
												<td class="text-center"><?= active($s->active); ?></td>
												<td data-title="Editovať" class="text-center"><a href="<?=BASE_URL.'admin/menu/edit/'.$s->id?>"><i style="color: green" class="fa fa-edit"></i></a></td>
												<td data-title="Zmazať" class="text-center"><a href="<?=BASE_URL.'admin/menu/del/'.$s->id?>" onclick="return confirm('Ste si istý/(á), že to chcete zmazať?!?')"><i style="color: red" class="fa fa-trash"></i></a></td>
											</tr>
											<?php
										}
									}
								}
							} ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script>
	$("#form").validate({
		focusInvalid: false,
		invalidHandler: function() {
			$(this).find(":input.error:first").focus();
		}
	});

	document.addEventListener('submit', function(event) {
		var menuSelect = document.getElementById('inputDefaultMenu');
		if (!menuSelect.value) {
			menuSelect.value = '0';
		}
	});
</script>
