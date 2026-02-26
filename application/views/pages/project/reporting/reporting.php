<div class="container py-4">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'reporting', 'is_owner' => true]); ?>
		<div class="card-body bg-light">
			<h4>Reporting</h4>
			<?php $this->load->view('pages/project/reporting/partials/tab_nav'); ?>
		</div>
		<div class="tab-content p-3">
			<div class="tab-pane fade show active container-fluid" id="tab_overview" role="tabpanel" aria-labelledby="tab_overview-tab">
				<?php $this->load->view('pages/project/reporting/tabs/tab_overview'); ?>
			</div>
			<div class="tab-pane fade container-fluid" id="tab_import" role="tabpanel" aria-labelledby="tab_import-tab">
				<div class="card">
					<div class="card-body">
						<div id="import_tab_papers_per_database"></div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade container-fluid" id="tab_selection" role="tabpanel" aria-labelledby="tab_selection-tab">
				<?php $this->load->view('pages/project/reporting/tabs/tab_selection'); ?>
			</div>
			<div class="tab-pane fade container-fluid" id="tab_quality" role="tabpanel" aria-labelledby="tab_quality-tab">
				<?php $this->load->view('pages/project/reporting/tabs/tab_quality'); ?>
			</div>
			<?php if (isset($project) && $project->get_extraction() > 0): ?>
				<div class="tab-pane fade container-fluid" id="tab_extraction" role="tabpanel" aria-labelledby="tab_extraction-tab">
					<div id="extraction_content"></div>
					<?php $this->load->view('pages/project/reporting/tabs/tab_extraction'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Overview tab charts
		if (document.getElementById('overview_tab_funnel')) {
			Highcharts.chart('overview_tab_funnel', {
				chart: {
					type: 'funnel'
				},
				title: {
					text: '<?= $project->get_title() ?> Funnel'
				},
				plotOptions: {},
				legend: {
					enabled: false
				},
				series: [<?= json_encode($funnel) ?>],
				responsive: {
					rules: [{
						condition: {
							maxWidth: 500
						},
						chartOptions: {}
					}]
				}
			});
		}
		if (document.getElementById('overview_tab_act')) {
			Highcharts.chart('overview_tab_act', {
				chart: {
					type: 'line'
				},
				title: {
					text: 'Failure of Daily Project Activities'
				},
				xAxis: {
					categories: <?= json_encode($activity['categories']) ?>
				},
				yAxis: {},
				plotOptions: {},
				series: <?= json_encode($activity['series']) ?>
			});
		}
		if (document.getElementById('overview_tab_papers_per_database')) {
			Highcharts.chart('overview_tab_papers_per_database', {
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
		}
		if (document.getElementById('overview_tab_papers_per_selection')) {
			Highcharts.chart('overview_tab_papers_per_selection', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Papers per Status Selection'
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
		}
		if (document.getElementById('overview_tab_papers_per_quality')) {
			Highcharts.chart('overview_tab_papers_per_quality', {
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
		}
		if (document.getElementById('overview_tab_papers_gen_score')) {
			Highcharts.chart('overview_tab_papers_gen_score', {
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
		}

		// Import tab chart
		if (document.querySelector('#import_tab_papers_per_database')) {
			Highcharts.chart('import_tab_papers_per_database', {
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
		}

		// Selection tab chart
		if (document.querySelector('#selection_tab_papers_per_selection')) {
			Highcharts.chart('selection_tab_papers_per_selection', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Papers per Status Selection'
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
		}

		// Quality tab charts
		if (document.querySelector('#quality_tab_papers_per_quality')) {
			Highcharts.chart('quality_tab_papers_per_quality', {
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
		}
		if (document.querySelector('#quality_tab_papers_gen_score')) {
			Highcharts.chart('quality_tab_papers_gen_score', {
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
		}

		// Extraction tab charts
		if (document.getElementById('tab_extraction')) {
			let qe = null;
			<?php if ($project->get_extraction() > 0) {
				foreach ($extraction as $qe) { ?>
					qe = new Extraction_Chars('<?= $qe['id'] ?>', '<?= $qe['type'] ?>', <?= json_encode($qe['data']) ?>);
					qe.show();
				<?php }
				foreach ($multiple as $qe) { ?>
					qe = new Extraction_Chars('<?= $qe['id'] ?>', '<?= $qe['type'] ?>', <?= json_encode($qe['data']) ?>);
					qe.show();
			<?php }
			} ?>
		}
	});
</script>
</div>