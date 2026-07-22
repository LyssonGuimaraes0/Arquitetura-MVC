<?php

namespace App\repository;

class AuthRepository extends BaseRepository
{

    //Buscar Usuario Por Usarname
    public function FindUserByUsername(string $username)
    {
        return $this->select(
            table: 'administradores',
            columns: ['id','senha_hash', 'perfil'],
            where: [
                [
                    'column' => 'username',
                    'operator' => '=',
                    'value' => $username
                ]
            ]
        );
    }
}
