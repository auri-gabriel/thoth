<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_criteria">
	<div class="row justify-content-center">

		<div class="card shadow-sm bg-light">
			<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
				<strong>Criteria</strong>
				<a onclick="modal_help('modal_help_criteria')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about criteria" data-bs-toggle="tooltip" title="What are criteria?"><i class="fas fa-question-circle"></i></a>
			</div>
			<div class="card-body">

				<?php if (!$readonly): ?>
				<!-- Add Criteria -->
				<div class="row g-3 mb-4">
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
							<select class="form-select" id="select_type" aria-label="Criteria Type">
								<option value="Inclusion">Inclusion</option>
								<option value="Exclusion">Exclusion</option>
							</select>
							<button class="btn btn-success" type="button" onclick="add_criteria()" data-bs-toggle="tooltip" title="Add criteria">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<!-- Inclusion Criteria -->
				<div class="mb-4">
					<div class="d-flex align-items-center mb-2">
						<span class="badge bg-success me-2"><i class="fas fa-check"></i></span>
						<strong>Inclusion Criteria</strong>
					</div>
					<div class="table-responsive">
						<table id="table_criteria_inclusion" class="table table-bordered table-hover align-middle mb-2">
							<caption class="visually-hidden">List of Inclusion Criteria</caption>
							<thead class="table-light">
								<tr>
									<?php if (!$readonly): ?><th scope="col" style="width:5%">Select</th><?php endif; ?>
									<th scope="col" style="width:10%">ID</th>
									<th scope="col">Criteria</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_inclusion_criteria() as $ic):
									$checked = $ic->get_pre_selected() ? 'checked' : '';
								?>
									<tr>
										<?php if (!$readonly): ?>
										<td>
											<div class="form-check mb-0">
												<input id="selected_<?= str_replace(' ', '', $ic->get_id()) ?>"
													type="checkbox" <?= $checked ?>
													class="form-check-input"
													onchange="select_criteria_inclusion($(this).parents('tr'))">
											</div>
										</td>
										<?php endif; ?>
										<td><?= $ic->get_id() ?></td>
										<td><?= $ic->get_description() ?></td>
										<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_criteria_inclusion($(this).parents('tr'))"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_criteria_inclusion($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
										</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php if (!$readonly): ?>
					<div class="row">
						<div class="col-md-4">
							<label for="rule_inclusion" class="form-label fw-semibold">Inclusion Rule</label>
							<div class="input-group">
								<span class="input-group-text bg-success text-white"><i class="fas fa-check-circle"></i></span>
								<select class="form-select opt" id="rule_inclusion" onchange="edit_inclusion_rule();" aria-label="Inclusion Rule">
									<?php foreach ($rules as $rule):
										$selected = ($rule == $project->get_inclusion_rule()) ? 'selected' : '';
									?>
										<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<?php else: ?>
					<p class="text-muted small mb-0">Inclusion Rule: <strong><?= $project->get_inclusion_rule() ?></strong></p>
					<?php endif; ?>
				</div>

				<!-- Exclusion Criteria -->
				<div class="mb-2">
					<div class="d-flex align-items-center mb-2">
						<span class="badge bg-danger me-2"><i class="fas fa-times"></i></span>
						<strong>Exclusion Criteria</strong>
					</div>
					<div class="table-responsive">
						<table id="table_criteria_exclusion" class="table table-bordered table-hover align-middle mb-2">
							<caption class="visually-hidden">List of Exclusion Criteria</caption>
							<thead class="table-light">
								<tr>
									<?php if (!$readonly): ?><th scope="col" style="width:5%">Select</th><?php endif; ?>
									<th scope="col" style="width:10%">ID</th>
									<th scope="col">Criteria</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_exclusion_criteria() as $ec):
									$checked = $ec->get_pre_selected() ? 'checked' : '';
								?>
									<tr>
										<?php if (!$readonly): ?>
										<td>
											<div class="form-check mb-0">
												<input id="selected_<?= str_replace(' ', '', $ec->get_id()) ?>"
													type="checkbox" <?= $checked ?>
													class="form-check-input"
													onchange="select_criteria_exclusion($(this).parents('tr'))">
											</div>
										</td>
										<?php endif; ?>
										<td><?= $ec->get_id() ?></td>
										<td><?= $ec->get_description() ?></td>
										<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_criteria_exclusion($(this).parents('tr'))"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_criteria_exclusion($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
										</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php if (!$readonly): ?>
					<div class="row">
						<div class="col-md-4">
							<label for="rule_exclusion" class="form-label fw-semibold">Exclusion Rule</label>
							<div class="input-group">
								<span class="input-group-text bg-danger text-white"><i class="fas fa-times-circle"></i></span>
								<select class="form-select opt" id="rule_exclusion" onchange="edit_exclusion_rule();" aria-label="Exclusion Rule">
									<?php foreach ($rules as $rule):
										$selected = ($rule == $project->get_exclusion_rule()) ? 'selected' : '';
									?>
										<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<?php else: ?>
					<p class="text-muted small mb-0">Exclusion Rule: <strong><?= $project->get_exclusion_rule() ?></strong></p>
					<?php endif; ?>
				</div>

			</div>
		</div>

	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_search_strategy" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_quality" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
