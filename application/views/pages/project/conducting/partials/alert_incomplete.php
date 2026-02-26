<div class="alert alert-warning container-fluid alert-dismissible fade show" role="alert">
    <h5>Complete these tasks to advance</h5>
    <ul>
        <?php foreach ($project->get_errors() as $error) { ?>
            <li><?= $error ?></li>
        <?php } ?>
    </ul>
</div>
