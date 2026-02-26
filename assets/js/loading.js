let loadingShownAt = null;
const MIN_LOADING_TIME = 400; // ms
let hideLoadingTimeout = null;

const showLoading = (autoRemove = null) => {
	/*
		Displays a modern CSS throbber
		@param autoRemove = Integer - number in milliseconds to automatically remove the loading.
	*/

	if (!Number.isInteger(autoRemove) && autoRemove) {
		throw "argument should be an integer";
		return;
	}

	if (document.getElementById("loading")) {
		return;
	}

	const overlay = document.createElement("div");
	overlay.id = "loading";
	overlay.style.zIndex = "9999";
	overlay.style.display = "flex";
	overlay.style.alignItems = "center";
	overlay.style.justifyContent = "center";
	overlay.style.backgroundColor = "rgba(0,0,0,0.5)";
	overlay.style.width = "100%";
	overlay.style.height = "100%";
	overlay.style.position = "fixed";
	overlay.style.top = 0;
	overlay.style.left = 0;

	// Create the throbber
	const throbber = document.createElement("div");
	throbber.className = "throbber";

	// Add the throbber to the overlay
	overlay.appendChild(throbber);

	document.body.appendChild(overlay);

	loadingShownAt = Date.now();
	hideLoadingTimeout = null;

	if (autoRemove) {
		setTimeout(hideLoading, autoRemove);
	}
};

const hideLoading = () => {
	/*
		Removes the loading throbber, ensuring a minimum display time
	*/
	const overlay = document.getElementById("loading");
	if (!overlay) return;

	const elapsed = Date.now() - (loadingShownAt || 0);
	if (elapsed < MIN_LOADING_TIME) {
		if (hideLoadingTimeout) return; // Already scheduled
		hideLoadingTimeout = setTimeout(hideLoading, MIN_LOADING_TIME - elapsed);
		return;
	}

	overlay.parentNode.removeChild(overlay);
	loadingShownAt = null;
	hideLoadingTimeout = null;
};
