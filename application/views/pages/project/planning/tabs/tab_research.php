<div class="tab-pane container-fluid" role="tabpanel" id="tab_research">
	<div class="form-inline">
		<label for="id_research_question"><strong>Research Questions</strong></label>
		<span onclick="modal_help('modal_help_rq')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</span>
	</div>
	<div class="form-inline">
		<div class="input-group opt col-sm-12 col-md-2">
			<label for="id_research_question" class="col-md-12">ID</label>
			<input type="text" id="id_research_question" placeholder="ID" class="form-control">
		</div>
		<div class="input-group opt col-sm-12 col-md-8">
			<label for="description_research_question" class="col-md-12">Description</label>
			<input type="text" id="description_research_question" placeholder="Description" class="form-control">
			<div class="input-group-append">
				<button class="btn btn-success" type="button" onclick="add_research_question();">
					<span class="fas fa-plus"></span>
				</button>
			</div>
		</div>
	</div>
	<br>
	<table id="table_research_question" class="table table-responsive-sm">
		<caption>List of Research Questions</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Research Question</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($project->get_research_questions() as $rq): ?>
				<tr>
					<td><?= $rq->get_id() ?></td>
					<td><?= $rq->get_description() ?></td>
					<td>
						<button class="btn btn-warning opt" onClick="modal_research_question($(this).parents('tr'));">
							<span class="fas fa-edit"></span>
						</button>
						<button class="btn btn-danger opt" onClick="delete_research_question($(this).parents('tr'));">
							<span class="far fa-trash-alt"></span>
						</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<br>
	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_overall" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_databases" class="btn btn-secondary">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
