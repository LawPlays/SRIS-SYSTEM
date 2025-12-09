import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2'; // ✅ SweetAlert2 import
window.Swal = Swal;             // ✅ para magamit sa Blade scripts

window.Alpine = Alpine;

Alpine.start();

// 👉 Add Service Worker registration for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then(reg => {
                console.log('Service Worker registered with scope:', reg.scope);
            })
            .catch(err => {
                console.error('Service Worker registration failed:', err);
            });
    });
}
