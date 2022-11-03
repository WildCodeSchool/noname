// Burger button

const menu_btn = document.querySelector(".hamburger");
const mobile_menu = document.querySelector(".mobile-nav");

menu_btn.addEventListener("click", function () {
    menu_btn.classList.toggle("is-active");
    mobile_menu.classList.toggle("is-active");
});

// Login form

const urlParams = new URLSearchParams(window.location.search);
const loginBtn = document.querySelectorAll(".loginButton");
const loginPrompt = document.querySelector(".loginPrompt");
const logoutPrompt = document.querySelector(".logoutPrompt");

loginBtn.forEach((node) =>
    node.addEventListener("click", function () {
        if (loginPrompt !== null) {
            loginPrompt.classList.toggle("showed");
        }
        if (logoutPrompt !== null) {
            logoutPrompt.classList.toggle("showed");
        }
    })
);

if (urlParams.get("loginFailed") === "true") {
    if (loginPrompt !== null) {
        loginPrompt.classList.toggle("showed");
    }
}
