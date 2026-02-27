<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_quality">
	<div class="row justify-content-center">
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
					<!-- Generic Progress Indicator Bar and Labels for Quality Assessment -->
					<div class="progress-indicator-container mb-4">
						<div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
							<h6 class="mb-0 fw-bold">Progress Quality Assessment</h6>
							<div class="d-flex gap-2 flex-wrap">
								<span class="badge rounded-pill progress-indicator-badge-acc"><i class="fas fa-check me-1"></i>Accepted: <span id="count_acc_qa"><?= $count_papers_qa[1] ?></span></span>
								<span class="badge rounded-pill progress-indicator-badge-rej"><i class="fas fa-times me-1"></i>Rejected: <span id="count_rej_qa"><?= $count_papers_qa[2] ?></span></span>
								<span class="badge rounded-pill progress-indicator-badge-unc"><i class="fas fa-question me-1"></i>Unclassified: <span id="count_unc_qa"><?= $count_papers_qa[3] ?></span></span>
								<span class="badge rounded-pill progress-indicator-badge-rem"><i class="fas fa-trash-alt me-1"></i>Removed: <span id="count_rem_qa"><?= $count_papers_qa[4] ?></span></span>
								<span class="badge rounded-pill progress-indicator-badge-total"><i class="fas fa-bars me-1"></i>Total: <span id="count_total_qa"><?= $count_papers_qa[5] ?></span></span>
							</div>
						</div>
						<div class="progress progress-indicator-bar" style="height: 1.5rem;">
							<div id="prog_acc_qa" class="progress-bar progress-indicator-bar-acc" role="progressbar"
								style="width: <?= $acc ?>%"
								aria-valuenow="<?= $acc ?>"
								aria-valuemin="0"
								aria-valuemax="100">
								<?= $acc ?>%
							</div>
							<div id="prog_rej_qa" class="progress-bar progress-indicator-bar-rej" role="progressbar"
								style="width: <?= $rej ?>%"
								aria-valuenow="<?= $rej ?>"
								aria-valuemin="0"
								aria-valuemax="100">
								<?= $rej ?>%
							</div>
							<div id="prog_unc_qa" class="progress-bar progress-indicator-bar-unc" role="progressbar"
								style="width: <?= $unc ?>%"
								aria-valuenow="<?= $unc ?>"
								aria-valuemin="0"
								aria-valuemax="100">
								<?= $unc ?>%
							</div>
							<div id="prog_rem_qa" class="progress-bar progress-indicator-bar-rem" role="progressbar"
								style="width: <?= $rem ?>%"
								aria-valuenow="<?= $rem ?>"
								aria-valuemin="0"
								aria-valuemax="100">
								<?= $rem ?>%
							</div>
						</div>
					</div>
					<div class="table-responsive mt-4">
						<table class="table table-bordered table-hover align-middle" id="table_papers_quality">
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
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_selection" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_extraction" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
	<?php $this->load->view('modal/modal_paper_qa'); ?>
</div>
<script src="<?= base_url('assets/js/quality_assessment.js'); ?>"></script>