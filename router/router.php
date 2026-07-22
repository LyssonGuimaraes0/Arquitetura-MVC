<?php

$router = new Router();

//Criação de Rotas

//Rotas Web
$router::get('/', ['web', 'LoginController', 'index']);
$router::get('/user/{id}', ['web', 'HomeController', 'userid']);

//Rotas POST
$router::post('/api/auth/login', ['api', 'AuthController', 'login']);



//Class Router
class Router
{
    //Cria Array com Rotas
    private static array $routes = [];

    //Cria os methodos GET,POST,PUT,DELETE

    public static function get(string $uri, array $action)
    {
        self::addRouter('GET', $uri, $action);
    }

    public static function post(string $uri, array $action)
    {
        self::addRouter('POST', $uri, $action);
    }

    //Cria Um nova Rota
    private static function addRouter(string $method, string $uri, array $action)
    {
        self::$routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    //Verifica se Rota bate
    private function matchRoute(string $routeUri, string $requestUri)
    {
        // Captura os nomes dos parâmetros da rota
        preg_match_all('/\{([^}]+)\}/', $routeUri, $matches);
        $paramNames = $matches[1];

        // Transforma /usuarios/{id} em /usuarios/([^/]+)
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = "#^{$pattern}$#";

        // Verifica se a URL corresponde à rota
        if (preg_match($pattern, $requestUri, $matches)) {

            array_shift($matches);

            $paramsAssoc = [];

            foreach ($paramNames as $index => $name) {
                $paramsAssoc[$name] = $matches[$index] ?? null;
            }

            return $paramsAssoc;
        }

        return false;
    }

    //Dispha rota
    public function dispatch()
    {
        try {
            //Coleta URL
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $method = $_SERVER['REQUEST_METHOD'];
            $type = '';

            //Remoção de Base da URL

            $uri = str_replace($_ENV['RAIZ_URL'], '', $uri);

            foreach (self::$routes as $route) {

                if ($route['method'] !== $method) {
                    continue;
                }

                //Busca pelas rotas ate encontra a rota que bate
                $params = $this->matchRoute($route['uri'], $uri);

                if ($params === false) {
                    continue;
                }

                [$type, $controller, $methodAction] = $route['action'];

                $controllerNameSpace = "App\\controllers\\{$type}\\{$controller}";

                if (!class_exists($controllerNameSpace)) {
                    throw new Exception("Controller {$controllerNameSpace} não encontrado.");
                }

                $instance = new $controllerNameSpace();

                //armazena paramentos e argumentos de URL
                $args = [];

                // Adiciona o parâmetro da rota, se existir
                if (!empty($params)) {
                    $args[] = reset($params);
                }

                // Adiciona a query string, se existir
                if (!empty($_GET)) {
                    $args[] = $_GET;
                }

                // Chama o método
                $instance->$methodAction(...$args);
                return;

            }
            //Caso nenhuma rota seja encontrada
            throw new Exception("Página não encontrada.");
        } catch (\Exception $e) {
            echo $e->getMessage();
        }




    }

}




?>