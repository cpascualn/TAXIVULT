<?php

use App\Middleware\AddJsonResponseHeader;
use App\Middleware\JwtMiddleware;
use App\Middleware\FilterByRolMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioController;
use App\Controllers\CiudadController;
use App\Controllers\ConductorController;
use App\Controllers\HorarioController;
use App\Controllers\ViajeController;
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

$app->group('', function (RouteCollectorProxy $group) {
    $group->post('/register', [UsuarioController::class, 'HandleRegister']);
    $group->post('/login', [UsuarioController::class, 'HandleLogin']);

    $group->group('/api/ciudades', function (RouteCollectorProxy $group) {
        $group->get('', [CiudadController::class, 'HandleListar']);
        $group->get('/{nombre:[a-zA-ZÀ-ÿ\s-]+}', [CiudadController::class, 'handleObtenerPorNombre']);
        $group->get('/{id:[0-9]+}', [CiudadController::class, 'handleObtener']);
    });


})->add(AddJsonResponseHeader::class);

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('', [UsuarioController::class, 'HandleListar']);
        $group->post('', [UsuarioController::class, 'HandleInsertar']);
        $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
        $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
        $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
        $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    });
    $group->group('/conductores', function (RouteCollectorProxy $group) {
        $group->patch('/reload', [ConductorController::class, 'HandleReload']);
        $group->patch('/{accion:(?:ocupar|liberar)}/{id:[0-9]+}', [ConductorController::class, 'HandleEstado']);
        $group->get('/libres/{id:[0-9]+}', [ConductorController::class, 'HandleBuscarLibresEnciudad']);
        $group->post('/disponibles', [ConductorController::class, 'HandleBuscarDisponiblesEnciudad']);
    });
    $group->group('/horarios', function (RouteCollectorProxy $group) {
        $group->post('/buscarHora', [HorarioController::class, 'handleBuscarHorario']);
    });
    $group->group('/viajes', function (RouteCollectorProxy $group) {
        $group->get('', [ViajeController::class, 'HandleListar']);
        $group->post('/insertar', [ViajeController::class, 'HandleInsertar']);
        $group->post('/activoUsuario', [ViajeController::class, 'HandleObtenerViajesActivosUsuario']);
        $group->post('/usuario', [ViajeController::class, 'HandleObtenerViajesUsuario']);
    });


})->add(AddJsonResponseHeader::class)
    ->add(new FilterByRolMiddleware([$adminRol, $conductorRol, $pasajeroRol]))
    ->add(JwtMiddleware::class);

