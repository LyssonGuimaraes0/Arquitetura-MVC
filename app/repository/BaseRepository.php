<?php

namespace App\repository;

use App\Database\Database;
use PDO;

class BaseRepository extends Database
{

    //Função Para Montar Insert 
    protected function insert(string $table, array $query) {}

    //Função Para Montar Select 
    protected function select(string $table, array $columns, array $joins = [], array $where = [], array $orderBy = [], bool $fetchAll = false)
    {
        $sql = "SELECT " . implode(', ', $columns) . " FROM $table";
        $values = [];

        // Verifica se possui JOIN
        if (!empty($joins)) {

            foreach ($joins as $join) {

                $type = strtoupper($join['type']);

                $allowedJoins = [
                    'INNER',
                    'LEFT',
                    'RIGHT',
                    'FULL'
                ];

                if (!in_array($type, $allowedJoins)) {
                    throw new \Exception("Tipo de JOIN inválido.");
                }

                $sql .= " {$type} JOIN {$join['table']}";

                $sql .= " ON {$join['on']['column']} {$join['on']['operator']} {$join['on']['reference']}";
            }
        }

        //Verifica se Tem parametro
        if (!empty($where)) {
            $conditions = [];

            $allowedoperator = ['>=', '<=', '!=', '<>', '>', '<', 'LIKE', '='];

            //Monta Where $condition $operador ?
            foreach ($where as $condition) {

                $operator = strtoupper($condition['operator']);

                if (!in_array($operator, $allowedoperator)) {
                    throw new \Exception("Tipo de JOIN inválido.");
                }

                $conditions[] = "{$condition['column']} {$operator} ?";
                $values[] = $condition['value'];
            }

            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Verifica se possui ORDER BY
        if (!empty($orderBy)) {
            $sql .= " ORDER BY ";
            $orders = [];

            //Monta Where $order $direction
            foreach ($orderBy as $order) {

                $direction = strtoupper($order['direction']);

                if (!in_array($direction, ['ASC', 'DESC'])) {
                    throw new \Exception("Direção do ORDER BY inválida.");
                }

                $orders[] = "{$order['column']} {$direction}";
            }
            $sql .= implode(", ", $orders);
        }

        $pdo = self::connection();

        $stmt = $pdo->prepare($sql);
        $stmt->execute($values);

        if ($fetchAll != false) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}
