<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_data">
	<div class="row justify-content-center">

		<div class="card shadow-sm bg-light">
			<div class="card-body">

				<!-- Data Extraction Questions -->
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3 px-0 mb-3">
					<strong>Data Extraction</strong>
					<a onclick="modal_help('modal_help_data_extraction')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about data extraction" data-bs-toggle="tooltip" title="What is data extraction?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-3 mb-2">
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
							<select class="form-select" id="type_data_extraction" aria-label="Type of Data">
								<?php foreach ($question_types as $type): ?>
									<option value="<?= $type ?>"><?= $type ?></option>
								<?php endforeach; ?>
							</select>
							<button class="btn btn-success" type="button" onclick="add_question_extraction();" data-bs-toggle="tooltip" title="Add extraction question">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
				</div>

				<!-- Options -->
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3 px-0 mb-3 mt-4">
					<strong>Option</strong>
				</div>
				<div class="row g-3 mb-2">
					<div class="col-md-2">
						<label for="list_qde" class="form-label">Question</label>
						<select class="form-select" id="list_qde" aria-label="Select Extraction Question">
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
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
				</div>

				<div class="table-responsive mt-4">
					<table id="table_data_extraction" class="table table-hover align-middle mb-0">
						<caption class="visually-hidden">List of Data Extraction</caption>
						<thead class="table-light">
							<tr>
								<th scope="col" style="width:10%">ID</th>
								<th scope="col" style="width:30%">Description</th>
								<th scope="col" style="width:10%">Type</th>
								<th scope="col">Options</th>
								<th scope="col" class="text-end" style="width:10%">Actions</th>
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
											<table id="table_<?= $qe->get_id() ?>" class="table table-sm mb-0">
												<thead class="table-light">
													<tr>
														<th>Option</th>
														<th class="text-end">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($qe->get_options() as $op): ?>
														<tr>
															<td><?= $op ?></td>
															<td class="text-end">
																<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_option(this)"><i class="fas fa-edit"></i></button>
																<button class="btn btn-outline-danger btn-sm" onClick="delete_option(this)"><i class="far fa-trash-alt"></i></button>
															</td>
														</tr>
													<?php endforeach; ?>
												</tbody>
											</table>
										<?php endif; ?>
									</td>
									<td class="text-end">
										<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_extraction($(this).parents('tr'));"><i class="fas fa-edit"></i></button>
										<button class="btn btn-outline-danger btn-sm" onClick="delete_extraction($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
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
		<a href="#tab_quality" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#" class="btn btn-outline-secondary disabled" tabindex="-1" aria-disabled="true">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
<script src="<?= base_url('assets/js/data_extraction.js'); ?>"></script>
