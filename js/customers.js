const loginEmailInput = document.querySelector('#login-email');
const formElem = document.querySelector('#signupForm');
const username = document.querySelector('#username');

formElem.onsubmit = async (e) => {
    e.preventDefault();

    let response = await fetch('php/create-customer.php', {
        method: 'POST',
        body: new FormData(formElem)
    });

    let result = await response.json();

    username.textContent = result.username;
};

async function signup() {


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