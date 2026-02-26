$(document)
	.ajaxStart(function () {
		exibe_loading();
	})
	.ajaxStop(function () {
		remove_loading();
	});

$(document).ready(function () {
	base_url = $("#base_url").val();
	remove_loading();
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

	table_domains = $("#table_domains").DataTable(configDataTables);
	table_languages = $("#table_languages").DataTable(configDataTables);
	table_study_type = $("#table_study_type").DataTable(configDataTables);
	table_keywords = $("#table_keywords").DataTable(configDataTables);
	table_research_question = $("#table_research_question").DataTable(
		configDataTables,
	);
	table_databases = $("#table_databases").DataTable(configDataTables);
	table_search_string = $("#table_search_string").DataTable(configDataTables);
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

	table_imported_studies = $("#table_imported_studies").DataTable({
		responsive: true,
		order: [[1, "asc"]],
		paginate: false,
		info: false,
		searching: false,
		columnDefs: [{ orderable: false, targets: 2 }],
	});
	table_my_projects = $("#table_my_projects").DataTable({
		responsive: true,
		order: [[0, "asc"]],
		columnDefs: [{ orderable: false, targets: 2 }],
	});

	$("#tableSearch").DataTable({
		responsive: true,
		order: [[0, "asc"]],
		columnDefs: [{ orderable: false, targets: 2 }],
	});

	table_papers_quality_rep = $("#table_papers_quality_rep").DataTable({
		initComplete: function () {
			let size = this.api().columns().data().length;
			this.api()
				.columns(size - 1)
				.every(function () {
					let column = this;
					let select = $(
						'<select id="select_status5" class="form-control" ><option value=""></option></select>',
					)
						.appendTo($(column.footer()).empty())
						.on("change", function () {
							let val = $.fn.dataTable.util.escapeRegex($(this).val());

							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					select.append('<option value="Accepted">Accepted</option>');
					select.append('<option value="Rejected">Rejected</option>');
					select.append('<option value="Unclassified">Unclassified</option>');
					select.append('<option value="Removed">Removed</option>');
				});
		},
		responsive: true,
		order: [[0, "asc"]],
		select: {
			style: "single",
		},
		dom: "Bfrtip",
		buttons: [
			{ extend: "copy", text: '<i class="fas fa-copy fa-2x"></i>' },
			{ extend: "csv", text: '<i class="fas fa-file-csv fa-2x"></i>' },
			{ extend: "excel", text: '<i class="fas fa-file-excel fa-2x"></i>' },
			{ extend: "pdf", text: '<i class="fas fa-file-pdf fa-2x"></i>' },
			{ extend: "print", text: '<i class="fas fa-print fa-2x"></i>' },
		],
	});

	table_papers_quality = $("#table_papers_quality").DataTable({
		initComplete: function () {
			let size = this.api().columns().data().length;
			this.api()
				.columns(size - 1)
				.every(function () {
					let column = this;
					let select = $(
						'<select id="select_status5" class="form-control" ><option value=""></option></select>',
					)
						.appendTo($(column.footer()).empty())
						.on("change", function () {
							let val = $.fn.dataTable.util.escapeRegex($(this).val());

							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					select.append('<option value="Accepted">Accepted</option>');
					select.append('<option value="Rejected">Rejected</option>');
					select.append('<option value="Unclassified">Unclassified</option>');
					select.append('<option value="Removed">Removed</option>');
				});
		},
		responsive: true,
		order: [[0, "asc"]],
		select: {
			style: "single",
		},
		dom: "Bfrtip",
		buttons: [
			{ extend: "copy", text: '<i class="fas fa-copy fa-2x"></i>' },
			{ extend: "csv", text: '<i class="fas fa-file-csv fa-2x"></i>' },
			{ extend: "excel", text: '<i class="fas fa-file-excel fa-2x"></i>' },
			{ extend: "pdf", text: '<i class="fas fa-file-pdf fa-2x"></i>' },
			{ extend: "print", text: '<i class="fas fa-print fa-2x"></i>' },
		],
	});

	table_papers_extraction = $("#table_papers_extraction").DataTable({
		initComplete: function () {
			for (let i = 3; i < 5; i++) {
				this.api()
					.columns(i)
					.every(function () {
						let column = this;
						let select = $(
							'<select class="form-control" ><option value=""></option></select>',
						)
							.appendTo($(column.footer()).empty())
							.on("change", function () {
								let val = $.fn.dataTable.util.escapeRegex($(this).val());

								column.search(val ? "^" + val + "$" : "", true, false).draw();
							});

						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + "</option>");
							});
					});
			}
			this.api()
				.columns(5)
				.every(function () {
					let column = this;
					let select = $(
						'<select class="form-control" ><option value=""></option></select>',
					)
						.appendTo($(column.footer()).empty())
						.on("change", function () {
							let val = $.fn.dataTable.util.escapeRegex($(this).val());

							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					select.append('<option value="Done">Done</option>');
					select.append('<option value="To Do">To Do</option>');
					select.append('<option value="Removed">Removed</option>');
				});
		},
		responsive: true,
		order: [[0, "asc"]],
		select: {
			style: "single",
		},
		dom: "Bfrtip",
		buttons: [
			{ extend: "copy", text: '<i class="fas fa-copy fa-2x"></i>' },
			{ extend: "csv", text: '<i class="fas fa-file-csv fa-2x"></i>' },
			{ extend: "excel", text: '<i class="fas fa-file-excel fa-2x"></i>' },
			{ extend: "pdf", text: '<i class="fas fa-file-pdf fa-2x"></i>' },
			{ extend: "print", text: '<i class="fas fa-print fa-2x"></i>' },
		],
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
		exibe_loading();
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
