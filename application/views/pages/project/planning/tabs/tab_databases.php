<div class="tab-pane container-fluid bg-light" role="tabpanel" id="tab_databases">
	<div class="form-inline">
		<label for="databases"><strong>Data Bases</strong></label>
		<a onclick="modal_help('modal_help_database')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-3">
			<label for="databases" class="opt col-sm-12">Database</label>
			<select class="form-control" id="databases">
				<?php foreach ($databases as $database): ?>
					<option value="<?= $database ?>"><?= $database ?></option>
				<?php endforeach; ?>
			</select>
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_database();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<div class="form-inline">
		<div class="input-group col-md-4">
			<label for="new_database" class="opt col-sm-12">Other Database</label>
			<input type="text" class="form-control" id="new_database">
		</div>
		<div class="input-group col-md-4">
			<label for="new_database_link" class="opt col-sm-12">Other Database Link</label>
			<input type="text" class="form-control" id="new_database_link">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="new_database();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>
	<table id="table_databases" class="table table-responsive-sm">
		<caption>List of Databases</caption>
		<thead>
			<tr>
				<th>Database</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_databases() as $database): ?>
				<tr>
					<td><?= $database->get_name() ?></td>
					<td>
						<button class="btn btn-danger" onClick="delete_database($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>
	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_research" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_search_string" class="btn btn-secondary">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
