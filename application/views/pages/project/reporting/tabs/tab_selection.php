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
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('papers_per_selection', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Papers per Selection Status'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
                        }
                    }
                },
                series: [{
                    name: 'Papers',
                    colorByPoint: true,
                    data: [
                        { name: 'Accepted', y: <?= $count_project_sel[1] ?? 0 ?> },
                        { name: 'Rejected', y: <?= $count_project_sel[2] ?? 0 ?> },
                        { name: 'Uncertain', y: <?= $count_project_sel[3] ?? 0 ?> },
                        { name: 'Duplicated', y: <?= $count_project_sel[4] ?? 0 ?> },
                        { name: 'Removed', y: <?= $count_project_sel[5] ?? 0 ?> }
                    ]
                }]
            });
        });
        </script>
    </div>
</div>
