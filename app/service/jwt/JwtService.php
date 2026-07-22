<?php

namespace App\service\jwt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{

    private $key;

    public function __construct()
    {
        $this->key = $_ENV['KEY'];
    }
    //Gera Token
    public function generate($user)
    {
        $payload = [
            'id' => $user['id'],
            'role' => $user['perfil'],
            'exp' => time() + 60 * 1500
        ];

        return JWT::encode(
            $payload,
            $this->key,
            'HS256'
        );
    }


    //Valida Token
    public function validate($token)
    {
        try {

            return JWT::decode(
                $token,
                new Key($this->key, 'HS256')
            );
            
        } catch (\Exception $e) {
            return null;
        }
    }
}