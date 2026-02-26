<section class="search-results-section py-4">
	<div class="container">
		<div class="row mb-4">
			<div class="col-12 text-center">
				<h2 class="fw-bold">Search Results for <span class="text-primary"><?= $search; ?></span></h2>
				<hr class="my-3">
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="card shadow-sm">
				<div class="card-body p-0">
					<table class="table table-hover mb-0">
						<thead class="table-light">
							<tr>
								<th>Title</th>
								<th>Created By</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($projects as $project) { ?>
								<tr>
									<td class="align-middle">
										<span class="fw-semibold text-dark">
											<?= htmlspecialchars($project['project']->get_title()); ?>
										</span>
									</td>
									<td class="align-middle">
										<span class="badge bg-secondary">
											<?= htmlspecialchars($project['project']->get_created_by()); ?>
										</span>
									</td>
									<td class="align-middle">
										<div class="d-flex flex-wrap gap-2">
											<?php if (!is_null($project['level'])) { ?>
												<a href="<?= base_url('open/' . $project['project']->get_id()); ?>" class="btn btn-success btn-sm">
													<span class="fas fa-folder-open"></span> Open
												</a>
											<?php } else { ?>
												<a href="#" class="btn btn-outline-secondary btn-sm">
													<span class="fas fa-eye"></span> Viewer
												</a>
											<?php }
											if ($project['level'] == 1) { ?>
												<a href="<?= base_url('edit/' . $project['project']->get_id()); ?>" class="btn btn-warning btn-sm">
													<span class="fas fa-edit"></span> Edit
												</a>
												<a href="<?= base_url('add_research/' . $project['project']->get_id()); ?>" class="btn btn-info btn-sm">
													<span class="fas fa-users-cog"></span> Add
												</a>
												<button type="button"
													onclick="delete_project(<?= $project['project']->get_id() ?>,$(this).closest('tr'))"
													class="btn btn-danger btn-sm">
													<span class="fas fa-trash-alt"></span> Delete
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
</section>