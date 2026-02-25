


<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_quality">
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-10 mb-4">
			<div class="card shadow-sm h-100 bg-light">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label class="mb-0"><strong>Quality Assessment</strong></label>
						<a onclick="modal_help('modal_help_quality')" class="ms-auto opt" tabindex="0" aria-label="Help about quality assessment" data-bs-toggle="tooltip" title="How to assess quality?"><i class="fas fa-question-circle"></i></a>
					</div>
					<?php
					if ($project_quality->get_planning() == 100 && $project_quality->get_import() == 100 && $project_quality->get_selection() > 0) {
						$acc = number_format((float)($count_papers_qa[1] * 100) / $count_papers_qa[5], 2);
						$rej = number_format((float)($count_papers_qa[2] * 100) / $count_papers_qa[5], 2);
						$unc = number_format((float)($count_papers_qa[3] * 100) / $count_papers_qa[5], 2);
						$rem = number_format((float)($count_papers_qa[4] * 100) / $count_papers_qa[5], 2);
						?>
						<h6 class="mt-4">Progress Quality Assessment</h6>
						<div class="progress mb-3">
							<div id="prog_acc_qa" class="progress-bar bg-success" role="progressbar"
								 style="width: <?= $acc ?>%"
								 aria-valuenow="<?= $acc ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $acc ?>%
							</div>
							<div id="prog_rej_qa" class="progress-bar bg-danger" role="progressbar"
								 style="width: <?= $rej ?>%"
								 aria-valuenow="<?= $rej ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $rej ?>%
							</div>
							<div id="prog_unc_qa" class="progress-bar bg-dark" role="progressbar"
								 style="width: <?= $unc ?>%"
								 aria-valuenow="<?= $unc ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $unc ?>%
							</div>
							<div id="prog_rem_qa" class="progress-bar bg-info" role="progressbar"
								 style="width: <?= $rem ?>%"
								 aria-valuenow="<?= $rem ?>"
								 aria-valuemin="0"
								 aria-valuemax="100"><?= $rem ?>%
							</div>
						</div>
						<div class="row mb-4">
							<?php
							foreach ($count_papers_qa as $key => $value) {
								switch ($key) {
									case 1:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-success text-white"><i class="fas fa-check fa-lg"></i></span>
												<label class="form-label ms-2">Accepted: <span id="count_acc_qa"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 2:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-danger text-white"><i class="fas fa-times fa-lg"></i></span>
												<label class="form-label ms-2">Rejected: <span id="count_rej_qa"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 3:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-dark text-white"><i class="fas fa-question fa-lg"></i></span>
												<label class="form-label ms-2">Unclassified: <span id="count_unc_qa"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 4:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-info text-white"><i class="fas fa-trash-alt fa-lg"></i></span>
												<label class="form-label ms-2">Removed: <span id="count_rem_qa"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
									case 5:
										?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-secondary text-white"><i class="fas fa-bars fa-lg"></i></span>
												<label class="form-label ms-2">Total: <span id="count_total_qa"><?= $value ?></span></label>
											</div>
										</div>
										<?php
										break;
								}
							}
							?>
						</div>
						<div class="table-responsive mt-4">
							<table class="table table-hover align-middle" id="table_papers_quality">
								<caption class="visually-hidden">List of Papers for Quality Assessment</caption>
								<thead class="table-light">
								<tr>
									<th>ID</th>
									<th>Title</th>
									<?php foreach ($project_quality->get_questions_quality() as $qa) { ?>
										<th><?= $qa->get_id() ?></th>
									<?php } ?>
									<th>General Score</th>
									<th>Score</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($project_quality->get_papers() as $paper) { ?>
									<tr>
										<td><?= $paper->get_id() ?></td>
										<td><?= $paper->get_title() ?></td>
										<?php
										$qas = $qas_score[$paper->get_id()];
										foreach ($project_quality->get_questions_quality() as $qa) { ?>
											<td><?= $qas[$qa->get_id()] ?></td>
										<?php } ?>
										<td><?= $paper->get_rule_quality() ?></td>
										<td><?= $paper->get_score() ?></td>
										<?php
										$class = "text-dark";
										$status = "Unclassified";
										switch ($paper->get_status_quality()) {
											case 1:
												$class = "text-success";
												$status = "Accepted";
												break;
											case 2:
												$class = "text-danger";
												$status = "Rejected";
												break;
											case 4:
												$class = "text-info";
												$status = "Removed";
												break;
										}
										?>
										<td id="<?= $paper->get_id(); ?>" class="font-weight-bold <?= $class ?>"><?= $status ?></td>
									</tr>
								<?php } ?>
								</tbody>
								<tfoot class="table-light">
								<tr>
									<th>ID</th>
									<th>Title</th>
									<?php foreach ($project_quality->get_questions_quality() as $qa) { ?>
										<th><?= $qa->get_id() ?></th>
									<?php } ?>
									<th>General Score</th>
									<th>Score</th>
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
								foreach ($project_quality->get_errors() as $error) {
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
		<a href="#tab_selection" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_extraction" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
	<?php $this->load->view('modal/modal_paper_qa'); ?>
</div>
