<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as SlimResponse;
use App\Models\DaoUsuario;
use App\Entities\Usuario;

class FilterByRolMiddleware
{

    private array $allowedRoles;

    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function __invoke(Request $request, $handler): Response
    {
        try {

            $user = $request->getAttribute('userData');
            if (!isset($user) && $user == null)
                throw new \Exception('Invalid token');
            $rol = $user['rol'];


            if (!in_array($rol, $this->allowedRoles)) {
                $response = new SlimResponse();
                $response->getBody()->write(json_encode(['error' => 'Acceso restringido', 'success' => false]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }


        } catch (\Exception $e) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode(['error' => $e->getMessage(), 'success' => false]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        return $handler->handle($request);
    }
}
