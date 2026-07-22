<?php 

namespace App\controllers\api;

class ApiController
{
    //Converte resposta para JSON
    protected function json(mixed $data, int $status = 200): void
    {
        
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    //Define Respostas padrões para JSON
    protected function success(mixed $data, int $status = 200): void
    {
        $this->json(['success' => true, 'data' => $data], $status);
    }

    protected function error(string $message, int $status = 400): void
    {
        $this->json(['success' => false, 'message' => $message, 'code' => $status], $status);
    }
}


