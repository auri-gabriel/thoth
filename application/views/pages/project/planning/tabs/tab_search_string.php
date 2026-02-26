<div class="tab-pane container-fluid py-4" role="tabpanel" id="tab_search_string">
    <div class="row justify-content-center">

        <div class="card shadow-sm h-100 bg-light">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <label for="term" class="mb-0"><strong>Search String</strong></label>
                    <a onclick="modal_help('modal_help_ss')" class="ms-auto opt" tabindex="0" aria-label="Help about search string" data-bs-toggle="tooltip" title="What is a search string?"><i class="fas fa-question-circle"></i></a>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label for="term" class="form-label">Term</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="term" aria-label="Term">
                            <button class="btn btn-success" type="button" onclick="add_term();" data-bs-toggle="tooltip" title="Add term">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2 mt-4">
                    <label for="list_term" class="mb-0"><strong>Synonym</strong></label>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label for="list_term" class="form-label">Term</label>
                        <select class="form-control" id="list_term" onchange="related_terms(this.value);" aria-label="Select term">
                            <option value="" disabled selected>Select term</option>
                            <?php foreach ($project->get_terms() as $term): ?>
                                <option value="<?= $term->get_description() ?>"><?= $term->get_description() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="synonym" class="form-label">Synonym</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Add a Synonym to Term" id="synonym" aria-label="Synonym">
                            <button class="btn btn-success" type="button" onclick="add_synonym();" data-bs-toggle="tooltip" title="Add synonym">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="related-terms"></div>
                <div class="table-responsive mt-4">
                    <table id="table_search_string" class="table table-hover align-middle">
                        <caption class="visually-hidden">List of Term</caption>
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Term</th>
                                <th scope="col">Synonyms</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project->get_terms() as $term): ?>
                                <tr>
                                    <td><?= $term->get_description() ?></td>
                                    <td>
                                        <table id="table_<?= $term->get_description() ?>" class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Synonym</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($term->get_synonyms() as $synonym): ?>
                                                    <tr>
                                                        <td><?= $synonym ?></td>
                                                        <td>
                                                            <button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_synonym(this)"><span class="fas fa-edit"></span></button>
                                                            <button class="btn btn-outline-danger btn-sm" onClick="delete_synonym(this)"><span class="far fa-trash-alt"></span></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm opt me-1" onClick="modal_term($(this).parents('tr'))"><span class="fas fa-edit"></span></button>
                                        <button class="btn btn-outline-danger btn-sm" onClick="delete_term($(this).parents('tr'));"><span class="far fa-trash-alt"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 mb-2">
                    <h6><strong><a target="_blank" href="https://stringimprover.herokuapp.com/index.html">String Improver</a></strong></h6>
                </div>
                <div id="strings">
                    <div class="d-flex align-items-center mb-2">
                        <label class="mb-0"><strong>Strings</strong></label>
                        <a onclick="modal_help('modal_help_strings')" class="ms-auto opt" tabindex="0" aria-label="Help about strings" data-bs-toggle="tooltip" title="What are strings?"><i class="fas fa-question-circle"></i></a>
                    </div>
                    <?php foreach ($project->get_search_strings() as $search_string): ?>
                        <div class="form-group mb-4" id="div_string_<?= $search_string->get_database()->get_name() ?>">
                            <a target="_blank" href="<?= $search_string->get_database()->get_link() ?>">
                                <?= $search_string->get_database()->get_name() ?>
                            </a>
                            <textarea class="form-control mt-2 mb-2" id="string_<?= $search_string->get_database()->get_name() ?>" aria-label="String for <?= $search_string->get_database()->get_name() ?>"><?= $search_string->get_description() ?></textarea>
                            <button type="button" class="btn btn-info opt" onclick="generate_string('<?= $search_string->get_database()->get_name() ?>');" data-bs-toggle="tooltip" title="Generate string">
                                Generate
                            </button>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <a href="#tab_databases" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Go to previous step"><span class="fas fa-backward"></span> Previous</a>
        <a href="#tab_search_strategy" class="btn btn-primary opt" data-bs-toggle="tooltip" title="Go to next step">Next <span class="fas fa-forward"></span></a>
    </div>
</div>