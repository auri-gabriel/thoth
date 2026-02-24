<div class="tab-pane active container-fluid bg-light" role="tabpanel" id="tab_overall">
	<div class="row">

		<!-- Domains -->
		<div class="col-sm-12 col-md-6">
			<label for="domain"><strong>Domains</strong></label>
			<a onclick="modal_help('modal_help_domain')" class="float-right opt"><i class="fas fa-question-circle"></i></a>
			<div class="input-group">
				<input type="text" class="form-control" id="domain">
				<div class="input-group-append">
					<button type="button" class="btn btn-success" id="add_domain" onclick="add_domain();">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
			<br>
			<table id="table_domains" class="table table-responsive-sm">
				<caption>List of Domains</caption>
				<thead>
					<tr>
						<th>Domain</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($project->get_domains() as $domain): ?>
						<tr>
							<td><?= $domain ?></td>
							<td>
								<button class="btn btn-warning opt" onClick="modal_domain($(this).parents('tr'));">
									<span class="fas fa-edit"></span>
								</button>
								<button class="btn btn-danger" onClick="delete_domain($(this).parents('tr'));">
									<span class="far fa-trash-alt"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- Languages -->
		<div class="col-sm-12 col-md-6">
			<label for="language"><strong>Select languages</strong></label>
			<a onclick="modal_help('modal_help_languages')" class="float-right opt"><i class="fas fa-question-circle"></i></a>
			<div class="input-group">
				<select class="form-control" id="language">
					<?php foreach ($languages as $lang): ?>
						<option value="<?= $lang ?>"><?= $lang ?></option>
					<?php endforeach; ?>
				</select>
				<div class="input-group-append">
					<button class="btn btn-success" type="button" onclick="add_language();">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
			<br>
			<table id="table_languages" class="table table-responsive-sm">
				<caption>List of Languages</caption>
				<thead>
					<tr>
						<th>Language</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($project->get_languages() as $language): ?>
						<tr>
							<td><?= $language ?></td>
							<td>
								<button class="btn btn-danger" onClick="delete_language($(this).parents('tr'));">
									<span class="far fa-trash-alt"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<br>

		<!-- Study Types -->
		<div class="col-sm-12 col-md-6">
			<label for="study_type"><strong>Select study type</strong></label>
			<a onclick="modal_help('modal_help_study_type')" class="float-right opt"><i class="fas fa-question-circle"></i></a>
			<div class="input-group">
				<select class="form-control" id="study_type">
					<?php foreach ($study_types as $types): ?>
						<option value="<?= $types ?>"><?= $types ?></option>
					<?php endforeach; ?>
				</select>
				<div class="input-group-append">
					<button class="btn btn-success" type="button" onclick="add_study_type();">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
			<br>
			<table id="table_study_type" class="table table-responsive-sm">
				<caption>List of Study Type</caption>
				<thead>
					<tr>
						<th>Study Type</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($project->get_study_types() as $types): ?>
						<tr>
							<td><?= $types ?></td>
							<td>
								<button class="btn btn-danger" onClick="delete_study_type($(this).parents('tr'));">
									<span class="far fa-trash-alt"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- Keywords -->
		<div class="col-sm-12 col-md-6">
			<label for="keywords"><strong>Keywords</strong></label>
			<a onclick="modal_help('modal_help_keyword')" class="float-right opt"><i class="fas fa-question-circle"></i></a>
			<div class="input-group">
				<input type="text" class="form-control" id="keywords">
				<div class="input-group-append">
					<button class="btn btn-success" type="button" onclick="add_keywords();">
						<span class="fas fa-plus"></span>
					</button>
				</div>
			</div>
			<br>
			<table id="table_keywords" class="table table-responsive-sm">
				<caption>List of Keywords</caption>
				<thead>
					<tr>
						<th>Keyword</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($project->get_keywords() as $keyword): ?>
						<tr>
							<td><?= $keyword ?></td>
							<td>
								<button class="btn btn-warning opt" onClick="modal_keywords($(this).parents('tr'));">
									<span class="fas fa-edit"></span>
								</button>
								<button class="btn btn-danger" onClick="delete_keywords($(this).parents('tr'));">
									<span class="far fa-trash-alt"></span>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- Date Range -->
		<div class="col-sm-12 col-md-4">
			<label for="start_date"><strong>Start and End Date</strong></label>
			<a onclick="modal_help('modal_help_date')" class="float-right opt"><i class="fas fa-question-circle"></i></a>
			<div class="input-group">
				<div class="input-group-prepend">
					<button class="btn btn-success"><span class="far fa-calendar-check"></span></button>
				</div>
				<input type="Date" id="start_date" class="form-control" title="Start Date"
					   value="<?= $project->get_start_date() ?>">
			</div>
			<div class="input-group">
				<button class="btn btn-danger"><span class="far fa-calendar-check"></span></button>
				<input type="Date" id="end_date" class="form-control" title="End Date"
					   value="<?= $project->get_end_date() ?>">
				<div class="input-group-append">
					<button class="btn btn-success" type="button" onclick="add_date()">
						<span class="fas fa-check"></span>
					</button>
				</div>
			</div>
		</div>

	</div>
	<br>
	<div class="form-inline container-fluid justify-content-between">
		<a href="#" class="btn btn-secondary disabled"><span class="fas fa-backward"></span> Previous</a>
		<a class="btn btn-secondary" href="#tab_research">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
