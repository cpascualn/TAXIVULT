<?php

use App\Middleware\AddJsonResponseHeader;
use App\Middleware\JwtMiddleware;
use App\Middleware\FilterByRolMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioController;
use App\Controllers\CiudadController;
use App\Middleware\AllowCorsMiddleware;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
$adminRol = 1;
$conductorRol = 2;
$pasajeroRol = 3;

// Manejar todas las solicitudes OPTIONS para todas las rutas
$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
})->add(AddJsonResponseHeader::class);

$app->post('/register', [UsuarioController::class, 'HandleRegister'])->add(AddJsonResponseHeader::class);
$app->post('/login', [UsuarioController::class, 'HandleLogin'])->add(AddJsonResponseHeader::class);
$app->get('/api/ciudades', callable: [CiudadController::class, 'HandleListar'])->add(AddJsonResponseHeader::class);


$app->group('/api', function (RouteCollectorProxy $group) {

    $group->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('', callable: [UsuarioController::class, 'HandleListar']);
        $group->post('', [UsuarioController::class, 'HandleInsertar']);
        $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
        $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
        $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
        $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    });

    // $group->group('/ciudades', function (RouteCollectorProxy $group) {
    //     $group->post('', [UsuarioController::class, 'HandleInsertar']);
    //     $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
    //     $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
    //     $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
    //     $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    // });

})->add(AddJsonResponseHeader::class)
    ->add(new FilterByRolMiddleware([$adminRol, $conductorRol, $pasajeroRol]))
    ->add(JwtMiddleware::class);

