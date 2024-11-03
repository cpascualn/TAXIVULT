<?php
namespace App\Controllers;


use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Models\DaoCiudad;
use App\Entities\Ciudad;

class CiudadController
{
    private DaoCiudad $daoCiu;

    public function __construct(
        DaoCiudad $daoCiu,

    ) {
        $this->daoCiu = $daoCiu;
    }


    public function HandleListar(Request $request, Response $response)
    {
        $ciudades = $this->daoCiu->listar();


        $response->getBody()->write(json_encode(['ciudades' => $ciudades, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleObtener(Request $request, Response $response, $id)
    {
        $ciudad = $this->daoCiu->obtener($id);
        if ($ciudad === null) {
            $response->getBody()->write(json_encode([
                'message' => 'La ciudad no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode(['ciudad' => $ciudad, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleObtenerPorNombre(Request $request, Response $response, $nombreCiudad)
    {
        $ciudad = $this->daoCiu->obtenerPorNombre($nombreCiudad);
        if ($ciudad === null) {
            $response->getBody()->write(json_encode([
                'message' => 'La ciudad no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode(['ciudad' => $ciudad, 'success' => true]));
        return $response->withStatus(200);
    }


}