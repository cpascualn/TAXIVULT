<?php

use App\middleware\AddJsonResponseHeader;
use App\middleware\JwtMiddleware;
use App\Middleware\FilterByRolMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioController;

$adminRol = 1;
$conductorRol = 2;
$pasajeroRol = 3;

$app->post('/register', [UsuarioController::class, 'HandleRegister'])->add(AddJsonResponseHeader::class);
$app->post('/login', [UsuarioController::class, 'HandleLogin'])->add(AddJsonResponseHeader::class);

$app->group('/api', function (RouteCollectorProxy $group) {

    $group->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('', callable: [UsuarioController::class, 'HandleListar']);
        $group->post('', [UsuarioController::class, 'HandleInsertar']);
        $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
        $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
        $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
        $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    });

})->add(AddJsonResponseHeader::class)
    ->add(new FilterByRolMiddleware([$adminRol, $conductorRol, $pasajeroRol]))
    ->add(JwtMiddleware::class);