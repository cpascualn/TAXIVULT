<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
class AllowCorsMiddleware
{

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        return $response
            ->withHeader("Access-Control-Allow-Origin", $_ENV['DOMAIN'])
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'POST,GET, PUT, DELETE, PATCH, OPTIONS');
    }
}