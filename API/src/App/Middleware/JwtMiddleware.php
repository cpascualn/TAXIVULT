<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as SlimResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\DaoUsuario;
use App\Entities\Usuario;
class JwtMiddleware
{

    private $daoUsu;

    public function __construct(DaoUsuario $daoUsuario) // Inyectar el DAO
    {
        $this->daoUsu = $daoUsuario;
    }
    public function __invoke(Request $request, $handler): Response
    {
        $authHeader = $request->getHeader('Authorization');

        if (!$authHeader) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode(['error' => 'No token provided']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        try {
            $jwtKey = $_ENV['JWT_SECRET_KEY'];
            $decoded = JWT::decode($token, new Key($jwtKey, 'HS256'));
            $usu = $this->daoUsu->obtenerPorEmail($decoded->email);
            if ($usu == null)
                throw new \Exception("El usuario ya no existe");
            $userData = array(
                "id" => $usu->getId(),
                "email" => $usu->getEmail(),
                "rol" => $usu->getRol(),
            );
            $request = $request->withAttribute('userData', $userData);
        } catch (\Exception $e) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode(['error' => 'Invalid token']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
        
        return $handler->handle($request);
    }
}
