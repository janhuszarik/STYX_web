<div class="container mx-auto px-4 py-8">
	<div class="row">
		<div class="col-lg-12">
			<section class="card card-yellow shadow-sm">
				<header class="card-header d-flex justify-content-between align-items-center px-4 py-3">
					<div>
						<h3 class="card-title mb-0"><?php echo lang('index_heading');?></h3>
						<p class="card-subtitle text-gray-600"><?php echo lang('index_subheading');?></p>
					</div>
					<div>
						<a href="<?php echo site_url('auth/create_user');?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Neue Benutzer erstellen!</a>
					</div>
				</header>
				<div class="card-body p-4">
					<div class="table-responsive">
						<table class="table table-hover table-bordered mb-0">
							<thead>
							<tr>
								<th class="text-center"><?php echo lang('index_fname_th');?></th>
								<th class="text-center"><?php echo lang('index_lname_th');?></th>
								<th class="text-center"><?php echo lang('index_email_th');?></th>
								<th class="text-center"><?php echo lang('index_groups_th');?></th>
								<th class="text-center"><?php echo lang('index_status_th');?></th>
								<th class="text-center"><?php echo lang('index_action_th');?></th>
							</tr>
							</thead>
							<tbody>
							<?php if (!empty($users)): ?>
								<?php foreach ($users as $user): ?>
									<tr>
										<td class="text-center"><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8');?></td>
										<td class="text-center"><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8');?></td>
										<td class="text-center"><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8');?></td>
										<td class="text-center">
											<?php foreach ($user->groups as $group): ?>
												<a href="<?php echo site_url('auth/edit_group/'.$group->id);?>" class="text-blue-600 hover:underline block"><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8');?></a>
											<?php endforeach; ?>
										</td>
										<td class="text-center">
											<?php echo ($user->active) ?
												'<a href="'.site_url('auth/deactivate/'.$user->id).'" class="text-green-600 hover:text-green-800">'.lang('index_active_link').'</a>' :
												'<a href="'.site_url('auth/activate/'.$user->id).'" class="text-red-600 hover:text-red-800">'.lang('index_inactive_link').'</a>';?>
										</td>
										<td class="text-center">
											<a href="<?php echo site_url('auth/edit_user/'.$user->id);?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
											<a href="<?php echo site_url('auth/delete_user/'.$user->id);?>" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich Löschen?')"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="6" class="text-center">Žiadni používatelia nenájdení.</td></tr>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script>
	document.getElementById('searchInput').addEventListener('keyup', function () {
		const filter = this.value.toLowerCase();
		const rows = document.querySelectorAll('table tbody tr');
		rows.forEach(row => {
			row.style.display = [...row.cells].some(cell =>
				cell.textContent.toLowerCase().includes(filter)
			) ? '' : 'none';
		});
	});
</script>
