<?php // Quality Assessment tab for reporting ?>

<script>
$(document).ready(function () {
    Highcharts.chart('papers_per_quality', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Papers per Status Quality'
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
            data: <?= json_encode($status_qa); ?>
        }]
    });
    Highcharts.chart('papers_gen_score', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Papers per General Score'
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
            data: <?= json_encode($gen_score); ?>
        }]
    });
});
</script>

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
