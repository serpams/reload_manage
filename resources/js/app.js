import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('focus-next-input', eventData => {
        const currentInput = document.querySelector(`[name="${eventData.input}"]`);
        const tableRow = currentInput.closest('tr');
        const nextRow = tableRow.nextElementSibling;

        if (nextRow) {
            const nextInput = nextRow.querySelector(`[name="${eventData.input}"]`);

            if (nextInput) {
                nextInput.focus();
            }
        }
    });
});
