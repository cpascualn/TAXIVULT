<?php

use App\Database\Database;
use App\Models\DaoUsuario;

return [

    Database::class => function () {
        return new Database(
            host: 'localhost',
            dbname: 'taxivult',
            user: 'root',
            password: ''
        );
    },
];

