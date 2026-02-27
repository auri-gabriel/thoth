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
		container.style.position = "fixed";
		container.style.bottom = "1rem";
		container.style.right = "1rem";
		container.style.zIndex = 1060;
		container.style.display = "flex";
		container.style.flexDirection = "column";
		container.style.gap = "0.5rem";
		document.body.appendChild(container);
	}

	// Create toast element
	const toast = document.createElement("div");
	toast.className =
		"toast align-items-center text-bg-" +
		(options.icon || "info") +
		" border-0";
	toast.setAttribute("role", "alert");
	toast.setAttribute("aria-live", "assertive");
	toast.setAttribute("aria-atomic", "true");

	toast.innerHTML = `
		<div class="d-flex">
			<div class="toast-body">
				${options.title ? `<strong>${options.title}</strong><br>` : ""}
				${options.text || ""}
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
	`;

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

// Export for use in other scripts
window.SwalAdapter = SwalAdapter;
