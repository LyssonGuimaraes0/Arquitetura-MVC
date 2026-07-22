<?php

namespace App\middleware;

use App\controllers\api\ApiController;
use App\service\jwt\JwtService;

class AuthMiddleware extends ApiController
{

private $jwtService;

    public function __construct(){
        $this->jwtService = New JwtService;
    }

    public function handle()
    {
        if (!isset($_COOKIE['access_token'])) {
            $this->error("Token não encontrado");
            exit;
        }

        $user = $this->jwtService->validate(
            $_COOKIE['access_token']
        );

        if (!$user) {
            $this->error("Token não encontrado");
            exit;
        }

        return $user;
    }


}