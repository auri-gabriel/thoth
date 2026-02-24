<div class="container py-4">
	<div class="card shadow-sm mb-4">
		<div class="card-header bg-white text-center pb-3">
			<h3 class="mb-2 fw-bold"><?= $project->get_title(); ?></h3>
			<input type="hidden" id="id_project" value="<?= $project->get_id(); ?>">
			<div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
				<a href="<?= base_url('open/' . $project->get_id()) ?>" class="btn btn-primary opt">Overview <i class="fas fa-binoculars"></i></a>
				<a href="<?= base_url('planning/' . $project->get_id()) ?>" class="btn btn-outline-primary opt">Planning <i class="fas fa-list"></i></a>
				<?php if ($this->session->level == "4") { ?>
					<a href="<?= base_url('study_selection_adm/' . $project->get_id()) ?>" class="btn btn-outline-primary opt">Conducting <i class="fas fa-play-circle"></i></a>
				<?php } else { ?>
					<a href="<?= base_url('conducting/' . $project->get_id()) ?>" class="btn btn-outline-primary opt">Conducting <i class="fas fa-play-circle"></i></a>
				<?php } ?>
				<a href="<?= base_url('reporting/' . $project->get_id()) ?>" class="btn btn-outline-primary opt">Reporting <i class="fas fa-chart-line"></i></a>
				<?php if ($project->get_planning() == 100) { ?>
					<a href="<?= base_url('export/' . $project->get_id()) ?>" class="btn btn-outline-primary opt">Export <i class="fas fa-file-download"></i></a>
				<?php } ?>
			</div>
		</div>
		<div class="card-body">
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

