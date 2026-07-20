<?php

namespace App\controllers\web;

class HomeController
{

    //Exemplo de Rota Basica
    public function index()
    {
        echo "Home";
    }


    //Exemplo de rota com Parametro e argumentos
    //Ex: /user/{id}?teste=10

    public function userid(int $id, array $query = [])
    {
        echo $id;
        var_dump($query);
    }
}


?>