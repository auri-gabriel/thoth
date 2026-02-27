<section class="dashboard-section py-5">
	<div class="container">
		<div class="card shadow-sm mb-4">
			<div class="card-header d-flex justify-content-between align-items-center">
				<div>
					<h1 class="fw-bold mb-0">Search Results for <span class="text-primary"><?= $search; ?></span></h1>
					<small class="text-muted">Projects matching your search criteria</small>
				</div>
			</div>
			<div class="card-body bg-light">
				<div class="row">
					<div class="col-12 col-lg-12">
						<div class="card shadow-sm mb-4">
							<div class="card-header d-flex justify-content-between align-items-center">
								<h4 class="fw-bold mb-0">Projects</h4>
								<div class="input-group w-auto">
									<input type="text" class="form-control" placeholder="Search projects..." id="project-search">
									<span class="input-group-text"><span class="fas fa-search"></span></span>
								</div>
							</div>
							<div class="card-body p-0">
								<table class="table table-hover align-middle mb-0" id="projects-table">
									<thead class="table-light">
										<tr>
											<th>Title</th>
											<th>Owner</th>
											<th>Status</th>
											<th>Created</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($projects as $project) { ?>
											<tr>
												<td>
													<a href="<?= site_url('projects/' . $project['project']->get_id()); ?>" class="fw-semibold text-primary">
														<?= htmlspecialchars($project['project']->get_title()); ?>
													</a>
												</td>
												<td>
													<span class="badge bg-secondary">
														<?= htmlspecialchars($project['project']->get_created_by()); ?>
													</span>
												</td>
												<td>
													<!-- Replace with actual status if available -->
													<span class="badge bg-success">Active</span>
												</td>
												<td>
													<span class="text-muted">
														<?= htmlspecialchars($project['project']->get_start_date()); ?>
													</span>
												</td>
												<td>
													<div class="d-flex flex-wrap gap-2">
														<?php if (!is_null($project['level'])) { ?>
															<a href="<?= site_url('projects/' . $project['project']->get_id()); ?>" class="btn btn-outline-success btn-sm" title="Open">
																<span class="fas fa-folder-open"></span>
															</a>
														<?php } else { ?>
															<a href="#" class="btn btn-outline-secondary btn-sm" title="Viewer">
																<span class="fas fa-eye"></span>
															</a>
														<?php }
														if ($project['level'] == 1) { ?>
															<a href="<?= site_url('projects/' . $project['project']->get_id() . '/edit'); ?>" class="btn btn-outline-warning btn-sm" title="Edit">
																<span class="fas fa-edit"></span>
															</a>
															<a href="<?= site_url('projects/' . $project['project']->get_id() . '/add-member'); ?>" class="btn btn-outline-info btn-sm" title="Add Member">
																<span class="fas fa-users-cog"></span>
															</a>
															<button type="button"
																onclick="delete_project(<?= $project['project']->get_id() ?>,$(this).closest('tr'))"
																class="btn btn-outline-danger btn-sm" title="Delete">
																<span class="fas fa-trash-alt"></span>
															</button>
														<?php } ?>
													</div>
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
	</div>
</section>
