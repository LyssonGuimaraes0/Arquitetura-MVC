<?php

namespace App\service\auth;

use App\service\jwt\JwtService;
use App\repository\AuthRepository;

class AuthService
{

    private $jwtService;
    private $authRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository;
        $this->jwtService = new JwtService;
    }

    public function login(string $username, string $password)
    {
        
            $consultData = $this->authRepository->FindUserByUsername($username);

            if (!$consultData) {
                throw new \Exception("Usuario ou senha invalido!",401);
            }

            $password_hash = $consultData['senha_hash'];

            if (!password_verify($password, $password_hash)) {
                throw new \Exception("Usuario ou senha invalido!",401);
            }

            //Gera Token com JWT
            $acessToken = $this->jwtService->generate($consultData);

            //Gera CSRF
            $csrfToken = bin2hex(random_bytes(32));

            //Armazena JWT Token em COOKIES

            setcookie(
                'access_token',
                $acessToken,
                [
                    'httponly' => true,
                    'path' => '/',
                    'samesite' => 'Lax'
                ]
            );

            //Armazena CSRF em COOKIES 

            setcookie(
                'csrf_token',
                $csrfToken,
                [
                    'httponly' => false,
                    'path' => '/',
                    'samesite' => 'Lax'
                ]
            );

            return;

    }

}

?>