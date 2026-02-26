<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_quality">
	<div class="row justify-content-center">
		<div class="card shadow-sm">
			<div class="card-body">

				<!-- General Score Section -->
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3 px-0 mb-3">
					<strong>General Score</strong>
					<a onclick="modal_help('modal_help_general_score')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about general score" data-bs-toggle="tooltip" title="What is general score?"><i class="fas fa-question-circle"></i></a>
				</div>
				<?php if (!$readonly): ?>
					<div class="row g-3 mb-2">
						<div class="col-md-3">
							<label class="form-label">Score Interval</label>
							<div class="input-group">
								<input type="number" id="start_interval" class="form-control" step="0.5" placeholder="From" min="0" aria-label="Start Interval">
								<span class="input-group-text text-muted">–</span>
								<input type="number" id="end_interval" class="form-control" step="0.5" placeholder="To" min="0.1" aria-label="End Interval">
							</div>
						</div>
						<div class="col-md-5">
							<label for="general_score_desc" class="form-label">Description</label>
							<div class="input-group">
								<input type="text" id="general_score_desc" class="form-control" placeholder="e.g. Excellent quality" aria-label="General Score Description">
								<button class="btn btn-success" type="button" onclick="add_general_quality_score();" data-bs-toggle="tooltip" title="Add general score">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="col-md-4">
							<label for="min_score_to_app" class="form-label">Minimum Score to Approve</label>
							<div class="input-group">
								<span class="input-group-text bg-success text-white"><i class="fas fa-check-circle"></i></span>
								<select class="form-select" id="min_score_to_app" onchange="edit_min_score(this);" aria-label="Minimum Score to Approve">
									<option value="null"></option>
									<?php
									$mini = $project->get_score_min();
									foreach ($project->get_quality_scores() as $scores):
										$selected = (!is_null($mini) && $scores->get_description() == $mini->get_description()) ? 'selected' : '';
									?>
										<option <?= $selected ?> value="<?= $scores->get_description() ?>"><?= $scores->get_description() ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				<?php else: ?>
					<div class="mb-2">
						<?php
						$mini = $project->get_score_min();
						if (!is_null($mini)): ?>
							<p class="text-muted small mb-0">Minimum Score to Approve: <strong><?= $mini->get_description() ?></strong></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="table-responsive mt-3 mb-4">
					<table id="table_general_score" class="table table-bordered table-hover align-middle mb-0">
						<caption class="visually-hidden">List of General Score</caption>
						<thead class="table-light">
							<tr>
								<th scope="col">Start</th>
								<th scope="col">End</th>
								<th scope="col">Description</th>
								<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_quality_scores() as $score): ?>
								<tr>
									<td><?= $score->get_start_interval() ?></td>
									<td><?= $score->get_end_interval() ?></td>
									<td><?= $score->get_description() ?></td>
									<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_general_score($(this).parents('tr'))"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_general_quality_score($(this).parents('tr'))"><i class="far fa-trash-alt"></i></button>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<!-- Question Quality Section -->
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3 px-0 mb-3">
					<strong>Question Quality</strong>
					<a onclick="modal_help('modal_help_qa')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about question quality" data-bs-toggle="tooltip" title="What is question quality?"><i class="fas fa-question-circle"></i></a>
				</div>
				<?php if (!$readonly): ?>
					<div class="row g-3 mb-2">
						<div class="col-md-2">
							<label for="id_qa" class="form-label">ID</label>
							<input type="text" class="form-control" id="id_qa" aria-label="QA ID">
						</div>
						<div class="col-md-7">
							<label for="desc_qa" class="form-label">Description</label>
							<input type="text" class="form-control" id="desc_qa" aria-label="QA Description">
						</div>
						<div class="col-md-2">
							<label for="weight_qa" class="form-label">Weight</label>
							<div class="input-group">
								<input type="number" min="1" class="form-control" id="weight_qa" step="0.5" aria-label="QA Weight">
								<button class="btn btn-success" type="button" onclick="add_qa()" data-bs-toggle="tooltip" title="Add QA">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- Question Score -->
					<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3 px-0 mb-3 mt-4">
						<strong>Question Score</strong>
					</div>
					<div class="row g-3 mb-2">
						<div class="col-md-2">
							<label for="list_qa" class="form-label">Question</label>
							<select class="form-select" id="list_qa" aria-label="Select Question">
								<?php foreach ($project->get_questions_quality() as $qa): ?>
									<option value="<?= $qa->get_id() ?>"><?= $qa->get_id() ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-2">
							<label for="score_rule" class="form-label">Score Rule</label>
							<input type="text" class="form-control" id="score_rule" aria-label="Score Rule">
						</div>
						<div class="col-md-2">
							<label for="score" id="lbl_score" class="form-label">Score: 50%</label>
							<input type="range" min="0" max="100" class="form-range mt-2" id="score" step="5"
								aria-label="Score Percentage"
								oninput="update_text_score(this.value)" onchange="update_text_score(this.value)">
						</div>
						<div class="col-md-5">
							<label for="desc_score" class="form-label">Description</label>
							<div class="input-group">
								<input type="text" class="form-control" id="desc_score" aria-label="Score Description">
								<button class="btn btn-success" type="button" onclick="add_score_quality()" data-bs-toggle="tooltip" title="Add score quality">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<div class="table-responsive mt-3">
					<table id="table_qa" class="table table-bordered table-hover align-middle mb-0">
						<caption class="visually-hidden">List of Question Quality</caption>
						<thead class="table-light">
							<tr>
								<th scope="col" style="width:8%">ID</th>
								<th scope="col" style="width:22%">Description</th>
								<th scope="col">Score Rules</th>
								<th scope="col" style="width:8%">Weight</th>
								<th scope="col" style="width:18%">Min. to Approve</th>
								<?php if (!$readonly): ?><th scope="col" class="text-end" style="width:10%">Actions</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_questions_quality() as $qa): ?>
								<tr>
									<td><?= $qa->get_id() ?></td>
									<td><?= $qa->get_description() ?></td>
									<td>
										<table id="table_<?= $qa->get_id() ?>" class="table table-bordered table-sm mb-0">
											<thead class="table-light">
												<tr>
													<th>Rule</th>
													<th>Score</th>
													<th>Description</th>
													<?php if (!$readonly): ?><th class="text-end">Actions</th><?php endif; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($qa->get_scores() as $sc): ?>
													<tr>
														<td><?= $sc->get_score_rule() ?></td>
														<td><?= $sc->get_score() ?>%</td>
														<td><?= $sc->get_description() ?></td>
														<?php if (!$readonly): ?>
															<td class="text-end">
																<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_score_quality(this)"><i class="fas fa-edit"></i></button>
																<button class="btn btn-outline-danger btn-sm" onClick="delete_score_quality(this)"><i class="far fa-trash-alt"></i></button>
															</td>
														<?php endif; ?>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</td>
									<td><?= $qa->get_weight() ?></td>
									<td>
										<?php if (!$readonly): ?>
											<select class="form-select form-select-sm" id="min_to_<?= $qa->get_id() ?>" data-qa="<?= $qa->get_id() ?>" onchange="edit_min_score_qa(this)" aria-label="Minimum to Approve">
												<option value=""></option>
												<?php
												$min = $qa->get_min_to_approve();
												foreach ($qa->get_scores() as $sc):
													$selected = (!is_null($min) && $sc->get_score_rule() == $min->get_score_rule()) ? 'selected' : '';
												?>
													<option <?= $selected ?> value="<?= $sc->get_score_rule() ?>"><?= $sc->get_score_rule() ?></option>
												<?php endforeach; ?>
											</select>
										<?php else:
											$min = $qa->get_min_to_approve();
											echo $min ? htmlspecialchars($min->get_score_rule()) : '—';
										?>
										<?php endif; ?>
									</td>
									<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_qa($(this).parents('tr'))"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_qa($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_criteria" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_data" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
<script src="<?= base_url('assets/js/quality_assessment.js'); ?>"></script>