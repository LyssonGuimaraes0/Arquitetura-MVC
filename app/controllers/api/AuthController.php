<?php

namespace App\controllers\api;

use App\controllers\api\ApiController;
use App\service\auth\AuthService;


class AuthController extends ApiController
{

    private $authService;
    private $authMiddleware;

    public function __construct()
    {
        $this->authService = new AuthService();
        /*  $this->authMiddleware = new AuthMiddleware; */
    }

    //Autentificação de Login
    public function login()
    {

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            $username = preg_replace('/[^a-z0-9_-]/', '', $data['username']);
            $password = $data['password'];

            //Valida é cria token de Login
            $this->authService->login($username, $password);

            return $this->success('Login Realizado!');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 401);
        }
    }
}
