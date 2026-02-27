<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_research_questions">
	<div class="row justify-content-center">

		<div class="card shadow-sm">
			<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
				<strong>Research Questions</strong>
				<span onclick="modal_help('modal_help_rq')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about research questions" data-bs-toggle="tooltip" title="What are research questions?"><i class="fas fa-question-circle"></i></span>
			</div>
			<div class="card-body">
				<?php if (!$readonly): ?>
					<div class="row g-3 mb-2">
						<div class="col-md-2">
							<label for="id_research_question" class="form-label">ID</label>
							<input type="text" id="id_research_question" placeholder="ID" class="form-control" aria-label="Research Question ID">
						</div>
						<div class="col-md-8">
							<label for="description_research_question" class="form-label">Description</label>
							<div class="input-group">
								<input type="text" id="description_research_question" placeholder="Description" class="form-control" aria-label="Research Question Description">
								<button class="btn btn-success" type="button" onclick="add_research_question();" data-bs-toggle="tooltip" title="Add research question">
									<i class="fas fa-plus"></i>
								</button>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="table-responsive mt-3">
					<table id="table_research_question" class="table table-bordered table-hover align-middle mb-0">
						<caption class="visually-hidden">List of Research Questions</caption>
						<thead class="table-light">
							<tr>
								<th scope="col" style="width:10%">ID</th>
								<th scope="col">Research Question</th>
								<?php if (!$readonly): ?><th scope="col" class="text-end">Actions</th><?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($project->get_research_questions() as $rq): ?>
								<tr>
									<td><?= $rq->get_id() ?></td>
									<td><?= $rq->get_description() ?></td>
									<?php if (!$readonly): ?>
										<td class="text-end">
											<button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_research_question($(this).parents('tr'));"><i class="fas fa-edit"></i></button>
											<button class="btn btn-outline-danger btn-sm opt" onClick="delete_research_question($(this).parents('tr'));"><i class="far fa-trash-alt"></i></button>
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
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_overall" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_databases" class="btn btn-primary" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>
<script src="<?= base_url('assets/js/research_question.js'); ?>"></script>