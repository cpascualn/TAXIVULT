<?php

use App\Middleware\AddJsonResponseHeader;
use App\Middleware\JwtMiddleware;
use App\Middleware\FilterByRolMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioController;
use App\Controllers\CiudadController;
use App\Controllers\ConductorController;
use App\Controllers\HorarioController;
use App\Controllers\VehiculoController;
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
        $group->get('/totales', [UsuarioController::class, 'HandleVerTotales']);
        $group->post('', [UsuarioController::class, 'HandleInsertar']);
        $group->post('/comprobarContrasena', [UsuarioController::class, 'HandleComprobarContrasena']);
        $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
        $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
        $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
        $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    });
    $group->group('/conductores', function (RouteCollectorProxy $group) {
        $group->get('', [ConductorController::class, 'HandleListar']);
        $group->patch('/reload', [ConductorController::class, 'HandleReload']);
        $group->patch('/{accion:(?:ocupar|liberar)}/{id:[0-9]+}', [ConductorController::class, 'HandleEstado']);
        $group->get('/libres/{id:[0-9]+}', [ConductorController::class, 'HandleBuscarLibresEnciudad']);
        $group->post('/disponibles', [ConductorController::class, 'HandleBuscarDisponiblesEnciudad']);
        $group->patch('/actualizar/{id:[0-9]+}', [ConductorController::class, 'HandleActualizar']);
        $group->get('/obtener/{id:[0-9]+}', [ConductorController::class, 'HandleObtenerFormated']);
    });
    $group->group('/horarios', function (RouteCollectorProxy $group) {
        $group->get('', [HorarioController::class, 'HandleListar']);
        $group->post('/buscarHora', [HorarioController::class, 'handleBuscarHorario']);
        $group->patch('/{id:[0-9]+}', [HorarioController::class, 'handleActualizar']);
    });
    $group->group('/viajes', function (RouteCollectorProxy $group) {
        $group->get('', [ViajeController::class, 'HandleListar']);
        $group->post('/insertar', [ViajeController::class, 'HandleInsertar']);
        $group->post('/activoUsuario', [ViajeController::class, 'HandleObtenerViajesActivosUsuario']);
        $group->post('/usuario', [ViajeController::class, 'HandleObtenerViajesUsuario']);
        $group->get('/totales', [ViajeController::class, 'HandleVerTotales']);
        $group->get('/totalesCiudad', [ViajeController::class, 'HandleVerTotalesCiudad']);
        $group->get('/totalesCiudadMes', [ViajeController::class, 'HandleVerTotalesCiudadPorMes']);
    });
    $group->group('/ciudades', function (RouteCollectorProxy $group) {
        $group->post('/insertar', [CiudadController::class, 'HandleInsertar']);
        $group->delete('/eliminar/{id:[0-9]+}', [CiudadController::class, 'HandleEliminar']);
        $group->get('/obtener/UsuariosCiudad', [CiudadController::class, 'HandleVerUsuariosPorCiudad']);
    });
    $group->group('/vehiculos', function (RouteCollectorProxy $group) {
        $group->get('', [VehiculoController::class, 'HandleListar']);
        $group->get('/libres', [VehiculoController::class, 'HandleListarLibres']);
        $group->post('/matricula', [VehiculoController::class, 'HandleObtenerPorMatricula']);
        $group->post('/insertar', [VehiculoController::class, 'HandleInsertar']);
        $group->delete('/eliminar/{id:[0-9]+}', [VehiculoController::class, 'handleBorrarVehiculo']);
        $group->patch('/actualizar/{id:[0-9]+}', [VehiculoController::class, 'handleActualizar']);
        $group->get('/totales', [VehiculoController::class, 'HandleVerTotales']);
        $group->get('/usuario/{id:[0-9]+}', [VehiculoController::class, 'HandleObtenerVehiculoUsuario']);
    });

})->add(AddJsonResponseHeader::class)
    ->add(new FilterByRolMiddleware([$adminRol, $conductorRol, $pasajeroRol]))
    ->add(JwtMiddleware::class);

