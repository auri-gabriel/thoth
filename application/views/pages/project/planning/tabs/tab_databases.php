<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_databases">
	<div class="row justify-content-center">

		<div class="card shadow-sm bg-light">
			<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
				<strong>Databases</strong>
				<a onclick="modal_help('modal_help_database')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about databases" data-bs-toggle="tooltip" title="What are databases?"><i class="fas fa-question-circle"></i></a>
			</div>
			<div class="card-body">
				<div class="row g-3 mb-2">
					<div class="col-md-3">
						<label for="databases" class="form-label">Select Database</label>
						<div class="input-group">
							<select class="form-select" id="databases" aria-label="Database">
								<?php foreach ($databases as $database): ?>
									<option value="<?= $database ?>"><?= $database ?></option>
								<?php endforeach; ?>
							</select>
							<button class="btn btn-success" type="button" onclick="add_database();" data-bs-toggle="tooltip" title="Add database">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
					<div class="col-md-4">
						<label for="new_database" class="form-label">Other Database</label>
						<input type="text" class="form-control" id="new_database" placeholder="Database name" aria-label="Other Database">
					</div>
					<div class="col-md-4">
						<label for="new_database_link" class="form-label">Database Link</label>
						<div class="input-group">
							<input type="text" class="form-control" id="new_database_link" placeholder="https://" aria-label="Other Database Link">
							<button class="btn btn-success" type="button" onclick="new_database();" data-bs-toggle="tooltip" title="Add other database">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive mt-3">
					<table id="table_databases" class="table table-bordered table-hover align-middle mb-0">
						<caption class="visually-hidden">List of Databases</caption>
						<thead class="table-light">
							<tr>
								<th scope="col">Database</th>
								<th scope="col" class="text-end">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_databases() as $database): ?>
								<tr>
									<td><?= $database->get_name() ?></td>
									<td class="text-end">
										<button class="btn btn-outline-danger btn-sm" onClick="delete_database($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
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
		<a href="#tab_research" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_search_string" class="btn btn-primary" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
