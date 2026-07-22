<?php

$allowedOrigins = [
    'http://localhost',
    'https://localhost'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

/*Se origin vier vazio: é acesso direto*/

if ($origin === '' || in_array($origin, $allowedOrigins)) {

    // Só adiciona header se existir origin
    if ($origin !== '') {
        header("Access-Control-Allow-Origin: $origin");
    }

    header("Access-Control-Allow-Credentials: true");

    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-Token");

    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

} else {

    http_response_code(403);

    echo json_encode([
        "error" => "Origem não permitida"
    ]);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}