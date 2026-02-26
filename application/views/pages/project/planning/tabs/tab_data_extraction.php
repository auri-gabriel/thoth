<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_data">
	<div class="row justify-content-center">

		<div class="card shadow-sm h-100 bg-light">
			<div class="card-body">
				<div class="d-flex align-items-center mb-2">
					<label for="id_data_extraction" class="mb-0"><strong>Data Extraction</strong></label>
					<a onclick="modal_help('modal_help_data_extraction')" class="ms-auto opt" tabindex="0" aria-label="Help about data extraction" data-bs-toggle="tooltip" title="What is data extraction?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-2">
						<label for="id_data_extraction" class="form-label">ID</label>
						<input type="text" class="form-control" id="id_data_extraction" aria-label="Extraction ID">
					</div>
					<div class="col-md-7">
						<label for="desc_data_extraction" class="form-label">Description</label>
						<input type="text" class="form-control" id="desc_data_extraction" aria-label="Extraction Description">
					</div>
					<div class="col-md-3">
						<label for="type_data_extraction" class="form-label">Type of Data</label>
						<div class="input-group">
							<select class="form-control" id="type_data_extraction" aria-label="Type of Data">
								<?php foreach ($question_types as $type): ?>
									<option value="<?= $type ?>"><?= $type ?></option>
								<?php endforeach; ?>
							</select>
							<button class="btn btn-success" type="button" onclick="add_question_extraction();" data-bs-toggle="tooltip" title="Add extraction question">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="d-flex align-items-center mb-2 mt-4">
					<label for="list_qde" class="mb-0"><strong>Option</strong></label>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-2">
						<label for="list_qde" class="form-label">Question</label>
						<select class="form-control" id="list_qde" aria-label="Select Extraction Question">
							<?php foreach ($project->get_questions_extraction() as $qe):
								if ($qe->get_type() != "Text"): ?>
									<option value="<?= $qe->get_id() ?>"><?= $qe->get_id() ?></option>
							<?php endif;
							endforeach; ?>
						</select>
					</div>
					<div class="col-md-7">
						<label for="desc_op" class="form-label">Option</label>
						<div class="input-group">
							<input type="text" class="form-control" id="desc_op" aria-label="Option">
							<button class="btn btn-success" type="button" onclick="add_option();" data-bs-toggle="tooltip" title="Add option">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive mt-4">
					<table id="table_data_extraction" class="table table-hover align-middle">
						<caption class="visually-hidden">List of Data Extraction</caption>
						<thead class="table-light">
							<tr>
								<th scope="col">ID</th>
								<th scope="col">Description</th>
								<th scope="col">Type</th>
								<th scope="col">Options</th>
								<th scope="col">Actions</th>
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
											<table id="table_<?= $qe->get_id() ?>" class="table mb-0">
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
																<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_option(this)"><span class="fas fa-edit"></span></button>
																<button class="btn btn-outline-danger btn-sm" onClick="delete_option(this)"><span class="far fa-trash-alt"></span></button>
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										<?php endif; ?>
									</td>
									<td>
										<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_extraction($(this).parents('tr'));"><span class="fas fa-edit"></span></button>
										<button class="btn btn-outline-danger btn-sm" onClick="delete_extraction($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
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
		<a href="#tab_quality" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#" class="btn btn-outline-secondary disabled" tabindex="-1" aria-disabled="true">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
<script src="<?= base_url('assets/js/data_extraction.js'); ?>"></script>