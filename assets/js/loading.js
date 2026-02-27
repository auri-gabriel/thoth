let loadingShownAt = null;
const MIN_LOADING_TIME = 400; // ms
let hideLoadingTimeout = null;
let loadingFailsafeTimeout = null;
const MAX_LOADING_TIME = 10000; // ms (failsafe)

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
	// Failsafe: always remove after MAX_LOADING_TIME
	loadingFailsafeTimeout = setTimeout(hideLoading, MAX_LOADING_TIME);

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

	// Remove overlay
	overlay.parentNode.removeChild(overlay);
	loadingShownAt = null;
	// Clear any pending timeouts
	if (hideLoadingTimeout) {
		clearTimeout(hideLoadingTimeout);
		hideLoadingTimeout = null;
	}
	if (loadingFailsafeTimeout) {
		clearTimeout(loadingFailsafeTimeout);
		loadingFailsafeTimeout = null;
	}
};
