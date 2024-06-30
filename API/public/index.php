<?php

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



$app = AppFactory::create();


$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');

$app->add(new AddJsonResponseHeader);

$app->group('/api', function(RouteCollectorProxy $group){

    $group->get('/usuarios', [UsuarioController::class, 'listar']);

    $group->get('/usuarios/{id:[0-9]+}', [UsuarioController::class, 'obtener']);
    
    $group->post('/usuarios', [UsuarioController::class, 'insertar']);
    
    $group->patch('/usuarios', [UsuarioController::class, 'update']);
});


$app->run();

