<input type="hidden" id="id_project" value="<?= $project->get_id(); ?>">
<section class="add-member-section py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<div class="card shadow-sm border-0 mb-4">
					<div class="card-header bg-white text-center">
						<h2 class="fw-bold mb-0"><i class="fas fa-users"></i> Members at <?= $project->get_title() ?></h2>
					</div>
					<div class="card-body p-4">
						<div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
							<h5 class="mb-1">Comments</h5>
							<p class="mb-0">Adding a member, editing its role and deleting it after starting the project can lead to problems.</p>
						</div>
						<form class="mb-4">
							<h5 class="fw-bold mb-3"><i class="fas fa-user-plus text-success"></i> Add Member</h5>
							<div class="mb-3">
								<label for="add_email_user" class="form-label">E-mail</label>
								<select id="add_email_user" class="form-select" required>
									<option value=""></option>
									<?php foreach ($users as $user) { ?>
										<option value="<?= $user->get_email() ?>"><?= $user->get_email() ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="mb-3">
								<label for="add_level_user" class="form-label">Level</label>
								<select id="add_level_user" class="form-select" required>
									<option value=""></option>
									<?php foreach ($levels as $level) {
										if ($level != "Administrator") {
									?>
											<option value="<?= $level ?>"><?= $level ?></option>
									<?php }
									} ?>
								</select>
							</div>
							<div class="d-grid gap-2">
								<button class="btn btn-success btn-lg" type="button" onclick="add_research()">
									<span class="fas fa-plus"></span> Add
								</button>
							</div>
						</form>
						<h5 class="fw-bold mb-3"><i class="fas fa-users text-info"></i> Members</h5>
						<div class="table-responsive">
							<table id="table_members" class="table table-hover align-middle">
								<caption class="visually-hidden">List of members</caption>
								<thead class="table-light">
									<tr>
										<th scope="col">Name</th>
										<th scope="col">Email</th>
										<th scope="col">Level</th>
										<th scope="col">Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($project->get_members() as $mem) { ?>
										<tr>
											<td><?= $mem->get_name(); ?></td>
											<td><?= $mem->get_email(); ?></td>
											<td>
												<?php
												if ($mem->get_level() != "Administrator") {
												?>
													<select class="form-select" onchange="edit_level(this)">
														<?php
														foreach ($levels as $level) {
															if ($level != "Administrator") {
																$selected = "";
																if ($level == $mem->get_level()) {
																	$selected = "selected";
																}
														?>
																<option <?= $selected ?> value="<?= $level ?>"><?= $level ?></option>
														<?php }
														} ?>
													</select>
												<?php } else {
													echo $mem->get_level();
												} ?>
											</td>
											<td>
												<?php
												if ($mem->get_level() != "Administrator") {
												?>
													<button class="btn btn-danger btn-sm" title="Delete member"
														onClick="delete_member($(this).parents('tr'))">
														<span class="far fa-trash-alt"></span>
													</button>
												<?php
												}
												?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>