<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_search_strategy">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 mb-4">
            <div class="card shadow-sm h-100 bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <label for="search_strategy" class="mb-0"><strong>Search Strategy</strong></label>
                        <a onclick="modal_help('modal_help_strategy')" class="ms-auto opt" tabindex="0" aria-label="Help about search strategy" data-bs-toggle="tooltip" title="What is a search strategy?"><i class="fas fa-question-circle"></i></a>
                    </div>
                    <textarea rows="8" class="form-control mb-3" id="search_strategy" aria-label="Search Strategy"><?= $project->get_search_strategy() ?></textarea>
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-success opt" type="button" onclick="edit_search_strategy()" data-bs-toggle="tooltip" title="Save search strategy">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <a href="#tab_search_string" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
        <a href="#tab_criteria" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
    </div>
</div>
