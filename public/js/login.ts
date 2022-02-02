const loginForm = document.querySelector('form');
const loginPasswordInput = <HTMLInputElement>document.getElementById('pass');

let loginHandler = function(e) {
    if (loginPasswordInput.value !== passwordConfirmInput.value) {
        passwordConfirmInput.classList.add('no-valid')
        e.preventDefault();
        return false;
    }
}

loginForm.onsubmit = loginHandler;


const emailIncorrectMessage = <HTMLElement>document.querySelector('#email-message');
const passwordIncorrectMessage = <HTMLElement>document.querySelector('#password-message');
// @ts-ignore
if (email_incorrect == 'false') {
    emailIncorrectMessage.style['display'] = 'none'
}
// @ts-ignore
if (password_incorrect == 'false') {
    passwordIncorrectMessage.style['display'] = 'none'
}
