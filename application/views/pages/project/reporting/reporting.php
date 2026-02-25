<div class="container py-4">
	<div class="card">
		<?php $this->load->view('pages/project/partials/card_header', ['active_tab' => 'reporting']); ?>
		<?php $this->load->view('pages/project/reporting/partials/tab_nav'); ?>
		<div class="card-body">
			<div class="tab-content">
				<div class="tab-pane fade show active container-fluid" id="tab_overview" role="tabpanel" aria-labelledby="tab_overview-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_overview'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_import" role="tabpanel" aria-labelledby="tab_import-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_import'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_selection" role="tabpanel" aria-labelledby="tab_selection-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_selection'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_quality" role="tabpanel" aria-labelledby="tab_quality-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_quality'); ?>
				</div>
				<div class="tab-pane fade container-fluid" id="tab_extraction" role="tabpanel" aria-labelledby="tab_extraction-tab">
					<?php $this->load->view('pages/project/reporting/tabs/tab_extraction'); ?>
				</div>
			</div>
		</div>
	</div>


		<script>
		$(document).ready(function () {
			// Overview tab charts
			if ($('#funnel').length) {
				Highcharts.chart('funnel', {
					chart: { type: 'funnel' },
					title: { text: '<?=$project->get_title()?> Funnel' },
					plotOptions: {},
					legend: { enabled: false },
					series: [<?=json_encode($funnel)?>],
					responsive: {
						rules: [{
							condition: { maxWidth: 500 },
							chartOptions: {}
						}]
					}
				});
			}
			if ($('#act').length) {
				Highcharts.chart('act', {
					chart: { type: 'line' },
					title: { text: 'Failure of Daily Project Activities' },
					xAxis: { categories: <?=json_encode($activity['categories'])?> },
					yAxis: {},
					plotOptions: {},
					series: <?=json_encode($activity['series'])?>
				});
			}
			if ($('#papers_per_database').length) {
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
			}
			if ($('#papers_per_selection').length) {
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
			}
			if ($('#papers_per_quality').length) {
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
			}
			if ($('#papers_gen_score').length) {
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
			}
			// Extraction tab charts
			if ($('#tab_extraction').length) {
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
			}
		});
		</script>
				<script>
				// Chart data from PHP
				const chartData = {
					overview: {
						funnel: <?= json_encode($funnel ?? null) ?>,
						activity: {
							categories: <?= json_encode($activity['categories'] ?? []) ?>,
							series: <?= json_encode($activity['series'] ?? []) ?>
						},
						databases: <?= json_encode($databases ?? []) ?>,
						status_selection: <?= json_encode($status_selection ?? []) ?>,
						status_qa: <?= json_encode($status_qa ?? []) ?>,
						gen_score: <?= json_encode($gen_score ?? []) ?>
					},
					import: {
						databases: <?= json_encode($databases ?? []) ?>
					},
					selection: {
						status_selection: <?= json_encode($status_selection ?? []) ?>
					},
					quality: {
						status_qa: <?= json_encode($status_qa ?? []) ?>,
						gen_score: <?= json_encode($gen_score ?? []) ?>
					},
					extraction: {
						extraction: <?= json_encode($extraction ?? []) ?>,
						multiple: <?= json_encode($multiple ?? []) ?>
					}
				};

				const chartInit = {
					overview: false,
					import: false,
					selection: false,
					quality: false,
					extraction: false
				};

				function renderOverviewCharts() {
					Highcharts.chart('funnel', {
						chart: { type: 'funnel' },
						title: { text: '<?= isset($project) ? $project->get_title() : '' ?> Funnel' },
						legend: { enabled: false },
						series: [chartData.overview.funnel],
						responsive: { rules: [{ condition: { maxWidth: 500 }, chartOptions: {} }] }
					});
					Highcharts.chart('act', {
						chart: { type: 'line' },
						title: { text: 'Failure of Daily Project Activities' },
						xAxis: { categories: chartData.overview.activity.categories },
						yAxis: {},
						series: chartData.overview.activity.series
					});
					Highcharts.chart('papers_per_database', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per Database' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: {
							column: { colorByPoint: true },
							pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} }
						},
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.overview.databases }]
					});
					Highcharts.chart('papers_per_selection', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per Status Selection' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.overview.status_selection }]
					});
					Highcharts.chart('papers_per_quality', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per Status Quality' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.overview.status_qa }]
					});
					Highcharts.chart('papers_gen_score', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per General Score' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.overview.gen_score }]
					});
				}

				function renderImportCharts() {
					Highcharts.chart('papers_per_database', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per Database' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: {
							column: { colorByPoint: true },
							pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} }
						},
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.import.databases }]
					});
				}

				function renderSelectionCharts() {
					Highcharts.chart('papers_per_selection', {
						chart: { type: 'pie' },
						title: { text: 'Papers per Selection Status' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.selection.status_selection }]
					});
				}

				function renderQualityCharts() {
					Highcharts.chart('papers_per_quality', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per Status Quality' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.quality.status_qa }]
					});
					Highcharts.chart('papers_gen_score', {
						chart: { plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, type: 'pie' },
						title: { text: 'Papers per General Score' },
						tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})' },
						plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: {} } },
						series: [{ name: 'Brands', colorByPoint: true, data: chartData.quality.gen_score }]
					});
				}

				function renderExtractionCharts() {
					// Remove previous content
					const container = document.getElementById('extraction_content');
					if (container) container.innerHTML = '';
					// Render Extraction_Chars for each extraction
					<?php if (isset($project) && $project->get_extraction() > 0):
						foreach ($extraction ?? [] as $qe): ?>
							(new Extraction_Chars('<?= $qe['id'] ?>', '<?= $qe['type'] ?>', <?= json_encode($qe['data']) ?>)).show();
					<?php endforeach;
						foreach ($multiple ?? [] as $qe): ?>
							(new Extraction_Chars('<?= $qe['id'] ?>', '<?= $qe['type'] ?>', <?= json_encode($qe['data']) ?>)).show();
					<?php endforeach;
					endif; ?>
				}

				function handleTabShow(e) {
					const tabId = e.target.getAttribute('href');
					if (!tabId) return;
					if (tabId === '#tab_overview' && !chartInit.overview) {
						renderOverviewCharts(); chartInit.overview = true;
					} else if (tabId === '#tab_import' && !chartInit.import) {
						renderImportCharts(); chartInit.import = true;
					} else if (tabId === '#tab_selection' && !chartInit.selection) {
						renderSelectionCharts(); chartInit.selection = true;
					} else if (tabId === '#tab_quality' && !chartInit.quality) {
						renderQualityCharts(); chartInit.quality = true;
					} else if (tabId === '#tab_extraction' && !chartInit.extraction) {
						renderExtractionCharts(); chartInit.extraction = true;
					}
				}

				// Bootstrap 5 tab event
				document.addEventListener('DOMContentLoaded', function() {
					// Render the default active tab (overview)
					renderOverviewCharts(); chartInit.overview = true;
					const tabEls = document.querySelectorAll('a[data-bs-toggle="tab"]');
					tabEls.forEach(function(tab) {
						tab.addEventListener('shown.bs.tab', handleTabShow);
					});
				});
				</script>
</div>
