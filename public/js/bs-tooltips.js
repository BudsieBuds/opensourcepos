// Bootstrap 6 - Initialize all tooltips on a page
(() => {
    'use strict';
    const initTooltips = () => {
        const Tooltip = window.bootstrap?.Tooltip;
        if (Tooltip) {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].forEach(tooltipTriggerEl => Tooltip.getOrCreateInstance(tooltipTriggerEl));
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTooltips);
    } else {
        initTooltips();
    }
})();
