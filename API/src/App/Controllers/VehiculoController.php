<?php
namespace App\Controllers;

use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Entities\Vehiculo;
use App\Models\DaoVehiculo;

class VehiculoController
{
    public function __construct(
        private DaoVehiculo $daoVeh
    ) {
    }

    public function handleInsertar(Request $request, Response $response)
    {
        try {
            //recibir datos del body y validarlos
            $body = $request->getParsedBody();
            $validacion = $this->validarDatos($body);
            if (!$validacion['success']) {
                $response->getBody()->write(json_encode([
                    'error' => $validacion['message'],
                    'success' => false
                ]));
                return $response->withStatus(400);
            }


            $vehiculo = $this->crearVehiculo($body);
            $this->daoVeh->insertar($vehiculo);

        } catch (\Throwable $th) {
            $body = json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);

            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'Vehiculo creado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function handleActualizarConductor(Request $request, Response $response, $id = null, $idConductor = null)
    {
        try {

            $body = $request->getParsedBody();
            $this->daoVeh->actualizarConductor($id, $body['matricula'] ?? null, $idConductor);

        } catch (\Throwable $th) {
            $body = json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);

            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'Vehiculo actualizado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function handleBorrarVehiculo(Request $request, Response $response, $id = null)
    {

        try {
            $body = $request->getParsedBody();
            if (isset($body["matricula"]))
                $this->daoVeh->eliminar($id, $body["matricula"]);
        } catch (\Throwable $th) {
            $body = json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);

            return $response->withStatus(400);
        }
        $body = json_encode([
            'message' => 'Vehiculo eliminado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }




    public function crearVehiculo($body, $id = null)
    {
        $vehiculo = new Vehiculo();
        $vehiculo->setId($id);
        $vehiculo->setMatricula($body['matricula'] ?? null);
        $vehiculo->setCapacidad($body['capacidad'] ?? null);
        $vehiculo->setFabricante($body['fabricante'] ?? null);
        $vehiculo->setModelo($body['modelo'] ?? null);
        $vehiculo->setTipo($body['tipo'] ?? null);
        $vehiculo->setImagen($body['imagen'] ?? null);
        $vehiculo->setConductor($body['conductor'] ?? null);

        return $vehiculo;
    }


    private function validarDatos($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'id' => ['integer'],  // Validación para ID autoincremental
            'matricula' => ['required', ['lengthMax' , 12], ['regex', '/^\d{4}\s?[A-Z]{3}$/']],  // matricula
            'capacidad' => ['required', 'integer', ['min' , 5]],  // minimo para 5 pasajeros
            'fabricante' => ['required', ['lengthMax' , 30]],  // Máximo de 30 caracteres
            'modelo' => ['required', ['lengthMax' , 30]],  // Máximo de 30 caracteres
            'tipo' => ['required', ['in', ['comun', 'van']]],  // Solo acepta 'comun' o 'van'
            'imagen' => ['optional'],  // Validación para datos binarios
            'conductor' => ['integer','optional']  // Entero opcional (puede ser NULL)
        ]);

        if (!$v->validate()) {
            return [
                'success' => false,
                'message' => $v->errors()
            ];
        }

        return [
            'success' => true,
            'message' => []
        ];
    }

}