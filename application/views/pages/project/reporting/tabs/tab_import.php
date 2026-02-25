<?php // Import Studies tab for reporting ?>

<script>
$(document).ready(function () {
    Highcharts.chart('papers_per_database', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Papers per Database'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
        },
        plotOptions: {
            column: {
                colorByPoint: true
            },
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: <?= json_encode($databases); ?>
        }]
    });
});
</script>

<div class="card">
    <div class="card-body">
        <div id="papers_per_database"></div>
    </div>
</div>
