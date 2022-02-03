const registerForm = document.querySelector('form');
const passwordInput = <HTMLInputElement>document.getElementById('pass');
const passwordConfirmInput = <HTMLInputElement>document.getElementById('pass-conf');

let registerHandler = function(e) {
    if (passwordInput.value !== passwordConfirmInput.value) {
        passwordConfirmInput.classList.add('no-valid')
        e.preventDefault();
        return false;
    }
}

registerForm.onsubmit = registerHandler;

const emailUsedMessage = <HTMLElement>document.querySelector('.error-message');
// @ts-ignore
if (user_exists == 'false') {
    emailUsedMessage.style['display'] = 'none'
}
