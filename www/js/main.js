void 0,document.addEventListener("DOMContentLoaded",(function(e){document.querySelector("#togglePassword").addEventListener("click",(function(e){var t=document.querySelector("#password"),o="password"===t.getAttribute("type")?"text":"password";t.setAttribute("type",o),e.target.classList.toggle("password__icon-eye-slash")}))}));