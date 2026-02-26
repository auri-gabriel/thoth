<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_criteria">
	<div class="row justify-content-center">

		<div class="card shadow-sm h-100 bg-light">
			<div class="card-body">
				<div class="d-flex align-items-center mb-2">
					<label for="id_criteria" class="mb-0"><strong>Criteria</strong></label>
					<a onclick="modal_help('modal_help_criteria')" class="ms-auto opt" tabindex="0" aria-label="Help about criteria" data-bs-toggle="tooltip" title="What are criteria?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-2">
						<label for="id_criteria" class="form-label">ID</label>
						<input type="text" id="id_criteria" placeholder="ID" class="form-control" aria-label="Criteria ID">
					</div>
					<div class="col-md-6">
						<label for="description_criteria" class="form-label">Description</label>
						<input type="text" id="description_criteria" placeholder="Description" class="form-control" aria-label="Criteria Description">
					</div>
					<div class="col-md-3">
						<label for="select_type" class="form-label">Type</label>
						<div class="input-group">
							<select class="form-control" id="select_type" aria-label="Criteria Type">
								<option value="Inclusion">Inclusion</option>
								<option value="Exclusion">Exclusion</option>
							</select>
							<button class="btn btn-success" type="button" onclick="add_criteria()" data-bs-toggle="tooltip" title="Add criteria">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="mt-4 mb-2">
					<label class="mb-2"><strong>Inclusion Criteria</strong></label>
					<div class="table-responsive">
						<table id="table_criteria_inclusion" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Inclusion Criteria</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Select</th>
									<th scope="col">ID</th>
									<th scope="col">Criteria</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_inclusion_criteria() as $ic):
									$checked = $ic->get_pre_selected() ? 'checked' : '';
								?>
									<tr>
										<td>
											<div class="form-check">
												<input id="selected_<?= str_replace(' ', '', $ic->get_id()) ?>"
													type="checkbox" <?= $checked ?>
													class="form-check-input"
													onchange="select_criteria_inclusion($(this).parents('tr'))">
											</div>
										</td>
										<td><?= $ic->get_id() ?></td>
										<td><?= $ic->get_description() ?></td>
										<td>
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_criteria_inclusion($(this).parents('tr'))"><span class="fas fa-edit"></span></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_criteria_inclusion($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="input-group col-md-3 mb-3">
						<label for="rule_inclusion" class="form-label"><strong>Inclusion Rule</strong></label>
						<div class="input-group">
							<span class="input-group-text bg-success text-white"><i class="fas fa-check-circle"></i></span>
							<select class="form-control opt" id="rule_inclusion" onchange="edit_inclusion_rule();" aria-label="Inclusion Rule">
								<?php foreach ($rules as $rule):
									$selected = ($rule == $project->get_inclusion_rule()) ? 'selected' : '';
								?>
									<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="mt-4 mb-2">
					<label class="mb-2"><strong>Exclusion Criteria</strong></label>
					<div class="table-responsive">
						<table id="table_criteria_exclusion" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Exclusion Criteria</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Select</th>
									<th scope="col">ID</th>
									<th scope="col">Criteria</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_exclusion_criteria() as $ec):
									$checked = $ec->get_pre_selected() ? 'checked' : '';
								?>
									<tr>
										<td>
											<div class="form-check">
												<input id="selected_<?= str_replace(' ', '', $ec->get_id()) ?>"
													type="checkbox" <?= $checked ?>
													class="form-check-input"
													onchange="select_criteria_exclusion($(this).parents('tr'))">
											</div>
										</td>
										<td><?= $ec->get_id() ?></td>
										<td><?= $ec->get_description() ?></td>
										<td>
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_criteria_exclusion($(this).parents('tr'))"><span class="fas fa-edit"></span></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_criteria_exclusion($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="input-group col-md-3 mb-3">
						<label for="rule_exclusion" class="form-label"><strong>Exclusion Rule</strong></label>
						<div class="input-group">
							<span class="input-group-text bg-danger text-white"><i class="fas fa-times-circle"></i></span>
							<select class="form-control opt" id="rule_exclusion" onchange="edit_exclusion_rule();" aria-label="Exclusion Rule">
								<?php foreach ($rules as $rule):
									$selected = ($rule == $project->get_exclusion_rule()) ? 'selected' : '';
								?>
									<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_search_strategy" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_quality" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
</div>