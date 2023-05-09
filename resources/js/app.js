require("./bootstrap");

import Alpine from "alpinejs";
import $ from "jquery";
// import Swal from "sweetalert2";
// import "sweetalert2/src/sweetalert2.scss";

// window.Swal = Swal;

window.jQuery = $;
window.$ = $;

window.Alpine = Alpine;

Alpine.start();



// Find the notification element
// const notificationElement = document.getElementById('notification');

// Listen for UserSessionChange events on the notifications channel
Echo.channel('notifications')
    .listen('UserSessionChange', (e) => {
        const notificationElement = document.getElementById('notification');
        console.log('UserSessionChange event received:', e);
        debugger;
        // Update the notification element text and classes based on the event data
        notificationElement.innerText = e.message;
        notificationElement.classList.remove('invisible');
        notificationElement.classList.remove('alert-success');
        notificationElement.classList.remove('alert-danger');
        notificationElement.classList.add('alert-' + e.type);
    });


