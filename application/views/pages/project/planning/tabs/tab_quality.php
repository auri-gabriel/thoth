<div class="tab-pane container-fluid" role="tabpanel" id="tab_quality">

	<!-- General Score Section -->
	<div class="form-inline">
		<label for="start_interval"><strong>General Score</strong></label>
		<a onclick="modal_help('modal_help_general_score')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>
	<div class="form-inline">
		<div class="input-group col-sm-12 col-md-3">
			<label for="start_interval" class="col-sm-12">General Score Interval</label>
			<input type="number" id="start_interval" class="form-control" step="0.5" placeholder="4.5" min="0">
			<input type="number" id="end_interval" class="form-control" step="0.5" placeholder="5" min="0.1">
		</div>
		<div class="input-group col-sm-12 col-md-5">
			<label for="general_score_desc" class="col-sm-12">General Score Description</label>
			<input type="text" id="general_score_desc" class="form-control" placeholder="Description">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_general_quality_score();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<div class="input-group col-md-4">
		<label for="min_score_to_app" class="col-sm-12">Minimum General Score to Approve</label>
		<select class="form-control" id="min_score_to_app" onchange="edit_min_score(this);">
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
	<br>
	<table id="table_general_score" class="table table-responsive-sm">
		<caption>List of General Score</caption>
		<thead>
			<tr>
				<th>Start Score Interval</th>
				<th>End Score Interval</th>
				<th>Score Description</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_quality_scores() as $score): ?>
				<tr>
					<td><?= $score->get_start_interval() ?></td>
					<td><?= $score->get_end_interval() ?></td>
					<td><?= $score->get_description() ?></td>
					<td>
						<button class="btn btn-warning opt" onClick="modal_general_score($(this).parents('tr'))">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_general_quality_score($(this).parents('tr'))">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>

	<!-- Question Quality Section -->
	<div class="form-inline">
		<label for="id_qa"><strong>Question Quality</strong></label>
		<a onclick="modal_help('modal_help_qa')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-2">
			<label for="id_qa" class="col-sm-12">ID</label>
			<input type="text" class="form-control" id="id_qa">
		</div>
		<div class="input-group col-md-7">
			<label for="desc_qa" class="col-sm-12">Description</label>
			<input type="text" class="form-control" id="desc_qa">
		</div>
		<div class="input-group col-md-2">
			<label for="weight_qa" class="col-sm-12">Weight</label>
			<input type="number" min="1" class="form-control" id="weight_qa" step="0.5">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_qa()">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>

	<!-- Question Score -->
	<div class="form-inline">
		<label for="list_qa"><strong>Question Score</strong></label>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-2">
			<label for="list_qa" class="col-sm-12">Question</label>
			<select class="form-control" id="list_qa">
				<?php foreach ($project->get_questions_quality() as $qa): ?>
					<option value="<?= $qa->get_id() ?>"><?= $qa->get_id() ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="input-group col-md-2">
			<label for="score_rule" class="col-sm-12">Score Rule</label>
			<input type="text" class="form-control" id="score_rule">
		</div>
		<div class="input-group col-md-2">
			<label for="score" id="lbl_score" class="col-sm-12">Score: 50%</label>
			<input type="range" min="0" max="100" class="form-control-range" id="score" step="5"
				   oninput="update_text_score(this.value)" onchange="update_text_score(this.value)">
		</div>
		<div class="input-group col-md-6">
			<label for="desc_score" class="col-sm-12">Description</label>
			<input type="text" class="form-control" id="desc_score">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_score_quality()">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>

	<!-- QA Table -->
	<table id="table_qa" class="table table-responsive-sm">
		<caption>List of Question Quality</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Description</th>
				<th>Scores Rules</th>
				<th>Weight</th>
				<th>Minimum to Approve</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_questions_quality() as $qa): ?>
				<tr>
					<td><?= $qa->get_id() ?></td>
					<td><?= $qa->get_description() ?></td>
					<td>
						<table id="table_<?= $qa->get_id() ?>" class="table">
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
											<button class="btn btn-warning opt" onClick="modal_score_quality(this)">
												<span class="fas fa-edit"></span>
											</button>
											<button class="btn btn-danger" onClick="delete_score_quality(this)">
												<span class="far fa-trash-alt"></span>
											</button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</td>
					<td><?= $qa->get_weight() ?></td>
					<td>
						<select class="form-control" id="min_to_<?= $qa->get_id() ?>"
								data-qa="<?= $qa->get_id() ?>" onchange="edit_min_score_qa(this)">
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
						<button class="btn btn-warning opt" onClick="modal_qa($(this).parents('tr'))">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_qa($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>

	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_criteria" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_data" class="btn btn-secondary opt">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
