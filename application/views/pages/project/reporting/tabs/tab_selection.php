<?php // Study Selection tab for reporting
?>
<div class="card">
    <div class="card-body">
        <?php foreach ($project->get_members() as $member) {
            // ...existing code...
        } ?>
        <?php
        $acc = number_format((float)($count_project_sel[1] * 100) / $count_project_sel[6], 2);
        $rej = number_format((float)($count_project_sel[2] * 100) / $count_project_sel[6], 2);
        $unc = number_format((float)($count_project_sel[3] * 100) / $count_project_sel[6], 2);
        $dup = number_format((float)($count_project_sel[4] * 100) / $count_project_sel[6], 2);
        $rem = number_format((float)($count_project_sel[5] * 100) / $count_project_sel[6], 2);
        ?>
        <h5 class="text-center"><?= $project->get_title(); ?></h5>
        <div class="progress">
            <!-- ...existing code... -->
        </div>
        <br>
        <div class="form-inline">
            <!-- ...existing code... -->
        </div>
        <br>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_per_selection"></div>
    </div>
</div>
