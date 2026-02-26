

<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_selection">
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-10 mb-4">
			<div class="card shadow-sm h-100 bg-light">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="id_qa" class="mb-0"><strong>Study Selection</strong></label>
						<a onclick="modal_help('modal_help_selection')" class="ms-auto opt" tabindex="0" aria-label="Help about study selection" data-bs-toggle="tooltip" title="How to select studies?"><i class="fas fa-question-circle"></i></a>
					</div>
					<?php
					if ($project->get_planning() == 100 && $project->get_import() == 100) {
						$acc = number_format((float)($count_papers[1] * 100) / $count_papers[6], 2);
						$rej = number_format((float)($count_papers[2] * 100) / $count_papers[6], 2);
						$unc = number_format((float)($count_papers[3] * 100) / $count_papers[6], 2);
						$dup = number_format((float)($count_papers[4] * 100) / $count_papers[6], 2);
						$rem = number_format((float)($count_papers[5] * 100) / $count_papers[6], 2);
						?>
						<h6 class="mt-4">Progress Study Selection</h6>
						<div class="progress mb-3">
							<div id="prog_acc" class="progress-bar bg-success" role="progressbar"
								 style="width: <?= $acc ?>%"
								 aria-valuenow="<?= $acc ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $acc ?>%
							</div>
							<div id="prog_rej" class="progress-bar bg-danger" role="progressbar"
								 style="width: <?= $rej ?>%"
								 aria-valuenow="<?= $rej ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $rej ?>%
							</div>
							<div id="prog_unc" class="progress-bar bg-dark" role="progressbar"
								 style="width: <?= $unc ?>%"
								 aria-valuenow="<?= $unc ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $unc ?>%
							</div>
							<div id="prog_dup" class="progress-bar bg-warning" role="progressbar"
								 style="width: <?= $dup ?>%"
								 aria-valuenow="<?= $dup ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $dup ?>%
							</div>
							<div id="prog_rem" class="progress-bar bg-info" role="progressbar"
								 style="width: <?= $rem ?>%"
								 aria-valuenow="<?= $rem ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $rem ?>%
							</div>
						</div>
						<div class="row mb-4">
							<?php
							foreach ($count_papers as $key => $value) {
								switch ($key) {
									case 1:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-success text-white"><i class="fas fa-check fa-lg"></i></span>
												<label class="form-label ms-2">Accepted: <span id="count_acc"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 2:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-danger text-white"><i class="fas fa-times fa-lg"></i></span>
												<label class="form-label ms-2">Rejected: <span id="count_rej"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 3:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-dark text-white"><i class="fas fa-question fa-lg"></i></span>
												<label class="form-label ms-2">Unclassified: <span id="count_unc"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 4:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-warning text-dark"><i class="fas fa-copy fa-lg"></i></span>
												<label class="form-label ms-2">Duplicate: <span id="count_dup"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 5:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-info text-white"><i class="fas fa-trash-alt fa-lg"></i></span>
												<label class="form-label ms-2">Removed: <span id="count_rem"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 6:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-secondary text-white"><i class="fas fa-bars fa-lg"></i></span>
												<label class="form-label ms-2">Total: <span id="count_total"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
								}
							}
							?>
						</div>
						<div class="table-responsive mt-4">
							<table class="table table-hover align-middle" id="table_papers">
								<caption class="visually-hidden">List of Papers Imported</caption>
								<thead class="table-light">
								<tr>
									<th>ID</th>
									<th>Title</th>
									<?php foreach ($project->get_inclusion_criteria() as $ic) { ?>
										<th><?= $ic->get_id() ?></th>
									<?php } ?>
									<?php foreach ($project->get_exclusion_criteria() as $ec) { ?>
										<th><?= $ec->get_id() ?></th>
									<?php } ?>
									<th>Database</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($project->get_papers() as $paper) { ?>
									<tr>
										<td><?= $paper->get_id(); ?></td>
										<td><?= $paper->get_title(); ?></td>
										<?php
										$cs = $criterias[$paper->get_id()];
										foreach ($project->get_inclusion_criteria() as $ic) { ?>
											<td><?= $cs[$ic->get_id()] =="True"?"<i class=\"fas fa-check text-success\"></i> True":"<i class=\"fas fa-times text-danger\"></i> False" ?></td>
										<?php } ?>
										<?php foreach ($project->get_exclusion_criteria() as $ec) { ?>
											<td><?= $cs[$ec->get_id()] =="True"?"<i class=\"fas fa-check text-success\"></i> True":"<i class=\"fas fa-times text-danger\"></i> False" ?></td>
										<?php } ?>
										<td><?= $paper->get_database(); ?></td>
										<?php
										$class = "text-dark";
										$status = "Unclassified";
										switch ($paper->get_status_selection()) {
											case 1:
												$class = "text-success";
												$status = "Accepted";
												break;
											case 2:
												$class = "text-danger";
												$status = "Rejected";
												break;
											case 4:
												$class = "text-warning";
												$status = "Duplicate";
												break;
											case 5:
												$class = "text-info";
												$status = "Removed";
												break;
										} ?>
										<td id="<?= $paper->get_id(); ?>" class="font-weight-bold <?= $class ?>"><?= $status ?></td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot class="table-light">
								<tr>
									<th>ID</th>
									<th>Title</th>
									<?php foreach ($project->get_inclusion_criteria() as $ic) { ?>
										<th><?= $ic->get_id() ?></th>
									<?php } ?>
									<?php foreach ($project->get_exclusion_criteria() as $ec) { ?>
										<th><?= $ec->get_id() ?></th>
									<?php } ?>
									<th>Database</th>
									<th>Status</th>
								</tr>
								</tfoot>
							</table>
						</div>
						<?php
					} else {
						?>
						<div class="alert alert-warning container-fluid alert-dismissible fade show mt-4" role="alert">
							<h5>Complete these tasks to advance</h5>
							<ul>
								<?php
								foreach ($project->get_errors() as $error) {
									?>
									<li><?= $error ?></li>
									<?php
								}
								?>
							</ul>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_import" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_quality" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
	<?php $this->load->view('modal/modal_paper_selection'); ?>
</div>
