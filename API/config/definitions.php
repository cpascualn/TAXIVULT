<?php

use App\Database\Database;

return [

    Database::class => function () {
        return new Database(
            host: $_ENV['MYSQLHOST'],
            dbname: $_ENV['MYSQLDATABASE'],
            user: $_ENV['MYSQLUSER'],
            password: $_ENV['MYSQLPASSWORD']
        );
    },
];