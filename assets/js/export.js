$(document).ready(function () {
	$("input[name='inlineRadioOptions']").click(function () {
		let step = $("input[name='inlineRadioOptions']:checked").val();

		let id_project = $("#id_project").val();
		$.ajax({
			type: "POST",
			url: base_url + "project_export/export_bib",
			data: {
				id_project: id_project,
				step: step,
			},
			error: function () {
				Swal.fire({
					type: "error",
					title: "Error",
					html: 'Something caused an <label class="font-weight-bold text-danger">Error</label>',
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
			},
			success: function (bib) {
				$("#bib_tex").val(bib);
				Swal.fire({
					title: "Generate Bib",
					html: "<strong>BibTex file generated</strong>",
					type: "success",
					showCancelButton: false,
					confirmButtonText: "Ok",
				});
			},
		});
	});

	$("input:checkbox[name=step]").on("change", function () {
		let steps = [];
		$("input:checkbox[name=step]:checked").each(function () {
			steps.push($(this).val());
		});

		let id_project = $("#id_project").val();
		if (steps.length > 0) {
			$.ajax({
				type: "POST",
				url: base_url + "project_export/export_latex",
				data: {
					id_project: id_project,
					steps: steps,
				},
				error: function () {
					Swal.fire({
						type: "error",
						title: "Error",
						html: 'Something caused an <label class="font-weight-bold text-danger">Error</label>',
						showCancelButton: false,
						confirmButtonText: "Ok",
					});
				},
				success: function (latex) {
					console.log(latex);

					$("#text_area-latex").val(latex);
					Swal.fire({
						title: "Generate Latex",
						html: "<strong>LaTex file generated</strong>",
						type: "success",
						showCancelButton: false,
						confirmButtonText: "Ok",
					});
				},
			});
		} else {
			$("#text_area-latex").val("");
		}
	});
});

function export_bib() {
	let element = $("#bib_tex");

	let data = new Blob([element.val()], { type: "text/plain" });

	let url = window.URL.createObjectURL(data);

	document.getElementById("export_bib").href = url;
}
