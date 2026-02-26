// SwalAdapter.js
// Adapter to show Bootstrap Toasts or SweetAlert based on Swal.fire options
// Usage: SwalAdapter.fire(options)

const SwalAdapter = {
	fire: function (options) {
		// Decide if this should be a toast or a modal
		// Show toast for info/success/warning, modal for error/confirm
		const type = options.icon || options.type || "info";
		const isToast =
			["info", "success", "warning"].includes(type) &&
			!options.showConfirmButton &&
			!options.input;
		if (isToast) {
			showBootstrapToast(options);
			// Return a resolved promise to mimic Swal.fire
			return Promise.resolve();
		} else {
			// Fallback to SweetAlert
			return Swal.fire(options);
		}
	},
};

function showBootstrapToast(options) {
	// Create toast element
	const toast = document.createElement("div");
	toast.className =
		"toast align-items-center text-bg-" +
		(options.icon || "info") +
		" border-0";
	toast.setAttribute("role", "alert");
	toast.setAttribute("aria-live", "assertive");
	toast.setAttribute("aria-atomic", "true");
	toast.style.position = "fixed";
	toast.style.top = "1rem";
	toast.style.right = "1rem";
	toast.style.zIndex = 1060;

	toast.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">
        ${options.title ? `<strong>${options.title}</strong><br>` : ""}
        ${options.text || ""}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;

	document.body.appendChild(toast);
	// Initialize Bootstrap Toast
	const bsToast = new bootstrap.Toast(toast, { delay: options.timer || 3000 });
	bsToast.show();
	// Remove toast after hidden
	toast.addEventListener("hidden.bs.toast", () => {
		toast.remove();
	});
}

// Export for use in other scripts
window.SwalAdapter = SwalAdapter;
