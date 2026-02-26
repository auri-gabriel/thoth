<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_extraction">
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-10 mb-4">
			<div class="card shadow-sm h-100 bg-light">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label class="mb-0"><strong>Data Extraction</strong></label>
						<a onclick="modal_help('modal_help_data_extraction')" class="ms-auto opt" tabindex="0" aria-label="Help about data extraction" data-bs-toggle="tooltip" title="What is data extraction?"><i class="fas fa-question-circle"></i></a>
					</div>
					<?php
					if ($project->get_planning() == 100 && $project->get_import() == 100 && $project->get_selection() > 0 && $project->get_quality() > 0) {
						if (!empty($count_papers[4]) && $count_papers[4] != 0) {
							$done = number_format((float)($count_papers[1] * 100) / $count_papers[4], 2);
							$to_do = number_format((float)($count_papers[2] * 100) / $count_papers[4], 2);
							$rem = number_format((float)($count_papers[3] * 100) / $count_papers[4], 2);
						} else {
							$done = $to_do = $rem = 0;
						}
					?>
						<h6 class="mt-4">Progress Data Extraction</h6>
						<div class="progress mb-3">
							<div id="prog_done" class="progress-bar bg-success" role="progressbar"
								style="width: <?= $done ?>%"
								aria-valuenow="<?= $done ?>"
								aria-valuemin="0"
								aria-valuemax="100"><?= $done ?>%
							</div>
							<div id="prog_to_do" class="progress-bar bg-dark" role="progressbar"
								style="width: <?= $to_do ?>%"
								aria-valuenow="<?= $to_do ?>"
								aria-valuemin="0"
								aria-valuemax="100"><?= $to_do ?>%
							</div>
							<div id="prog_rem_ex" class="progress-bar bg-info" role="progressbar"
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
												<label class="form-label ms-2">Done: <span id="count_done"><?= $value ?></span></label>
											</div>
										</div>
									<?php
										break;
									case 2:
									?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-dark text-white"><i class="fas fa-times fa-lg"></i></span>
												<label class="form-label ms-2">To Do: <span id="count_to_do"><?= $value ?></span></label>
											</div>
										</div>
									<?php
										break;
									case 3:
									?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-info text-white"><i class="fas fa-trash-alt fa-lg"></i></span>
												<label class="form-label ms-2">Removed: <span id="count_rem_ex"><?= $value ?></span></label>
											</div>
										</div>
									<?php
										break;
									case 4:
									?>
										<div class="col-md-2">
											<div class="input-group">
												<span class="input-group-text bg-secondary text-white"><i class="fas fa-bars fa-lg"></i></span>
												<label class="form-label ms-2">Total: <span id="count_total_ex"><?= $value ?></span></label>
											</div>
										</div>
							<?php
										break;
								}
							}
							?>
						</div>
						<div class="table-responsive mt-4">
							<table class="table table-hover align-middle" id="table_papers_extraction">
								<caption class="visually-hidden">List of Papers for Data Extraction</caption>
								<thead class="table-light">
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Author</th>
										<th>Year</th>
										<th>Database</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($project->get_papers() as $paper) { ?>
										<tr>
											<td><?= $paper->get_id() ?></td>
											<td><?= $paper->get_title() ?></td>
											<td><?= $paper->get_author() ?></td>
											<td><?= $paper->get_year() ?></td>
											<td><?= $paper->get_database() ?></td>
											<?php
											$class = "text-dark";
											$status = "To Do";
											switch ($paper->get_status_extraction()) {
												case 1:
													$class = "text-success";
													$status = "Done";
													break;
												case 3:
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
										<th>Author</th>
										<th>Year</th>
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
		<a href="#tab_quality" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_import" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
	<?php $this->load->view('modal/modal_paper_extraction'); ?>
</div>
<script src="<?= base_url('assets/js/data_extraction.js'); ?>"></script>
