<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_research">
    <div class="row justify-content-center">

        <div class="card shadow-sm h-100 bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <label for="id_research_question" class="mb-0"><strong>Research Questions</strong></label>
                    <span onclick="modal_help('modal_help_rq')" class="ms-auto opt" tabindex="0" aria-label="Help about research questions" data-bs-toggle="tooltip" title="What are research questions?"><i class="fas fa-question-circle"></i></span>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-2">
                        <label for="id_research_question" class="form-label">ID</label>
                        <input type="text" id="id_research_question" placeholder="ID" class="form-control" aria-label="Research Question ID">
                    </div>
                    <div class="col-md-8">
                        <label for="description_research_question" class="form-label">Description</label>
                        <div class="input-group">
                            <input type="text" id="description_research_question" placeholder="Description" class="form-control" aria-label="Research Question Description">
                            <button class="btn btn-success" type="button" onclick="add_research_question();" data-bs-toggle="tooltip" title="Add research question">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table_research_question" class="table table-hover align-middle">
                        <caption class="visually-hidden">List of Research Questions</caption>
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Research Question</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project->get_research_questions() as $rq): ?>
                                <tr>
                                    <td><?= $rq->get_id() ?></td>
                                    <td><?= $rq->get_description() ?></td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_research_question($(this).parents('tr'));"><span class="fas fa-edit"></span></button>
                                        <button class="btn btn-outline-danger btn-sm opt" onClick="delete_research_question($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
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
        <a href="#tab_overall" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
        <a href="#tab_databases" class="btn btn-primary" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
    </div>
</div>