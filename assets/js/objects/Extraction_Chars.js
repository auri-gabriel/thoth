class Extraction_Chars {
	constructor(id, type, data, parentId = "tab_data_extraction_charts") {
		this.id = id;
		this.type = type;
		this.data = data;
		this.parentId = parentId;
		this.char = null;
	}

	show() {
		let parent = document.getElementById(this.parentId);
		if (!parent) {
			return;
		}

		const chartId = `${this.id}_${this.type.replace(/\s+/g, "_").toLowerCase()}`;
		if (document.getElementById(chartId)) {
			return;
		}

		let card = document.createElement("div");
		card.classList.add("card");

		let card_body = document.createElement("div");
		card_body.classList.add("card-body");

		let div_char = document.createElement("div");
		div_char.id = chartId;

		let br = document.createElement("br");

		card_body.appendChild(div_char);
		card.appendChild(card_body);
		parent.appendChild(card);
		parent.appendChild(br);

		switch (this.type) {
			case "Multiple Choice List":
				this.char = Highcharts.chart(chartId, {
					series: [
						{
							type: "venn",
							name: "Answers to the question " + this.id,
							data: this.data,
						},
					],
					title: {
						text: "Answers to the question " + this.id,
					},
				});

				console.log(this.data);
				break;
			case "Pick One List":
				this.char = Highcharts.chart(chartId, {
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						type: "pie",
					},
					title: {
						text: "Answers to the question " + this.id,
					},
					tooltip: {
						pointFormat:
							"{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})",
					},
					plotOptions: {
						column: {
							colorByPoint: true,
						},
						pie: {
							allowPointSelect: true,
							cursor: "pointer",
							dataLabels: {
								enabled: true,
								format: "<b>{point.name}</b>: {point.percentage:.1f} %",
								style: {
									color:
										(Highcharts.theme && Highcharts.theme.contrastTextColor) ||
										"black",
								},
							},
						},
					},
					series: [
						{
							name: "Brands",
							colorByPoint: true,
							data: this.data,
						},
					],
				});
				break;
		}
	}
}
