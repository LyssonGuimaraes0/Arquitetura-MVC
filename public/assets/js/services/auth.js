import api from './api.js';

//Função para realizar login
export function login(dados) {

    return api.post('/api/auth/login', dados);

}