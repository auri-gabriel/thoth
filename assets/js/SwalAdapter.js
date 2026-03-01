// SwalAdapter.js
// Adapter to show Bootstrap Toasts or SweetAlert based on Swal.fire options
// Usage: SwalAdapter.fire(options)

const SwalAdapter = {
	fire: function (options) {
		// Decide if this should be a toast or a modal
		// Show toast for info/success/warning, modal for error/confirm
		const type = options.icon || options.type || "info";
		const hasConfirm =
			options.showConfirmButton ||
			options.showCancelButton ||
			options.confirmButtonText ||
			options.cancelButtonText;
		const isToast =
			["info", "success", "warning"].includes(type) &&
			!hasConfirm &&
			!options.input;
		if (isToast) {
			showBootstrapToast(options);
			// Return a resolved promise to mimic Swal.fire
			return Promise.resolve();
		} else {
			// Convert deprecated 'type' to 'icon' for SweetAlert2
			const swalOptions = { ...options };
			if (swalOptions.type && !swalOptions.icon) {
				swalOptions.icon = swalOptions.type;
				delete swalOptions.type;
			}
			return Swal.fire(swalOptions);
		}
	},
};

function showBootstrapToast(options) {
	// Ensure toast container exists
	let container = document.getElementById("swal-toast-container");
	if (!container) {
		container = document.createElement("div");
		container.id = "swal-toast-container";
		container.className = "swal-toast-container";
		document.body.appendChild(container);
	}

	const variant = normalizeToastVariant(options.icon || options.type || "info");

	// Create toast element
	const toast = document.createElement("div");
	toast.className = `toast thoth-toast thoth-toast--${variant} border-0`;
	toast.setAttribute("role", "alert");
	toast.setAttribute("aria-live", "assertive");
	toast.setAttribute("aria-atomic", "true");
	toast.setAttribute("data-bs-autohide", "true");

	const toastInner = document.createElement("div");
	toastInner.className = "d-flex align-items-start";

	const toastBody = document.createElement("div");
	toastBody.className = "toast-body thoth-toast-body";

	if (options.title) {
		const toastTitle = document.createElement("div");
		toastTitle.className = "thoth-toast-title";
		toastTitle.textContent = options.title;
		toastBody.appendChild(toastTitle);
	}

	if (options.text) {
		const toastText = document.createElement("div");
		toastText.className = "thoth-toast-text";
		toastText.textContent = options.text;
		toastBody.appendChild(toastText);
	}

	const closeButton = document.createElement("button");
	closeButton.type = "button";
	closeButton.className = "btn-close ms-2 me-2 mt-2";
	closeButton.setAttribute("data-bs-dismiss", "toast");
	closeButton.setAttribute("aria-label", "Close");

	toastInner.appendChild(toastBody);
	toastInner.appendChild(closeButton);
	toast.appendChild(toastInner);

	if (!options.title && !options.text) {
		toastBody.textContent = "Notification";
	}

	container.appendChild(toast);
	// Initialize Bootstrap Toast
	const bsToast = new bootstrap.Toast(toast, { delay: options.timer || 3000 });
	bsToast.show();
	// Remove toast after hidden
	toast.addEventListener("hidden.bs.toast", () => {
		toast.remove();
		// Remove container if empty
		if (container.childElementCount === 0) {
			container.remove();
		}
	});
}

function normalizeToastVariant(type) {
	const allowed = ["info", "success", "warning", "danger", "error"];
	const normalized = String(type || "info").toLowerCase();

	if (!allowed.includes(normalized)) {
		return "info";
	}

	return normalized === "error" ? "danger" : normalized;
}

// Export for use in other scripts
window.SwalAdapter = SwalAdapter;
