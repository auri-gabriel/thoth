<div class="tab-pane active container-fluid" role="tabpanel" id="tab_overall">
	<div class="row">

		<!-- Domains -->
		<div class="col-sm-12 col-md-6 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="domain" class="mb-0"><strong>Domains</strong></label>
						<a onclick="modal_help('modal_help_domain')" class="ms-auto opt" tabindex="0" aria-label="Help about domains" data-bs-toggle="tooltip" title="What are domains?"><i class="fas fa-question-circle"></i></a>
					</div>
					<div class="input-group mb-3">
						<input type="text" class="form-control" id="domain" placeholder="Add new domain" aria-label="Domain">
						<button type="button" class="btn btn-success" id="add_domain" onclick="add_domain();" data-bs-toggle="tooltip" title="Add domain">
							<span class="fas fa-plus"></span>
						</button>
					</div>
					<div class="table-responsive">
						<table id="table_domains" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Domains</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Domain</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_domains() as $domain): ?>
									<tr>
										<td><?= $domain ?></td>
										<td>
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_domain($(this).parents('tr'));"><span class="fas fa-edit"></span></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_domain($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Languages -->
		<div class="col-sm-12 col-md-6 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="language" class="mb-0"><strong>Languages</strong></label>
						<a onclick="modal_help('modal_help_languages')" class="ms-auto opt" tabindex="0" aria-label="Help about languages" data-bs-toggle="tooltip" title="Select languages relevant to your project"><i class="fas fa-question-circle"></i></a>
					</div>
					<div class="input-group mb-3">
						<select class="form-control" id="language" aria-label="Language">
							<?php foreach ($languages as $lang): ?>
								<option value="<?= $lang ?>"><?= $lang ?></option>
							<?php endforeach; ?>
						</select>
						<button class="btn btn-success" type="button" onclick="add_language();" data-bs-toggle="tooltip" title="Add language">
							<span class="fas fa-plus"></span>
						</button>
					</div>
					<div class="table-responsive">
						<table id="table_languages" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Languages</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Language</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_languages() as $language): ?>
									<tr>
										<td><?= $language ?></td>
										<td>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_language($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Study Types -->
		<div class="col-sm-12 col-md-6 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="study_type" class="mb-0"><strong>Study Type</strong></label>
						<a onclick="modal_help('modal_help_study_type')" class="ms-auto opt" tabindex="0" aria-label="Help about study type" data-bs-toggle="tooltip" title="Select the type of study"><i class="fas fa-question-circle"></i></a>
					</div>
					<div class="input-group mb-3">
						<select class="form-control" id="study_type" aria-label="Study Type">
							<?php foreach ($study_types as $types): ?>
								<option value="<?= $types ?>"><?= $types ?></option>
							<?php endforeach; ?>
						</select>
						<button class="btn btn-success" type="button" onclick="add_study_type();" data-bs-toggle="tooltip" title="Add study type">
							<span class="fas fa-plus"></span>
						</button>
					</div>
					<div class="table-responsive">
						<table id="table_study_type" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Study Type</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Study Type</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_study_types() as $types): ?>
									<tr>
										<td><?= $types ?></td>
										<td>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_study_type($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Keywords -->
		<div class="col-sm-12 col-md-6 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="keywords" class="mb-0"><strong>Keywords</strong></label>
						<a onclick="modal_help('modal_help_keyword')" class="ms-auto opt" tabindex="0" aria-label="Help about keywords" data-bs-toggle="tooltip" title="Add keywords relevant to your project"><i class="fas fa-question-circle"></i></a>
					</div>
					<div class="input-group mb-3">
						<input type="text" class="form-control" id="keywords" placeholder="Add new keyword" aria-label="Keyword">
						<button class="btn btn-success" type="button" onclick="add_keywords();" data-bs-toggle="tooltip" title="Add keyword">
							<span class="fas fa-plus"></span>
						</button>
					</div>
					<div class="table-responsive">
						<table id="table_keywords" class="table table-hover align-middle">
							<caption class="visually-hidden">List of Keywords</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Keyword</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_keywords() as $keyword): ?>
									<tr>
										<td><?= $keyword ?></td>
										<td>
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_keywords($(this).parents('tr'));"><span class="fas fa-edit"></span></button>
											<button class="btn btn-outline-danger btn-sm" onClick="delete_keywords($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Date Range -->
		<div class="col-sm-12 col-md-4 mb-4">
			<div class="card shadow-sm h-100">
				<div class="card-body">
					<div class="d-flex align-items-center mb-2">
						<label for="start_date" class="mb-0"><strong>Start and End Date</strong></label>
						<a onclick="modal_help('modal_help_date')" class="ms-auto opt" tabindex="0" aria-label="Help about date range" data-bs-toggle="tooltip" title="Select the project date range"><i class="fas fa-question-circle"></i></a>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text bg-success text-white"><span class="far fa-calendar-check"></span></span>
						<input type="date" id="start_date" class="form-control" title="Start Date" value="<?= $project->get_start_date() ?>" aria-label="Start Date">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text bg-danger text-white"><span class="far fa-calendar-check"></span></span>
						<input type="date" id="end_date" class="form-control" title="End Date" value="<?= $project->get_end_date() ?>" aria-label="End Date">
						<button class="btn btn-success" type="button" onclick="add_date()" data-bs-toggle="tooltip" title="Save date range">
							<span class="fas fa-check"></span>
						</button>
					</div>
				</div>
			</div>
		</div>

	</div>
	<br>
	<div class="d-flex justify-content-between align-items-center mt-4">
    <a href="#" class="btn btn-outline-secondary disabled" tabindex="-1" aria-disabled="true"><span class="fas fa-backward"></span> Previous</a>
    <a class="btn btn-primary" href="#tab_research" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
</div>
</div>
