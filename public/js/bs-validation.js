// Bootstrap 6 - form validation
(() => {
    'use strict';

    // Fetch all the forms with data-bs-validate
    const forms = document.querySelectorAll('form[data-bs-validate]');

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        }, false);
    });
})();
