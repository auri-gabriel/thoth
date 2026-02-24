<div class="tab-pane container-fluid" role="tabpanel" id="tab_criteria">
	<div class="form-inline">
		<label for="id_criteria"><strong>Criteria</strong></label>
		<a onclick="modal_help('modal_help_criteria')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>

	<!-- Add Criteria Form -->
	<div class="form-inline">
		<div class="input-group col-md-2">
			<label for="id_criteria" class="col-sm-12 col-md-12">ID</label>
			<input type="text" id="id_criteria" placeholder="ID" class="form-control">
		</div>
		<div class="input-group col-md-6">
			<label for="description_criteria" class="col-sm-12 col-md-12">Description</label>
			<input type="text" id="description_criteria" placeholder="Description" class="form-control">
		</div>
		<div class="input-group col-md-3">
			<label for="select_type" class="col-sm-12 col-md-12">Type</label>
			<select class="form-control" id="select_type">
				<option value="Inclusion">Inclusion</option>
				<option value="Exclusion">Exclusion</option>
			</select>
			<button class="btn btn-success" type="button" onclick="add_criteria()">
				<span class="fas fa-plus"></span>
			</button>
		</div>
	</div>
	<br>

	<!-- Inclusion Criteria -->
	<label><strong>Inclusion Criteria</strong></label>
	<table id="table_criteria_inclusion" class="table table-responsive-sm">
		<caption>List of Inclusion Criteria</caption>
		<thead>
			<tr>
				<th>Select</th>
				<th>ID</th>
				<th>Criteria</th>
				<th>Actions</th>
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
						<button class="btn btn-warning opt" onClick="modal_criteria_inclusion($(this).parents('tr'))">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_criteria_inclusion($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="input-group col-md-2">
		<label for="rule_inclusion" class="col-sm-12 col-md-12">Inclusion Rule</label>
		<select class="form-control col-sm-12 opt" id="rule_inclusion" onchange="edit_inclusion_rule();">
			<?php foreach ($rules as $rule):
				$selected = ($rule == $project->get_inclusion_rule()) ? 'selected' : '';
			?>
				<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<br>

	<!-- Exclusion Criteria -->
	<label><strong>Exclusion Criteria</strong></label>
	<table id="table_criteria_exclusion" class="table table-responsive-sm">
		<caption>List of Exclusion Criteria</caption>
		<thead>
			<tr>
				<th>Select</th>
				<th>ID</th>
				<th>Criteria</th>
				<th>Actions</th>
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
						<button class="btn btn-warning opt" onClick="modal_criteria_exclusion($(this).parents('tr'))">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger" onClick="delete_criteria_exclusion($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="input-group col-md-2">
		<label for="rule_exclusion" class="col-sm-12 col-md-12">Exclusion Rule</label>
		<select class="form-control col-sm-12 opt" id="rule_exclusion" onchange="edit_exclusion_rule();">
			<?php foreach ($rules as $rule):
				$selected = ($rule == $project->get_exclusion_rule()) ? 'selected' : '';
			?>
				<option <?= $selected ?> value="<?= $rule ?>"><?= $rule ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<br>

	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_search_strategy" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_quality" class="btn btn-secondary opt">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
