import { login } from '../services/auth.js';

const form = document.querySelector('#form-login');

form.addEventListener('submit', async (e) => {

    e.preventDefault();

    const dados = {
        username: form.username.value,
        password: form.password.value
    };

    const resposta = await login(dados);

    if (resposta.success) {
        alert(resposta.data);
        return;
    }

    console.log(resposta)

});