<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
	<meta property="og:url" content="http://www.lesse.com.br/tools/thoth" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content=" " />
	<meta property="og:author" content="Lesse" />
	<meta property="og:description" content="SLR Tool" />
	<title> Thoth </title>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png'); ?>" />

	<!-- Bootstrap (legacy, can be removed after migration) -->
	<!-- <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>"> -->

	<!-- New SCSS Theme (Bootstrap 5 + custom) -->
	<link rel="stylesheet" href="<?= base_url('assets/css/theme.css'); ?>">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
		integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

	<!-- DataTables (Bootstrap 5) from npm/node_modules -->
	<link rel="stylesheet" href="<?= base_url('assets/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'); ?>">
	<link rel="stylesheet" href="<?= base_url('assets/node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css'); ?>">

	<!-- SweetAlert2 (from node_modules) -->
	<link rel="stylesheet" href="<?= base_url('assets/node_modules/sweetalert2/dist/sweetalert2.min.css'); ?>">

	<!-- Select2 (from node_modules) -->
	<link rel="stylesheet" href="<?= base_url('assets/node_modules/select2/dist/css/select2.min.css'); ?>">

	<!-- My CSS Files (legacy, can be removed after migration) -->
	<!-- <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>"> -->
	<link rel="preload" href="<?= base_url('assets/img/loading.gif'); ?>" as="image">

	<!-- JQuery-->
	<script src="<?= base_url('assets/node_modules/jquery/dist/jquery.min.js'); ?>"></script>

	<!-- Bootstrap 5 (from node_modules via symlink) -->
	<script src="<?= base_url('assets/node_modules/@popperjs/core/dist/umd/popper.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>

	<!-- DataTables (Bootstrap 5) from npm/node_modules -->
	<script src="<?= base_url('assets/node_modules/datatables.net/js/dataTables.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-select/js/dataTables.select.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-select-bs5/js/select.bootstrap5.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/jszip/dist/jszip.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/pdfmake/build/pdfmake.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/pdfmake/build/vfs_fonts.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/datatables.net-buttons/js/buttons.colVis.min.js'); ?>"></script>


	<!-- Highcharts (latest, from node_modules via symlink) -->
	<script src="<?= base_url('assets/node_modules/highcharts/highcharts.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/highcharts-more.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/series-label.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/funnel.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/venn.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/exporting.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/export-data.js'); ?>"></script>
	<script src="<?= base_url('assets/node_modules/highcharts/modules/pattern-fill.js'); ?>"></script>


	<!-- SweetAlert2 (from node_modules) -->
	<script src="<?= base_url('assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js'); ?>"></script>

	<!-- Select2 (from node_modules) -->
	<script src="<?= base_url('assets/node_modules/select2/dist/js/select2.full.min.js'); ?>"></script>

	<!-- Bib2Json -->
	<script src="<?= base_url('assets/js/bib2json.js'); ?>"></script>

	<!-- My JS Files -->
	<script src="<?= base_url('assets/js/loading.js'); ?>"></script>
	<script src="<?= base_url('assets/js/main.js'); ?>"></script>
	<script src="<?= base_url('assets/js/title.js'); ?>"></script>
	<script src="<?= base_url('assets/js/database.js'); ?>"></script>
	<script src="<?= base_url('assets/js/search_string.js'); ?>"></script>
	<script src="<?= base_url('assets/js/criteria.js'); ?>"></script>
	<script src="<?= base_url('assets/js/project.js'); ?>"></script>
	<script src="<?= base_url('assets/js/help.js'); ?>"></script>
	<script src="<?= base_url('assets/js/objects/Extraction_Chars.js'); ?>"></script>
	<script src="<?= base_url('assets/js/objects/Extraction_Answer.js'); ?>"></script>
	<script src="<?= base_url('assets/js/export.js'); ?>"></script>
	<script src="<?= base_url('assets/js/terms.js'); ?>"></script>
	<script src="<?= base_url('assets/js/SwalAdapter.js'); ?>"></script>

</head>

<body>
	<div id="loading" class="load">
		<img src="<?= base_url('assets/img/loading.gif'); ?>">
	</div>