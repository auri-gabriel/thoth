<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_quality">
	<div class="row justify-content-center">
		<div class="card shadow-sm h-100 bg-light">
			<div class="card-body">
				<!-- General Score Section -->
				<div class="d-flex align-items-center mb-2">
					<label for="start_interval" class="mb-0"><strong>General Score</strong></label>
					<a onclick="modal_help('modal_help_general_score')" class="ms-auto opt" tabindex="0" aria-label="Help about general score" data-bs-toggle="tooltip" title="What is general score?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-3">
						<label for="start_interval" class="form-label">General Score Interval</label>
						<div class="input-group">
							<input type="number" id="start_interval" class="form-control" step="0.5" placeholder="4.5" min="0" aria-label="Start Interval">
							<input type="number" id="end_interval" class="form-control" step="0.5" placeholder="5" min="0.1" aria-label="End Interval">
						</div>
					</div>
					<div class="col-md-5">
						<label for="general_score_desc" class="form-label">General Score Description</label>
						<div class="input-group">
							<input type="text" id="general_score_desc" class="form-control" placeholder="Description" aria-label="General Score Description">
							<button class="btn btn-success" type="button" onclick="add_general_quality_score();" data-bs-toggle="tooltip" title="Add general score">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
					<div class="col-md-4">
						<label for="min_score_to_app" class="form-label">Minimum General Score to Approve</label>
						<div class="input-group">
							<span class="input-group-text bg-success text-white"><i class="fas fa-check-circle"></i></span>
							<select class="form-control" id="min_score_to_app" onchange="edit_min_score(this);" aria-label="Minimum Score to Approve">
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
				<div class="table-responsive mt-4">
					<table id="table_general_score" class="table table-hover align-middle">
						<caption class="visually-hidden">List of General Score</caption>
						<thead class="table-light">
							<tr>
								<th scope="col">Start Score Interval</th>
								<th scope="col">End Score Interval</th>
								<th scope="col">Score Description</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_quality_scores() as $score): ?>
								<tr>
									<td><?= $score->get_start_interval() ?></td>
									<td><?= $score->get_end_interval() ?></td>
									<td><?= $score->get_description() ?></td>
									<td>
										<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_general_score($(this).parents('tr'))"><span class="fas fa-edit"></span></button>
										<button class="btn btn-outline-danger btn-sm" onClick="delete_general_quality_score($(this).parents('tr'))"><span class="far fa-trash-alt"></span></button>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- Question Quality Section -->
				<div class="d-flex align-items-center mb-2 mt-4">
					<label for="id_qa" class="mb-0"><strong>Question Quality</strong></label>
					<a onclick="modal_help('modal_help_qa')" class="ms-auto opt" tabindex="0" aria-label="Help about question quality" data-bs-toggle="tooltip" title="What is question quality?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-2 mb-3">
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
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<!-- Question Score -->
				<div class="d-flex align-items-center mb-2 mt-4">
					<label for="list_qa" class="mb-0"><strong>Question Score</strong></label>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-2">
						<label for="list_qa" class="form-label">Question</label>
						<select class="form-control" id="list_qa" aria-label="Select Question">
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
						<input type="range" min="0" max="100" class="form-control-range w-100" id="score" step="5" aria-label="Score Percentage"
							style="max-width: 150px;" oninput="update_text_score(this.value)" onchange="update_text_score(this.value)">
					</div>
					<div class="col-md-6">
						<label for="desc_score" class="form-label">Description</label>
						<div class="input-group">
							<input type="text" class="form-control" id="desc_score" aria-label="Score Description">
							<button class="btn btn-success" type="button" onclick="add_score_quality()" data-bs-toggle="tooltip" title="Add score quality">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive mt-4">
					<table id="table_qa" class="table table-hover align-middle">
						<caption class="visually-hidden">List of Question Quality</caption>
						<thead class="table-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Description</th>
								<th scope="col">Scores Rules</th>
								<th scope="col">Weight</th>
								<th scope="col">Minimum to Approve</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_questions_quality() as $qa): ?>
								<tr>
									<td><?= $qa->get_id() ?></td>
									<td><?= $qa->get_description() ?></td>
									<td>
										<table id="table_<?= $qa->get_id() ?>" class="table mb-0">
											<thead>
												<tr>
													<th>Score Rule</th>
													<th>Score</th>
													<th>Description</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($qa->get_scores() as $sc): ?>
													<tr>
														<td><?= $sc->get_score_rule() ?></td>
														<td><?= $sc->get_score() ?>%</td>
														<td><?= $sc->get_description() ?></td>
														<td>
															<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_score_quality(this)"><span class="fas fa-edit"></span></button>
															<button class="btn btn-outline-danger btn-sm" onClick="delete_score_quality(this)"><span class="far fa-trash-alt"></span></button>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</td>
									<td><?= $qa->get_weight() ?></td>
									<td>
										<select class="form-control" id="min_to_<?= $qa->get_id() ?>" data-qa="<?= $qa->get_id() ?>" onchange="edit_min_score_qa(this)" aria-label="Minimum to Approve">
											<option value=""></option>
											<?php
											$min = $qa->get_min_to_approve();
											foreach ($qa->get_scores() as $sc):
												$selected = (!is_null($min) && $sc->get_score_rule() == $min->get_score_rule()) ? 'selected' : '';
											?>
												<option <?= $selected ?> value="<?= $sc->get_score_rule() ?>"><?= $sc->get_score_rule() ?></option>
											<?php endforeach; ?>
										</select>
									</td>
									<td>
										<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_qa($(this).parents('tr'))"><span class="fas fa-edit"></span></button>
										<button class="btn btn-outline-danger btn-sm" onClick="delete_qa($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_criteria" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_data" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
</div>