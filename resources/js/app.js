require("./bootstrap");

import Alpine from "alpinejs";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import * as Ladda from "ladda";
import ApexCharts from "apexcharts";

// import $ from "jquery";
// import Swal from "sweetalert2";
// import "sweetalert2/src/sweetalert2.scss";

// window.Swal = Swal;

// window.jQuery = $;
// window.$ = $;
window.Pusher = Pusher;
window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

Alpine.start();

// Find the notification element
// const notificationElement = document.getElementById('notification');

window.Echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  encrypted: true,
  forceTLS: true,
  withCredentials: true,
  auth: {
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    },
  },
  // authEndpoint: "/broadcasting/auth",
});

// Listen for UserSessionChange events on the notifications channel
// Echo.channel("notifications").listen("UserSessionChange", (e) => {
//   const notificationElement = document.getElementById("notification");
//   console.log("UserSessionChange event received:", e);
//   debugger;
//   // Update the notification element text and classes based on the event data
//   notificationElement.innerText = e.message;
//   notificationElement.classList.remove("invisible");
//   notificationElement.classList.remove("alert-success");
//   notificationElement.classList.remove("alert-danger");
//   notificationElement.classList.add("alert-" + e.type);
// });
