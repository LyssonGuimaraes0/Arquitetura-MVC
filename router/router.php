<?php

$router = new Router();

//Criação de Rotas
$router::get('/', ['web', 'HomeController', 'index']);
$router::get('/user/{id}', ['web', 'HomeController', 'userid']);


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
    private function matchRoute(string $routeUri, string $requestUri, $params = []): array
    {

        $paramNames = [];
        preg_match_all('/\{([^}]+)\}/', $routeUri, $matches);
        $paramNames = $matches[1];

        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = "#^$pattern$#";


        if (preg_match($pattern, $routeUri, $matches)) {

            array_shift($matches); // remove match completo

            $paramsAssoc = [];
            var_dump($)

            foreach ($paramNames as $index => $name) {
                $paramsAssoc[$name] = $matches[$index] ?? null;
            }

            return [$action, $paramsAssoc];
        }

        if ($routeUri === $requestUri) {
            return true;
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

            //Remoção de Base da URL

            $uri = str_replace($_ENV['RAIZ_URL'], '', $uri);

            foreach (self::$routes as $route) {
                if ($route['method'] !== $method) {
                    continue;
                }

                if (self::matchRoute($route['uri'], $uri, )) {
                    [$type, $controller, $methodAction] = $route['action'];

                    $controllerNameSpace = "App\\controllers\\{$type}\\{$controller}";

                    if (!class_exists($controllerNameSpace)) {
                        throw new Exception();
                    }

                    $instance = new $controllerNameSpace();

                    $instance->$methodAction(/* ...$params */);

                }

            }
        } catch (\Exception $e) {
            # code...
        }




    }

}




?>