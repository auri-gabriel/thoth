<?php // Study Selection tab for reporting ?>

<script>
$(document).ready(function () {
    Highcharts.chart('papers_per_selection', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Papers per Selection Status'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: <?= json_encode($status_selection); ?>
        }]
    });
});
</script>

<div class="card">
    <div class="card-body">
        <div id="papers_per_selection"></div>
    </div>
</div>
