<?php

namespace App\repository;

use App\Database\Database;
use PDO;

class BaseRepository extends Database
{

    private $allowedOperators = ['>=', '<=', '!=', '<>', '>', '<', 'LIKE', '='];


    //Função Para Montar Insert 
    protected function insert(string $table, array $Allcolumns)
    {
        $columns = [];
        $values = [];
        foreach ($Allcolumns as $column) {
            $columns[] = $column['column'];
            $values[] = $column['value'];
        }

        $placeholders = array_fill(0, count($columns), '?');


        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

        $stmt = self::connection()->prepare($sql);

        $stmt->execute($values);

        return;

    }

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

            //Monta Where $condition $operador ?
            foreach ($where as $condition) {

                $operator = strtoupper($condition['operator']);

                if (!in_array($operator, $this->allowedOperators)) {
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

        $stmt = self::connection()->prepare($sql);

        $stmt->execute($values);

        if ($fetchAll != false) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    //Função para montar UPDATE

    protected function update(string $table, array $columns, array $where = [])
    {

        if (empty($where)) {
            throw new \Exception("UPDATE bloqueado: WHERE obrigatório.");
        }


        $set = [];
        $values = [];


        // Monta SET
        foreach ($columns as $column) {

            $set[] = "{$column['column']} = ?";
            $values[] = $column['value'];

        }


        // Monta WHERE
        $conditions = [];

        foreach ($where as $condition) {

            $operator = strtoupper($condition['operator']);

            if (!in_array($operator, $this->allowedOperators)) {
                throw new \Exception("Operador inválido.");
            }


            $conditions[] = "{$condition['column']} {$operator} ?";
            $values[] = $condition['value'];

        }


        $sql = "UPDATE {$table} 
            SET " . implode(', ', $set) . "
            WHERE " . implode(' AND ', $conditions);

        $stmt = self::connection()->prepare($sql);

        return $stmt->execute($values);
    }



    //Função de montar Delete
    protected function delete(string $table, array $where = [])
    {
        // Segurança: não permite DELETE sem condição
        if (empty($where)) {
            throw new \Exception("DELETE bloqueado: WHERE obrigatório.");
        }

        $conditions = [];
        $values = [];

        foreach ($where as $condition) {

            $operator = strtoupper($condition['operator']);

            if (!in_array($operator, $this->allowedOperators)) {
                throw new \Exception("Tipo de Operador inválido.");
            }

            $conditions[] = "{$condition['column']} {$operator} ?";
            $values[] = $condition['value'];

        }

        $sql = "DELETE FROM {$table} WHERE " . implode(" AND ", $conditions);

        $stmt = self::connection()->prepare($sql);

        return $stmt->execute($values);
    }
}
