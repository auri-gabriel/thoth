<div class="container py-4">
	<div class="card shadow-sm mb-4">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'overview']); ?>
		<div class="card-body bg-light">

			<div class="row g-4 mb-4">
				<div class="col-md-4">
					<div class="card shadow-sm h-100 border-0">
						<div class="card-body bg-white rounded-3">
							<div class="d-flex align-items-center mb-2">
								<div class="me-2 text-primary"><i class="fas fa-align-justify fa-lg"></i></div>
								<h5 class="fw-bold mb-0">Description</h5>
							</div>
							<p class="mb-0 text-secondary small"><?= $project->get_description(); ?></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card shadow-sm h-100 border-0">
						<div class="card-body bg-white rounded-3">
							<div class="d-flex align-items-center mb-2">
								<div class="me-2 text-success"><i class="fas fa-bullseye fa-lg"></i></div>
								<h5 class="fw-bold mb-0">Objectives</h5>
							</div>
							<p class="mb-0 text-secondary small"><?= $project->get_objectives(); ?></p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card shadow-sm h-100 border-0">
						<div class="card-body bg-white rounded-3">
							<div class="d-flex align-items-center mb-2">
								<div class="me-2 text-info"><i class="fas fa-users fa-lg"></i></div>
								<h5 class="fw-bold mb-0">Members</h5>
							</div>
							<ul class="list-unstyled mb-0">
								<?php foreach ($project->get_members() as $member) { ?>
									<li class="mb-1"><span class="fw-semibold text-dark"><?= $member->get_name() ?></span> <span class="badge bg-light text-secondary border ms-1"><?= $member->get_level(); ?></span></li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-md-6">
					<div class="p-3 bg-white rounded shadow-sm h-100">
						<h5 class="fw-bold mb-3"><i class="fas fa-tasks opt me-2"></i>Progress of Systematic Review</h5>
						<div class="mb-3">
							<label class="fw-semibold">Planning</label>
							<div class="progress mb-2" style="height: 22px;">
								<div class="progress-bar bg-success fw-bold" role="progressbar" style="width: <?= $project->get_planning() ?>%" aria-valuenow="<?= $project->get_planning() ?>" aria-valuemin="0" aria-valuemax="100">
									<?= $project->get_planning() ?>%
								</div>
							</div>
							<label class="fw-semibold">Import Studies</label>
							<div class="progress mb-2" style="height: 22px;">
								<div class="progress-bar bg-info fw-bold" role="progressbar" style="width: <?= $project->get_import() ?>%" aria-valuenow="<?= $project->get_import() ?>" aria-valuemin="0" aria-valuemax="100">
									<?= $project->get_import() ?>%
								</div>
							</div>
							<label class="fw-semibold">Study Selection</label>
							<div class="progress mb-2" style="height: 22px;">
								<div class="progress-bar bg-warning fw-bold" role="progressbar" style="width: <?= $project->get_selection() ?>%" aria-valuenow="<?= $project->get_selection() ?>" aria-valuemin="0" aria-valuemax="100">
									<?= $project->get_selection() ?>%
								</div>
							</div>
							<label class="fw-semibold">Quality Assessment</label>
							<div class="progress mb-2" style="height: 22px;">
								<div class="progress-bar bg-secondary fw-bold" role="progressbar" style="width: <?= $project->get_quality() ?>%" aria-valuenow="<?= $project->get_quality() ?>" aria-valuemin="0" aria-valuemax="100">
									<?= $project->get_quality() ?>%
								</div>
							</div>
							<label class="fw-semibold">Data Extraction</label>
							<div class="progress" style="height: 22px;">
								<div class="progress-bar bg-danger fw-bold" role="progressbar" style="width: <?= $project->get_extraction() ?>%" aria-valuenow="<?= $project->get_extraction() ?>" aria-valuemin="0" aria-valuemax="100">
									<?= $project->get_extraction() ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="p-3 bg-white rounded shadow-sm h-100">
						<h5 class="fw-bold mb-3"><i class="fas fa-history opt me-2"></i>Activity Record</h5>
						<div class="scroll" style="max-height: 400px; overflow-y: auto;">
							<?php foreach ($logs as $log) { ?>
								<div class="card mb-3">
									<div class="card-header bg-light fw-semibold">
										<?= $log['name']; ?>
									</div>
									<div class="card-body">
										<?= $log['activity']; ?>
									</div>
									<div class="card-footer bg-white">
										<small class="text-muted"><?= $log['time']; ?></small>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
