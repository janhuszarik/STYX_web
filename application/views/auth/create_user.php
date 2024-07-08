<?php echo $message; ?>

<?php echo form_open("auth/register");?>
	<div class="input-group mb-3">
		<input type="text" name="first_name" class="form-control" placeholder="Vorname">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-user-alt"></span>
			</div>
		</div>
	</div>
	<div class="input-group mb-3">
		<input type="text" name="last_name" class="form-control" placeholder="Nachname">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-user-alt"></span>
			</div>
		</div>
	</div>

	<div class="input-group mb-3">
		<input type="text" name="email" class="form-control" placeholder="Email">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-envelope"></span>
			</div>
		</div>
	</div>

	<div class="input-group mb-3">
		<input type="text" name="phone" class="form-control" placeholder="Kontakt">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-phone"></span>
			</div>
		</div>
	</div>

	<div class="input-group mb-3">
		<input type="password" name="password" class="form-control" placeholder="Passwort">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-lock"></span>
			</div>
		</div>
	</div>
	<div class="input-group mb-3">
		<input type="password" name="password_confirm" class="form-control" placeholder="Passwort wiederholen">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-lock"></span>
			</div>
		</div>
	</div>
	<hr>
	<input style="width: 100%" type="submit" id="submit" class="btn btn-success" value="Registrieren">

<?php echo form_close();?>
