import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const membershipSelect = document.getElementById('membershipSelect');
    const amountInput = document.getElementById('amountInput');

    if (membershipSelect && amountInput) {
        membershipSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            // Set harga ke input amount
            amountInput.value = price ? price : '';
        });
    }
});
