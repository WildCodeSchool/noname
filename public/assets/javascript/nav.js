
// Burger button

const menu_btn = document.querySelector('.hamburger');
const mobile_menu = document.querySelector('.mobile-nav');

menu_btn.addEventListener('click', function () {
    menu_btn.classList.toggle('is-active');
    mobile_menu.classList.toggle('is-active');
});

// Login form

const loginBtn = document.querySelector('.loginButton');
const loginForm = document.querySelector('.loginPrompt');

loginBtn.addEventListener('click', function() {
    loginForm.classList.toggle('showed');
});
