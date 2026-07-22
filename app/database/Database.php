<?php

namespace App\Database;

use PDO;

class Database
{
    //Cria variavel de conexão
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME'],
                $_ENV['DB_CHARSET']
            );

            self::$connection = new PDO(
                $dsn,
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }

        return self::$connection;
    }
}
