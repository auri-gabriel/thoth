// Conducting tabs AJAX loader
$(document).ready(function () {
	function loadTabContent(tabId, url, projectId) {
		var $tabPane = $(tabId);
		$tabPane.html(
			'<div class="text-center py-4"><span class="spinner-border"></span> Loading...</div>',
		);
		$.get(url, { id: projectId }, function (data) {
			$tabPane.html(data);
		}).fail(function () {
			$tabPane.html('<div class="text-danger">Failed to load content.</div>');
		});
	}

	// Map tab IDs to controller endpoints
	var projectId = $("#conducting-tabs").data("project-id");
	var tabEndpoints = {
		"#tab_import": "/projects/conducting/import",
		"#tab_selection": "/projects/conducting/selection",
		"#tab_extraction": "/projects/conducting/extraction",
	};

	// Initial load for active tab
	var $activeTab = $(".conducting-tabs-nav .nav-link.active");
	var activeTabId = $activeTab.attr("href");
	if (tabEndpoints[activeTabId]) {
		loadTabContent(activeTabId, tabEndpoints[activeTabId], projectId);
	}

	// Tab click handler
	$(".conducting-tabs-nav .nav-link").on("shown.bs.tab", function (e) {
		var tabId = $(this).attr("href");
		if (tabEndpoints[tabId]) {
			loadTabContent(tabId, tabEndpoints[tabId], projectId);
		}
	});
});
