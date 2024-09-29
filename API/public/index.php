<?php

use FastRoute\Route;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use middleware\AddJsonResponseHeader;
use Slim\Routing\RouteCollectorProxy;

define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/middleware/AddJsonResponseHeader.php';
require_once APP_ROOT . '/models/DaoUsuario.php';
require APP_ROOT . '/vendor/autoload.php';
require_once APP_ROOT . '/controllers/UsuarioController.php';

header("Access-Control-Allow-Origin: http://localhost:5173"); // Cambia por tu dominio
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$app = AppFactory::create();


$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');

$app->add(new AddJsonResponseHeader);

$app->group('/api', function(RouteCollectorProxy $group){

    $group->group('/usuarios', function(RouteCollectorProxy $group){
        $group->get('', callable: [UsuarioController::class, 'HandleListar']);
        $group->post('', [UsuarioController::class, 'HandleInsertar']);
        $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'HandleActualizar']);
        $group->get('/{id:[0-9]+}', [UsuarioController::class, 'HandleObtener']);
        $group->post('/buscar', [UsuarioController::class, 'HandleBuscar']);
        $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'HandleEliminar']);
    });

    // $group->group('/usuarios', function(RouteCollectorProxy $group){
    //     $group->get('', callable: [UsuarioController::class, 'listar']);
    //     $group->post('', [UsuarioController::class, 'insertar']);
    //     $group->patch('/{id:[0-9]+}', [UsuarioController::class, 'actualizar']);
    //     $group->get('/{id:[0-9]+}', [UsuarioController::class, 'obtener']);
    //     $group->delete('/{id:[0-9]+}', [UsuarioController::class, 'eliminar']);
    // });
 
});


$app->run();

