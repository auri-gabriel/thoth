<style>
	td.file-name {
		max-width: 150px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
</style>

<div class="container-fluid py-4">
	<div class="row justify-content-center">
		<div class="card shadow-sm h-100">
			<div class="card-body">
				<div class="d-flex align-items-center mb-2">
					<label for="database_import" class="mb-0"><strong>Import Studies</strong></label>
					<a onclick="modal_help('modal_help_import')" class="ms-auto opt" tabindex="0" aria-label="Help about import studies" data-bs-toggle="tooltip" title="How to import studies?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="row g-2 mb-3">
					<div class="col-md-4">
						<label for="database_import" class="form-label">Database</label>
						<select class="form-control" id="database_import">
							<?php foreach ($project->get_databases() as $database) { ?>
								<option><?= $database->get_name() ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-8">
						<label for="upload_bib" class="form-label">Choose file</label>
						<div class="input-group">
							<input type="file" class="form-control" id="upload_bib" accept=".bib,.csv">
							<button class="btn btn-success" type="button" onclick="readFileAsString();" data-bs-toggle="tooltip" title="Add file">
								<span class="fas fa-plus"></span>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive mt-4">
					<table id="table_imported_studies" class="table table-bordered table-hover align-middle">
						<caption class="visually-hidden">List of Imports of Data Tables</caption>
						<thead class="table-light">
							<tr>
								<th>Database</th>
								<th>Imported Studies</th>
								<th>Files Imported</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_databases() as $database) { ?>
								<tr>
									<td><?= $database->get_name() ?></td>
									<td><?= $num_papers[$database->get_name()] ?></td>
									<td>
										<table id="table_<?= $database->get_name() ?>" class="table table-bordered table-sm mb-0">
											<thead class="table-light">
												<tr>
													<th>File</th>
													<th>Delete</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($bib[$database->get_name()] as $b) { ?>
													<tr>
														<td class="file-name"><?= $b ?></td>
														<td style="width: 1%;">
															<button class="btn btn-outline-danger btn-sm" onClick="delete_bib(this)" data-bs-toggle="tooltip" title="Delete file">
																<span class="far fa-trash-alt"></span>
															</button>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_data_extraction" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_study_selection" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
<script src="<?= base_url('assets/js/import_studies.js'); ?>"></script>