async function getRelatedTerms(term) {
	/* key_words - async function - consulta a wikipedia por termos similares ao pesquisado

	TODO: salvar no banco os resultados para evitar novas consultas e agilizar a busca

	args - string term - termo a ser pesquisado

	return - string array - termos relacionados a pesquisa
	*/

	if (!term) return null;

	let data;

	// 1. Search for the pageid
	data = await $.ajax({
		url: "https://en.wikipedia.org/w/api.php",
		method: "GET",
		dataType: "json",
		data: {
			origin: "*",
			action: "query",
			list: "search",
			srsearch: term,
			srlimit: 1,
			format: "json",
		},
	});

	const pageid = data.query.search[0].pageid;

	// 2. Get sections for the page
	data = await $.ajax({
		url: "https://en.wikipedia.org/w/api.php",
		method: "GET",
		dataType: "json",
		data: {
			origin: "*",
			action: "parse",
			prop: "sections",
			format: "json",
			pageid: pageid,
		},
	});

	const sections = data.parse.sections;
	let index = -1;
	for (let i = 0; i < sections.length; i++) {
		if (sections[i].anchor.match(/See\_also/)) {
			index = sections[i].index;
			break;
		}
	}
	if (index < 0) return null;

	// 3. Get links from the "See also" section
	data = await $.ajax({
		url: "https://en.wikipedia.org/w/api.php",
		method: "GET",
		dataType: "json",
		data: {
			origin: "*",
			action: "parse",
			prop: "links",
			format: "json",
			pageid: pageid,
			section: index,
		},
	});

	const terms = data.parse.links.map((i) => i["*"].replace(/.*\:/, ""));

	SwalAdapter.fire({
		title: "Terms Retrieved",
		text: "Related terms have been successfully fetched.",
		icon: "success",
	});
	return terms;
}

/*
exemplo de uso
terms = await getRelatedTerms("systematic review");
*/
