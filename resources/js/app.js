// Importaciones de Bootstrap
import 'bootstrap-icons/font/bootstrap-icons.css';
import * as bootstrap from 'bootstrap';
import '../css/app.css';

// Importación login
import './login';

// Importaciones de Alpine.js
import './bootstrap'; // Si esto carga Alpine.js (verifica tu archivo resources/js/bootstrap.js)
import Alpine from 'alpinejs';

// Inicializar Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Inicializar componentes de Bootstrap que requieren JS
document.addEventListener('DOMContentLoaded', () => {
    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Popovers (si los usas)
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
});

// Elimina los alert en la vista dashboard
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        let alertElement = document.getElementById("alertSuccess");
        if (alertElement) {
            alertElement.classList.remove("show");
            alertElement.classList.add("fade");
            setTimeout(() => alertElement.remove(), 500);
        }
    }, 5000);
});