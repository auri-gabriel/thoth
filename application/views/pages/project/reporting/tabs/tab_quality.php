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
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('papers_per_quality', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Papers per Quality Status'
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
                        { name: 'Accepted', y: <?= $count_project[1] ?? 0 ?> },
                        { name: 'Rejected', y: <?= $count_project[2] ?? 0 ?> },
                        { name: 'Uncertain', y: <?= $count_project[3] ?? 0 ?> },
                        { name: 'Removed', y: <?= $count_project[4] ?? 0 ?> }
                    ]
                }]
            });
        });
        </script>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_gen_score"></div>
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('papers_gen_score', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'General Quality Score Distribution'
                },
                xAxis: {
                    categories: <?= isset($quality_score_categories) ? json_encode($quality_score_categories) : '[]' ?>,
                    title: {
                        text: 'Score'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number of Papers'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Papers',
                    data: <?= isset($quality_score_data) ? json_encode($quality_score_data) : '[]' ?>
                }]
            });
        });
        </script>
    </div>
</div>
