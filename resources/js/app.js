require("./bootstrap");

import Alpine from "alpinejs";
import $ from "jquery";
// import Swal from "sweetalert2";
// import "sweetalert2/src/sweetalert2.scss";

window.Swal = Swal;

window.jQuery = $;
window.$ = $;

window.Alpine = Alpine;

Alpine.start();
