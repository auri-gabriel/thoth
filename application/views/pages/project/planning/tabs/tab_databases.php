<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_databases">
    <div class="row justify-content-center">

        <div class="card shadow-sm h-100 bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <label for="databases" class="mb-0"><strong>Data Bases</strong></label>
                    <a onclick="modal_help('modal_help_database')" class="ms-auto opt" tabindex="0" aria-label="Help about databases" data-bs-toggle="tooltip" title="What are databases?"><i class="fas fa-question-circle"></i></a>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-3">
                        <label for="databases" class="form-label">Database</label>
                        <div class="input-group">
                            <select class="form-control" id="databases" aria-label="Database">
                                <?php foreach ($databases as $database): ?>
                                    <option value="<?= $database ?>"><?= $database ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-success" type="button" onclick="add_database();" data-bs-toggle="tooltip" title="Add database">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="new_database" class="form-label">Other Database</label>
                        <input type="text" class="form-control" id="new_database" aria-label="Other Database">
                    </div>
                    <div class="col-md-4">
                        <label for="new_database_link" class="form-label">Other Database Link</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="new_database_link" aria-label="Other Database Link">
                            <button class="btn btn-success" type="button" onclick="new_database();" data-bs-toggle="tooltip" title="Add other database">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table_databases" class="table table-hover align-middle">
                        <caption class="visually-hidden">List of Databases</caption>
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Database</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project->get_databases() as $database): ?>
                                <tr>
                                    <td><?= $database->get_name() ?></td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm" onClick="delete_database($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
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
        <a href="#tab_research" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
        <a href="#tab_search_string" class="btn btn-primary" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
    </div>
</div>