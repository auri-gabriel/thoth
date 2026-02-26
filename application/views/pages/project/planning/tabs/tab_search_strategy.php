<?php $readonly = (isset($readonly) && $readonly === true); ?>
<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_search_strategy">
	<div class="row justify-content-center">

		<div class="card shadow-sm">
			<div class="card-header bg-transparent border-bottom d-flex align-items-center py-3">
				<strong>Search Strategy</strong>
				<a onclick="modal_help('modal_help_strategy')" class="ms-auto text-secondary opt" tabindex="0" aria-label="Help about search strategy" data-bs-toggle="tooltip" title="What is a search strategy?"><i class="fas fa-question-circle"></i></a>
			</div>
			<div class="card-body">
				<textarea rows="8" class="form-control mb-3" id="search_strategy" aria-label="Search Strategy" <?= $readonly ? 'readonly' : '' ?>><?= $project->get_search_strategy() ?></textarea>
				<?php if (!$readonly): ?>
					<div class="d-flex justify-content-end">
						<button class="btn btn-success opt" type="button" onclick="edit_search_strategy()" data-bs-toggle="tooltip" title="Save search strategy">
							<i class="fas fa-save me-1"></i> Save
						</button>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-5">
		<a href="#tab_search_string" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><i class="fas fa-backward me-1"></i> Previous</a>
		<a href="#tab_criteria" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <i class="fas fa-forward ms-1"></i></a>
	</div>
</div>