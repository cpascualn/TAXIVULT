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

    public function Handlelistar(Request $request, Response $response)
    {

        $this->daoVeh->listar();

        $body = json_encode(['vehiculos' => $this->daoVeh->vehiculos, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandlelistarLibres(Request $request, Response $response)
    {

        $this->daoVeh->listarLibres();

        $body = json_encode(['vehiculos' => $this->daoVeh->vehiculos, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }
    public function HandleObtenerPorMatricula(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $vehiculo = $this->daoVeh->obtenerPorMatricula($body['matricula']);

        $body = json_encode(['vehiculo' => $vehiculo, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
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

    public function handleBorrarVehiculo(Request $request, Response $response, $id = null)
    {

        try {
            $body = $request->getParsedBody();
            if (isset($body["matricula"])) {
                $this->daoVeh->eliminar($id, $body["matricula"]);
            } else {
                $this->daoVeh->eliminar($id);
            }

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

    public function handleActualizar(Request $request, Response $response, $id = null)
    {
        //comprobar que existe
        $vehiculo = $this->daoVeh->obtener($id);
        if ($vehiculo === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El vehiculo no existe');
        }

        $body = $request->getParsedBody();

        //si son validos, crear vehiculo y actualizarlo
        $nuevo = $this->crearVehiculo($body);
        $this->daoVeh->actualizar($id, $vehiculo, $nuevo);
        $nuevo = $this->daoVeh->obtener($id);

        $body = json_encode([
            'message' => 'vehiculo actualizado ',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);

    }


    public function HandleVerTotales(Request $request, Response $response)
    {
        try {
            $totales = $this->daoVeh->verTotales();

            $body = json_encode([
                'totales' => $totales,
                'success' => true
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(200);
        } catch (\Throwable $th) {
            $body = json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(200);
        }
    }

    public function HandleObtenerVehiculoUsuario(Request $request, Response $response, $id = null)
    {
        $vehiculo = $this->daoVeh->obtenerPorUsuario($id);

        $body = json_encode([
            'vehiculos' => $vehiculo,
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
            'matricula' => ['required', ['lengthMax', 12], ['regex', '/^\d{4}\s?[A-Z]{3}$/']],  // matricula
            'capacidad' => ['required', 'integer', ['min', 5]],  // minimo para 5 pasajeros
            'fabricante' => ['required', ['lengthMax', 30]],  // Máximo de 30 caracteres
            'modelo' => ['required', ['lengthMax', 30]],  // Máximo de 30 caracteres
            'tipo' => ['required', ['in', ['comun', 'van']]],  // Solo acepta 'comun' o 'van'
            'imagen' => ['optional'],  // Validación para datos binarios
            'conductor' => ['integer', 'optional']  // Entero opcional (puede ser NULL)
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