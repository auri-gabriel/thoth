<?php // Overview tab for reporting ?>

<script>
$(document).ready(function () {
    Highcharts.chart('funnel', {
        chart: { type: 'funnel' },
        title: { text: '<?=$project->get_title()?> Funnel' },
        plotOptions: {
            series: {
                dataLabels: {
                    softConnector: true
                },
                center: ['40%', '50%'],
                neckWidth: '30%',
                neckHeight: '25%',
                width: '80%'
            }
        },
        legend: { enabled: false },
        series: [<?=json_encode($funnel)?>],
        responsive: {
            rules: [{
                condition: { maxWidth: 500 },
                chartOptions: {}
            }]
        }
    });
    Highcharts.chart('act', {
        chart: { type: 'line' },
        title: { text: 'Failure of Daily Project Activities' },
        xAxis: { categories: <?=json_encode($activity['categories'])?> },
        yAxis: { title: { text: 'Activities' } },
        plotOptions: {
            line: {
                dataLabels: { enabled: true },
                enableMouseTracking: false
            }
        },
        series:  <?=json_encode($activity['series'])?>
    });
    Highcharts.chart('papers_per_database', {
        chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
        title: { text: 'Papers per Database' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
        plotOptions: {
            column: { colorByPoint: true },
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{ name: 'Brands', colorByPoint: true, data: <?= json_encode($databases); ?> }]
    });
    Highcharts.chart('papers_per_selection', {
        chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
        title: { text: 'Papers per Status Selection' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{ name: 'Brands', colorByPoint: true, data: <?= json_encode($status_selection); ?> }]
    });
    Highcharts.chart('papers_per_quality', {
        chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
        title: { text: 'Papers per Status Quality' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{ name: 'Brands', colorByPoint: true, data: <?= json_encode($status_qa); ?> }]
    });
    Highcharts.chart('papers_gen_score', {
        chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
        title: { text: 'Papers per General Score' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {}
            }
        },
        series: [{ name: 'Brands', colorByPoint: true, data: <?= json_encode($gen_score); ?> }]
    });
    let qe = null;
    <?php if ($project->get_extraction() > 0) {
    foreach ($extraction as $qe){ ?>
        qe = new Extraction_Chars('<?=$qe['id']?>', '<?=$qe['type']?>',<?=json_encode($qe['data'])?>);
        qe.show();
    <?php }
    foreach ($multiple as $qe){ ?>
        qe = new Extraction_Chars('<?=$qe['id']?>', '<?=$qe['type']?>',<?=json_encode($qe['data'])?>);
        qe.show();
    <?php }
    } ?>
});
</script>

<div class="card">
    <div class="card-body">
        <div id="funnel"></div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="act"></div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_per_database"></div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <div id="papers_per_selection"></div>
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
