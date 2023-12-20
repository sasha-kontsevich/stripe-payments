let signupModal = document.querySelector('#signup-window');
let loginModal = document.querySelector('#login-window');


function signupHandler() {
    showModal(signupModal);
}

function loginHandler() {
    showModal(loginModal);
}

function showModal(modal) {
    modal.classList.remove("hidden");
    modal.querySelector(".back-link").addEventListener('click', () => modal.classList.add("hidden"));
}

const emailInput = document.querySelector('#email');
const nameInput = document.querySelector('#name');
const loginEmailInput = document.querySelector('#login-email');

async function signup() {
    fetch('php/create-customer.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            'email': emailInput.value,
            'name': nameInput.value,
        }),
    }).then(r => r.json());
    console.log(emailInput.value)
}


function login() {
    fetch('/create-customer', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: loginEmailInput.value,
        }),
    }).then(r => r.json());
}