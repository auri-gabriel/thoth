$(document)
	.ajaxStart(function () {
		showLoading();
	})
	.ajaxStop(function () {
		hideLoading();
	});

$(document).ready(function () {
	base_url = $("#base_url").val();
	hideLoading();
	let lang = {
		sZeroRecords: "No options added",
	};

	let configDataTables = {
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: false,
		info: false,
		searching: false,
		ordering: false,
	};

	table_members = $("#table_members").DataTable(configDataTables);

	table_conf_paper_selection = $("#table_conf_paper_selection").DataTable({
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: true,
		info: true,
		searching: true,
		ordering: true,
		select: {
			style: "single",
		},
	});

	table_conf_paper_qa = $("#table_conf_paper_qa").DataTable({
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: true,
		info: true,
		searching: true,
		ordering: true,
		select: {
			style: "single",
		},
	});

	table_qa_eva = $("#table_qa_eva").DataTable({
		columnDefs: [
			{
				orderable: false,
				targets: 2,
			},
			{
				width: "20%",
				orderable: false,
				targets: 3,
			},
		],
		autoWidth: false,
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: false,
		info: false,
		searching: false,
	});
	table_qa_eva_conf = $("#table_qa_eva_conf").DataTable({
		columnDefs: [
			{
				orderable: false,
				targets: 2,
			},
			{
				width: "20%",
				orderable: false,
				targets: 3,
			},
		],
		autoWidth: false,
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: false,
		info: false,
		searching: false,
	});
	table_qa_answer = $("#table_qa_answer").DataTable({
		columnDefs: [
			{
				orderable: false,
				targets: 2,
			},
			{
				width: "20%",
				orderable: false,
				targets: 3,
			},
		],
		autoWidth: false,
		language: lang,
		responsive: true,
		order: [[0, "asc"]],
		paginate: false,
		info: false,
		searching: false,
	});

	table_general_score = $("#table_general_score").DataTable(configDataTables);
	table_criteria_inclusion = $("#table_criteria_inclusion").DataTable(
		configDataTables,
	);
	table_criteria_exclusion = $("#table_criteria_exclusion").DataTable(
		configDataTables,
	);
	table_qa = $("#table_qa").DataTable(configDataTables);
	table_data_extraction = $("#table_data_extraction").DataTable(
		configDataTables,
	);

	table_my_projects = $("#table_my_projects").DataTable({
		responsive: true,
		order: [[0, "asc"]],
		columnDefs: [{ orderable: false, targets: 2 }],
	});

	$("#table_search").DataTable({
		responsive: true,
		order: [[0, "asc"]],
		columnDefs: [{ orderable: false, targets: 2 }],
	});

	// Bootstrap 5 tab navigation with hash support
	if (location.hash) {
		var triggerEl = document.querySelector("a[href='" + location.hash + "']");
		if (triggerEl) {
			var tab = new bootstrap.Tab(triggerEl);
			tab.show();
		}
	}
	$(document.body).on("click", "a[data-bs-toggle]", function (event) {
		location.hash = this.getAttribute("href");
	});

	$("#add_email_user").select2({
		placeholder: "Select an email",
		allowClear: true,
	});

	$("#protocol").select2({
		placeholder: "Select an project to copy planning",
		allowClear: true,
	});

	$("#add_level_user").select2({
		placeholder: "Select an level",
		allowClear: true,
	});

	$(window).on("beforeunload", function () {
		showLoading();
	});
	$(window).on("popstate", function () {
		var anchor =
			location.hash || $("a[data-bs-toggle='pill']").first().attr("href");
		var triggerEl = document.querySelector("a[href='" + anchor + "']");
		if (triggerEl) {
			var tab = new bootstrap.Tab(triggerEl);
			tab.show();
		}
	});
});

function validate_text(value) {
	if (/[^a-zA-Z0-9\-\/]/.test(value)) {
		return false;
	}

	return true;
}
