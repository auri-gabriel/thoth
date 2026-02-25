<style>
td.file-name {
  max-width: 150px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>
<div class="form-inline">
    <label for="database_import"><strong>Import Studies</strong></label>
    <a class="float-right opt"><i class="fas fa-question-circle "></i></a>
</div>
<div class="form-inline">
    <div class="input-group col-md-3">
        <label for="database_import" class="col-sm-12">Database</label>
        <select class="form-control" id="database_import">
            <?php foreach ($project->get_databases() as $database) { ?>
                <option><?= $database->get_name() ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="input-group col-md-6">
        <label for="upload_bib" class="col-sm-12">Choose file</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="upload_bib" accept=".bib,.csv"
                   onchange="change_name()">
            <label class="custom-file-label" id="name_bib_upload" for="upload_bib"></label>
        </div>
        <div class="input-group-append">
            <button class="btn btn-success" type="button" onclick="readFileAsString();"><span
                    class="fas fa-plus"></span>
            </button>
        </div>
    </div>
</div>
<br>
<table id="table_imported_studies" class="table table-responsive-sm">
    <caption>List of Imports of Data Tables</caption>
    <thead>
    <tr>
        <th>Database</th>
        <th>Imported Studies</th>
        <th>Files Imported</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($project->get_databases() as $database) { ?>
        <tr>
            <td><?= $database->get_name() ?></td>
            <td><?= $num_papers[$database->get_name()] ?></td>
            <td>
                <table id="table_<?= $database->get_name() ?>" class="table">
                    <th>File</th>
                    <th>Delete</th>
                    <tbody>
                    <?php foreach ($bib[$database->get_name()] as $b) { ?>
                        <tr>
                            <td class="file-name"><?= $b ?></td>
                            <td style="width: 1%;">
                                <button class="btn btn-danger" onClick="delete_bib(this)">
                                    <span class="far fa-trash-alt"></span>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
