<?php // Quality Assessment tab for reporting
?>
<div class="card">
    <div class="card-body">
        <?php foreach ($project->get_members() as $member) {
            // ...existing code...
        }
        $acc = number_format((float)($count_project[1] * 100) / $count_project[5], 2);
        $rej = number_format((float)($count_project[2] * 100) / $count_project[5], 2);
        $unc = number_format((float)($count_project[3] * 100) / $count_project[5], 2);
        $rem = number_format((float)($count_project[4] * 100) / $count_project[5], 2);
        ?>
        <h5 class="text-center"><?= $project->get_title(); ?></h5>
        <div class="progress">
            <!-- ...existing code... -->
        </div>
        <br>
        <div class="form-inline">
            <!-- ...existing code... -->
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <table class="table table-responsive-sm" id="table_papers_quality_rep">
            <!-- ...existing code... -->
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_per_quality"></div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_gen_score"></div>
    </div>
</div>
