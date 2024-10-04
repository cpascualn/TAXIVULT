<?php

use App\Middleware\AllowCorsMiddleware;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;


define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/vendor/autoload.php';

header("Access-Control-Allow-Origin: http://localhost:5173"); // Cambia por tu dominio
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


if (file_exists(APP_ROOT . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')->build();
AppFactory::setContainer($container);

$app = AppFactory::create();


$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

$app->addBodyParsingMiddleware();

$error_middleware = $app->addErrorMiddleware(true, true, true);

$error_handler = $error_middleware->getDefaultErrorHandler();

$error_handler->forceContentType('application/json');


require_once APP_ROOT . '/config/routes.php';


$app->add(new AllowCorsMiddleware);

$app->run();