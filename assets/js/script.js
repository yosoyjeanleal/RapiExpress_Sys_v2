document.querySelector('select[name="sucursal"]').addEventListener('change', function () {
    const telefonoInput = document.querySelector('input[name="telefono"]');
    const sucursal = this.value;

    if (sucursal === 'sucursal_usa') {
        telefonoInput.pattern = "^\\+1\\s*\\d{3}\\s*\\d{3}\\s*\\d{4}$";
        telefonoInput.placeholder = jt('js_phone_placeholder_usa', "+1 212 555 1234");
        telefonoInput.title = jt('js_phone_title_usa', "Expected format: +1 212 555 1234 (spaces optional)");
    } else if (sucursal === 'sucursal_ven') {
        telefonoInput.pattern = "^\\+58\\s*\\d{3}\\s*\\d{7}$";
        telefonoInput.placeholder = jt('js_phone_placeholder_ven', "+58 212 5551234");
        telefonoInput.title = jt('js_phone_title_ven', "Expected format: +58 212 5551234 (spaces optional)");
    } else if (sucursal === 'sucursal_ec') {
        telefonoInput.pattern = "^\\+593\\s*9\\s*\\d{8}$";
        telefonoInput.placeholder = jt('js_phone_placeholder_ec', "+593 9 87654321");
        telefonoInput.title = jt('js_phone_title_ec', "Expected format: +593 9 87654321 (spaces optional)");
    } else {
        telefonoInput.removeAttribute("pattern");
        telefonoInput.placeholder = jt('phone_placeholder', "Your phone number"); // Using existing key
        telefonoInput.title = ""; // No specific title for default
    }
});

// Global function to show Bootstrap toasts
function showToast(message, type = 'info', title = '') {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        console.error('Toast container not found!');
        return;
    }

    const toastId = 'toast-' + Date.now();
    let toastHeaderClass = 'bg-info text-white';
    let toastIconHtml = '<i class="fas fa-info-circle mr-2"></i>'; // Font Awesome icon

    switch (type.toLowerCase()) {
        case 'success':
            toastHeaderClass = 'bg-success text-white';
            toastIconHtml = '<i class="fas fa-check-circle mr-2"></i>';
            title = title || jt('toast_title_success', 'Success');
            break;
        case 'error':
            toastHeaderClass = 'bg-danger text-white';
            toastIconHtml = '<i class="fas fa-times-circle mr-2"></i>';
            title = title || jt('toast_title_error', 'Error');
            break;
        case 'warning':
            toastHeaderClass = 'bg-warning text-dark'; // text-dark for better contrast on yellow
            toastIconHtml = '<i class="fas fa-exclamation-triangle mr-2"></i>';
            title = title || jt('toast_title_warning', 'Warning');
            break;
        default: // 'info' or any other
            title = title || jt('toast_title_info', 'Information');
            break;
    }

    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" data-autohide="true">
            <div class="toast-header ${toastHeaderClass}">
                ${toastIconHtml}
                <strong class="mr-auto">${title}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="${jt('button_close', 'Close')}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHtml);

    // Initialize and show the toast using jQuery (as Bootstrap's JS plugin for toast relies on jQuery)
    // This assumes jQuery is loaded before this script.
    if (window.jQuery) {
        $('#' + toastId).toast('show');
        // Optional: Remove the toast from DOM after it's hidden to prevent buildup
        $('#' + toastId).on('hidden.bs.toast', function () {
            $(this).remove();
        });
    } else {
        console.error('jQuery not found, cannot show Bootstrap toast.');
    }
}
