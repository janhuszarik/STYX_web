<div class="container mx-auto px-4 py-8">
	<div class="row">
		<div class="col-lg-12">
			<section class="card">
				<header class="card-header px-4 py-3">
					<h2 class="card-title"><?php echo lang('edit_user_heading');?></h2>
					<p class="card-subtitle"><?php echo lang('edit_user_subheading');?></p>
				</header>
				<div class="card-body p-4">
					<?php echo form_open(uri_string(), ['class' => 'form']); ?>
					<?php echo form_hidden('id', $user->id); ?>
					<?php echo form_hidden($csrf); ?>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_fname_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Vorname des Benutzers, der im System angezeigt wird."></i>
							</label>
							<?php echo form_input($first_name, '', ['class' => 'form-control']); ?>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_lname_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Nachname des Benutzers, der im System angezeigt wird."></i>
							</label>
							<?php echo form_input($last_name, '', ['class' => 'form-control']); ?>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_email_label', 'email'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="E-Mail-Adresse des Benutzers, die für Anmeldung und Kommunikation verwendet wird."></i>
							</label>
							<?php echo form_input(['name' => 'email', 'id' => 'email', 'type' => 'email', 'value' => set_value('email', $user->email), 'class' => 'form-control']); ?>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_company_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Name des Unternehmens, zu dem der Benutzer gehört (optional)."></i>
							</label>
							<?php echo form_input($company, '', ['class' => 'form-control']); ?>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_phone_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Telefonnummer des Benutzers (optional)."></i>
							</label>
							<?php echo form_input($phone, '', ['class' => 'form-control']); ?>
						</div>
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_password_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Neues Passwort (leer lassen, wenn Sie es nicht ändern möchten)."></i>
							</label>
							<?php echo form_input($password, '', ['class' => 'form-control', 'autocomplete' => 'off']); ?>
						</div>
					</div>

					<div class="row form-group pb-3">
						<div class="col-lg-6">
							<label class="col-form-label"><?php echo lang('edit_user_password_confirm_label'); ?>
								<i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Bestätigung des neuen Passworts (leer lassen, wenn Sie es nicht ändern möchten)."></i>
							</label>
							<?php echo form_input($password_confirm, '', ['class' => 'form-control', 'autocomplete' => 'off']); ?>
						</div>
						<div class="col-lg-6"></div>
					</div>

					<?php if ($this->ion_auth->is_admin()): ?>
						<div class="form-group pb-3">
							<h3 class="mb-3"><?php echo lang('edit_user_groups_heading'); ?></h3>
							<div class="row">
								<?php foreach ($groups as $group): ?>
									<div class="col-lg-4">
										<label class="checkbox-label">
											<input type="checkbox" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo (in_array($group, $currentGroups)) ? 'checked="checked"' : ''; ?>>
											<span class="ms-2"><?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?></span>
										</label>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					<footer class="card-footer text-end">
						<?php echo form_submit('submit', lang('edit_user_submit_btn'), ['class' => 'btn btn-primary']); ?>
						<a href="<?php echo site_url('auth'); ?>" class="btn btn-secondary">Zurück</a>
					</footer>
					<?php echo form_close(); ?>
				</div>
			</section>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
	// Initialize Bootstrap tooltips
	document.addEventListener('DOMContentLoaded', function () {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		tooltipTriggerList.map(function (tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});
	});
</script>
