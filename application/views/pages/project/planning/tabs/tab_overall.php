<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane active container-fluid py-4" role="tabpanel" id="tab_overall">
	<div class="row g-4">

		<!-- Domains -->
		<div class="col-sm-12 col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
					<strong>Domains</strong>
					<a onclick="modal_help('modal_help_domain')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about domains" data-bs-toggle="tooltip" title="What are domains?"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="card-body">
					<?php if (!$readonly): ?>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="domain" placeholder="Add new domain" aria-label="Domain">
							<button type="button" class="btn btn-success" id="add_domain" onclick="add_domain();" data-bs-toggle="tooltip" title="Add domain">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table id="table_domains" class="table table-bordered table-hover align-middle mb-0">
							<caption class="visually-hidden">List of Domains</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Domain</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_domains() as $domain): ?>
									<tr>
										<td><?= $domain ?></td>
										<?php if (!$readonly): ?>
											<td class="text-end">
												<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_domain($(this).parents('tr'));"><i class="fas fa-edit"></i></button>
												<button class="btn btn-outline-danger btn-sm" onClick="delete_domain($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Languages -->
		<div class="col-sm-12 col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
					<strong>Languages</strong>
					<a onclick="modal_help('modal_help_languages')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about languages" data-bs-toggle="tooltip" title="Select languages relevant to your project"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="card-body">
					<?php if (!$readonly): ?>
						<div class="input-group mb-3">
							<select class="form-select" id="language" aria-label="Language">
								<?php foreach ($languages as $lang): ?>
									<option value="<?= $lang ?>"><?= $lang ?></option>
								<?php endforeach; ?>
							</select>
							<button class="btn btn-success" type="button" onclick="add_language();" data-bs-toggle="tooltip" title="Add language">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table id="table_languages" class="table table-bordered table-hover align-middle mb-0">
							<caption class="visually-hidden">List of Languages</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Language</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Delete</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_languages() as $language): ?>
									<tr>
										<td><?= $language ?></td>
										<?php if (!$readonly): ?>
											<td class="text-end">
												<button class="btn btn-outline-danger btn-sm" onClick="delete_language($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Study Types -->
		<div class="col-sm-12 col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
					<strong>Study Type</strong>
					<a onclick="modal_help('modal_help_study_type')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about study type" data-bs-toggle="tooltip" title="Select the type of study"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="card-body">
					<?php if (!$readonly): ?>
						<div class="input-group mb-3">
							<select class="form-select" id="study_type" aria-label="Study Type">
								<?php foreach ($study_types as $types): ?>
									<option value="<?= $types ?>"><?= $types ?></option>
								<?php endforeach; ?>
							</select>
							<button class="btn btn-success" type="button" onclick="add_study_type();" data-bs-toggle="tooltip" title="Add study type">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table id="table_study_type" class="table table-bordered table-hover align-middle mb-0">
							<caption class="visually-hidden">List of Study Type</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Study Type</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Delete</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_study_types() as $types): ?>
									<tr>
										<td><?= $types ?></td>
										<?php if (!$readonly): ?>
											<td class="text-end">
												<button class="btn btn-outline-danger btn-sm" onClick="delete_study_type($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Keywords -->
		<div class="col-sm-12 col-md-6">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
					<strong>Keywords</strong>
					<a onclick="modal_help('modal_help_keyword')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about keywords" data-bs-toggle="tooltip" title="Add keywords relevant to your project"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="card-body">
					<?php if (!$readonly): ?>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="keywords" placeholder="Add new keyword" aria-label="Keyword">
							<button class="btn btn-success" type="button" onclick="add_keywords();" data-bs-toggle="tooltip" title="Add keyword">
								<i class="fas fa-plus"></i>
							</button>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table id="table_keywords" class="table table-bordered table-hover align-middle mb-0">
							<caption class="visually-hidden">List of Keywords</caption>
							<thead class="table-light">
								<tr>
									<th scope="col">Keyword</th>
									<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($project->get_keywords() as $keyword): ?>
									<tr>
										<td><?= $keyword ?></td>
										<?php if (!$readonly): ?>
											<td class="text-end">
												<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_keywords($(this).parents('tr'));"><i class="fas fa-edit"></i></button>
												<button class="btn btn-outline-danger btn-sm" onClick="delete_keywords($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Date Range -->
		<div class="col-sm-12 col-md-4">
			<div class="card shadow-sm h-100">
				<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
					<strong>Start and End Date</strong>
					<a onclick="modal_help('modal_help_date')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about date range" data-bs-toggle="tooltip" title="Select the project date range"><i class="fas fa-question-circle"></i></a>
				</div>
				<div class="card-body">
					<label class="form-label text-muted small">Start Date</label>
					<div class="input-group mb-3">
						<span class="input-group-text bg-success text-white"><i class="far fa-calendar-check"></i></span>
						<input type="date" id="start_date" class="form-control" title="Start Date" value="<?= $project->get_start_date() ?>" aria-label="Start Date" <?= $readonly ? 'disabled' : '' ?>>
					</div>
					<label class="form-label text-muted small">End Date</label>
					<div class="input-group">
						<span class="input-group-text bg-danger text-white"><i class="far fa-calendar-check"></i></span>
						<input type="date" id="end_date" class="form-control" title="End Date" value="<?= $project->get_end_date() ?>" aria-label="End Date" <?= $readonly ? 'disabled' : '' ?>>
						<?php if (!$readonly): ?>
							<button class="btn btn-success" type="button" onclick="add_date()" data-bs-toggle="tooltip" title="Save date range">
								<i class="fas fa-check"></i>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#" class="btn btn-outline-secondary disabled" tabindex="-1" aria-disabled="true"><i class="fas fa-backward me-1"></i> Previous</a>
		<a class="btn btn-primary" href="#tab_research" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>

<script src="<?= base_url('assets/js/overall.js'); ?>"></script>