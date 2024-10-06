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

}