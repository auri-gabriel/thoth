<div class="tab-pane container-fluid" role="tabpanel" id="tab_data">
	<div class="form-inline">
		<label for="id_data_extraction"><strong>Data Extraction</strong></label>
		<a onclick="modal_help('modal_help_data_extraction')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>

	<!-- Add Extraction Question -->
	<div class="form-inline">
		<div class="input-group col-md-2">
			<label for="id_data_extraction" class="col-sm-12">ID</label>
			<input type="text" class="form-control" id="id_data_extraction">
		</div>
		<div class="input-group col-md-7">
			<label for="desc_data_extraction" class="col-sm-12">Description</label>
			<input type="text" class="form-control" id="desc_data_extraction">
		</div>
		<div class="input-group col-md-3">
			<label for="type_data_extraction" class="col-sm-12">Type of Data</label>
			<select class="form-control" id="type_data_extraction">
				<?php foreach ($question_types as $type): ?>
					<option value="<?= $type ?>"><?= $type ?></option>
				<?php endforeach; ?>
			</select>
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_question_extraction();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>

	<!-- Add Option -->
	<div class="form-inline">
		<label for="list_qde"><strong>Option</strong></label>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-2">
			<label for="list_qde" class="col-sm-12">Question</label>
			<select class="form-control" id="list_qde">
				<?php foreach ($project->get_questions_extraction() as $qe):
					if ($qe->get_type() != "Text"): ?>
						<option value="<?= $qe->get_id() ?>"><?= $qe->get_id() ?></option>
				<?php endif;
				endforeach; ?>
			</select>
		</div>
		<div class="input-group col-md-7">
			<label for="desc_op" class="col-sm-12">Option</label>
			<input type="text" class="form-control" id="desc_op">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_option();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>

	<!-- Data Extraction Table -->
	<table id="table_data_extraction" class="table table-responsive-sm">
		<caption>List of Data Extraction</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Description</th>
				<th>Type</th>
				<th>Options</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_questions_extraction() as $qe): ?>
				<tr>
					<td><?= $qe->get_id() ?></td>
					<td><?= $qe->get_description() ?></td>
					<td><?= $qe->get_type() ?></td>
					<td>
						<?php if ($qe->get_type() !== "Text"): ?>
							<table id="table_<?= $qe->get_id() ?>" class="table">
								<thead>
									<tr>
										<th>Option</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($qe->get_options() as $op): ?>
										<tr>
											<td><?= $op ?></td>
											<td>
												<button class="btn btn-warning opt" onClick="modal_option(this)">
													<span class="fas fa-edit"></span>
												</button>
												<button class="btn btn-danger" onClick="delete_option(this)">
													<span class="far fa-trash-alt"></span>
												</button>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>
					</td>
					<td>
						<button class="btn btn-warning opt" onClick="modal_extraction($(this).parents('tr'));">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_extraction($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>

	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_quality" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#" class="btn btn-secondary disabled">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
