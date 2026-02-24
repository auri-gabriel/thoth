<div class="container py-4">
	<div class="card shadow-sm mb-4">
		<?php $this->load->view('pages/project/planning/partials/card_header', ['active_tab' => 'overview']); ?>
		<div class="card-body bg-light">
			<div class="row g-4 mb-4">
				<div class="col-md-4">
					<div class="p-3 bg-light rounded h-100">
						<h5 class="fw-bold mb-2"><i class="fas fa-align-justify opt me-2"></i>Description</h5>
						<p class="mb-0"><?= $project->get_description(); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="p-3 bg-light rounded h-100">
						<h5 class="fw-bold mb-2"><i class="fas fa-bullseye opt me-2"></i>Objectives</h5>
						<p class="mb-0"><?= $project->get_objectives(); ?></p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="p-3 bg-light rounded h-100">
						<h5 class="fw-bold mb-2"><i class="fas fa-users opt me-2"></i>Members</h5>
						<ul class="list-unstyled mb-0">
							<?php foreach ($project->get_members() as $member) { ?>
								<li><?= $member->get_name() . " - " . $member->get_level(); ?></li>
							<?php } ?>
						</ul>
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
