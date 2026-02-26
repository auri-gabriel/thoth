$(document).ready(function () {
	table_imported_studies = $("#table_imported_studies").DataTable({
		responsive: true,
		order: [[1, "asc"]],
		paginate: false,
		info: false,
		searching: false,
		columnDefs: [{ orderable: false, targets: 2 }],
	});
});
