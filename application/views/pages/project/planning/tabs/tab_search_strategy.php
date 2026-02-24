<div class="tab-pane container-fluid bg-light" role="tabpanel" id="tab_search_strategy">
	<div class="form-inline">
		<label for="search_strategy"><strong>Search Strategy</strong></label>
		<a onclick="modal_help('modal_help_strategy')" class="float-right opt">
			<i class="fas fa-question-circle"></i>
		</a>
	</div>
	<textarea rows="8" class="form-control" id="search_strategy"><?= $project->get_search_strategy() ?></textarea>
	<button class="btn btn-success opt float-right" type="button" onclick="edit_search_strategy()">Save</button>
	<div class="form-inline container-fluid justify-content-between">
		<a href="#tab_search_string" class="btn btn-secondary"><span class="fas fa-backward"></span> Previous</a>
		<a href="#tab_criteria" class="btn btn-secondary opt">Next <span class="fas fa-forward"></span></a>
	</div>
</div>
