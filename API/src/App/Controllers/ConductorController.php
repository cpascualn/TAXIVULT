<?php
namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Models\DaoConductor;
use App\Entities\Conductor;
use App\Entities\ConductorDisponible;
use App\Controllers\VehiculoController;
use Exception;
use Slim\Factory\AppFactory;

class ConductorController
{

    public function __construct(private DaoConductor $daoCon, private VehiculoController $vehiContr)
    {
    }

    public function HandleListar(Request $request, Response $response)
    {
        $conductores = null;
        try {
            //refrescar estados de conductores
            $app = AppFactory::create();
            $auxResponse = $app->getResponseFactory()->createResponse();
            $this->HandleReload($request, $auxResponse);


        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al buscar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }
        $conductores = $this->daoCon->listar();

        $body = json_encode(['conductores' => $conductores, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }


    public function HandleObtener(Request $request, Response $response, $id)
    {

        try {
            //refrescar estados de conductores
            $app = AppFactory::create();
            $auxResponse = $app->getResponseFactory()->createResponse();
            $this->HandleReload($request, $auxResponse);


        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al buscar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $conductor = $this->daoCon->obtener($id);

        if ($conductor === null) {
            $body = json_encode(['message' => 'El conductor no existe', 'success' => false]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $body = json_encode(['conductor' => $conductor, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }
    public function HandleObtenerFormated(Request $request, Response $response, $id)
    {

        try {
            //refrescar estados de conductores
            $app = AppFactory::create();
            $auxResponse = $app->getResponseFactory()->createResponse();
            $this->HandleReload($request, $auxResponse);


        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al buscar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }


        $conductor = $this->daoCon->obtenerFormated($id);

        if ($conductor === null) {
            $body = json_encode(['message' => 'El conductor no existe', 'success' => false]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $body = json_encode(['conductor' => $conductor, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }


    public function HandleInsertar(Request $request, Response $response, $id)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        $validacion = $this->validarDatos($id, $body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'message' => $validacion['message'],
                'success' => false
            ]));
            return $response->withStatus(400);
        }
        try {
            //primero  insertar el vehiculo  
            $response = $this->vehiContr->handleInsertar($request, $response);

            if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500)
                throw new Exception("error al insertar vehiculo");
            //despues crear el conductor
            $conductor = $this->crearConductor($id, $body);
            $this->daoCon->insertar($conductor);


        } catch (\Throwable $th) {
            // si hay error borrar vehiculo 
            $this->vehiContr->handleBorrarVehiculo($request, $response);

            $response->withStatus(400);
            $body = json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);

            return $response->withStatus(400);
        }



        $body = json_encode([
            'message' => 'Usuario creado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function HandleActualizar(Request $request, Response $response, $id)
    {
        //comprobar que existe
        $conductor = $this->daoCon->obtener($id);
        if ($conductor === null) {
            $response->getBody()->write(json_encode([
                'message' => "El conductor no existe",
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $body = $request->getParsedBody();
        $validacion = $this->validarDatosActualizacion($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'message' => $validacion['message'],
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario y actualizarlo
        $nuevo = $this->crearConductor($id, $body);
        $this->daoCon->actualizar($id, $conductor, $nuevo);
        $nuevo = $this->daoCon->obtener($id);

        $body = json_encode([
            'message' => 'valores actualizados en el usuario ' . $id,
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function HandleEliminar(Request $request, Response $response, $id)
    {




        $conductor = $this->daoCon->obtener($id);

        if ($conductor === null) {
            $body = json_encode([
                'message' => 'El conductor no existe',
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(200);
        }

        $this->daoCon->eliminar($id);
        $body = json_encode([
            'message' => 'Usuario ' . $id . ' Borrado',
            'success' => true
        ]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }
    public function HandleReload(Request $request, Response $response)
    {
        try {
            //actualizar conductores ocupados que hayan acabado el viaje
            $this->daoCon->actualizarEstadosOcupados();
            //actualizar todos los estados por el horario menos los ocupados
            $this->daoCon->actualizarEstados();

            //actualizar conductores que tengan un viaje en curso
            $this->daoCon->ocuparConductores();

        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al actualizar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'estados actualizados',
            'success' => true
        ]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandleBuscarDisponiblesEnciudad(Request $request, Response $response)
    {
        try {

            $body = $request->getParsedBody();
            //actualizar conductores que tengan un viaje en curso
            //refrescar estados de conductores
            $app = AppFactory::create();
            $auxResponse = $app->getResponseFactory()->createResponse();
            $this->HandleReload($request, $auxResponse);
            if ($auxResponse->getStatusCode() == 200)
                $conductores = $this->daoCon->buscarConductoresDisponibles($body['hora_ini'], $body['hora_fin'], $body['ciudad']);

        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al buscar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $body = json_encode([
            'conductores' => $conductores,
            'success' => true
        ]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandleBuscarLibresEnciudad(Request $request, Response $response, $idCiudad)
    {
        try {
            // actualizar 
            $app = AppFactory::create();
            $auxResponse = $app->getResponseFactory()->createResponse();
            $this->HandleReload($request, $auxResponse);


            //actualizar conductores que tengan un viaje en curso
            $conductores = $this->daoCon->buscarConductoreslibresCiudad($idCiudad);

        } catch (\Throwable $th) {
            $body = json_encode([
                'error' => 'error al buscar: ' . $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }

        $body = json_encode([
            'conductores' => $conductores,
            'success' => true
        ]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }
    public function HandleEstado(Request $request, Response $response, $accion, $id)
    {
        try {
            $conductor = $this->daoCon->obtener($id);
            if ($conductor === null) {
                throw new Exception('El conductor no existe');
            }
            if ($accion === 'ocupar') {
                $this->daoCon->ocuparConductor($id);
            } elseif ($accion === 'liberar') {
                $this->daoCon->liberarConductor($id);
            } else {
                throw new Exception('Error al realizar la accion');
            }
        } catch (\Throwable $th) {

            $body = json_encode([
                'error' => $th->getMessage(),
                'success' => false
            ]);
            $response->getBody()->write($body);
            return $response->withStatus(400);
        }


        $body = json_encode([
            'message' => 'Usuario ' . $id . ' ' . $accion,
            'success' => true
        ]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function crearConductor($id, $body)
    {
        $conductor = new Conductor();
        $conductor->setId($id);
        $conductor->setDni($body['dni'] ?? null);
        $conductor->setLicenciaTaxista($body['licenciaVTC'] ?? null);
        $conductor->setTitularTarjeta($body['titular_tarjeta'] ?? null);
        $conductor->setIbanTarjeta($body['n_tarjeta'] ?? null);
        $conductor->setUbiEspera($body['ubiEspera'] ?? null);
        $conductor->setLongEspera($body['lonEspera'] ?? null);
        $conductor->setLatiEspera($body['latEspera'] ?? null);
        $conductor->setEstado($body['estado'] ?? 'libre');
        $conductor->setCoche($body['matricula'] ?? null);
        $conductor->setHorario($body['horario'] ?? null);

        return $conductor;
    }

    private function validarDatos($id, $body)
    {

        $v_id = new Validator(['id' => $id]);
        $v_id->mapFieldsRules([
            'id' => ['required']
        ]);

        // Ejecuta la validación del ID
        if (!$v_id->validate()) {
            return [
                'success' => false,
                'message' => $v_id->errors()
            ];
        }


        $v = new Validator($body);
        $v->mapFieldsRules([
            'dni' => ['required', ['lengthMax', 15]],  // Campo obligatorio, longitud máxima de 15
            'licenciaVTC' => [['lengthMax', 15]],  // Opcional, longitud máxima de 15
            'titular_tarjeta' => [['lengthMax', 30]],   // Opcional, longitud máxima de 30
            'n_tarjeta' => [['lengthMax', 30]],      // Opcional, longitud máxima de 30
            'ubiEspera' => [['lengthMax', 1000]],
            'lonEspera' => ['numeric', ['regex', '/^-?\d{1,3}(\.\d{1,9})?$/']],
            'latEspera' => ['numeric', ['regex', '/^-?\d{1,3}(\.\d{1,9})?$/']],
            'coche' => [['lengthMax', 12]],  // Opcional, longitud máxima de 12
            'horario' => ['required', 'integer']
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
    private function validarDatosActualizacion($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'dni' => [['lengthMax', 15]],  // Campo obligatorio, longitud máxima de 15
            'licencia_taxista' => [['lengthMax', 15]],  // Opcional, longitud máxima de 15
            'titular_tarjeta' => [['lengthMax', 30]],   // Opcional, longitud máxima de 30
            'iban_tarjeta' => [['lengthMax', 30]],      // Opcional, longitud máxima de 30
            'ubiEspera' => [['lengthMax', 1000]],
            'lonEspera' => ['numeric', ['regex', '/^-?\d{1,3}(\.\d{1,9})?$/']],
            'latEspera' => ['numeric', ['regex', '/^-?\d{1,3}(\.\d{1,9})?$/']],
            'estado' => [['in', ['libre', 'ocupado', 'fuera de servicio']]],  // Campo obligatorio, con 3 posibles valores
            'coche' => [['lengthMax', 12]],  // Opcional, longitud máxima de 12
            'horario' => ['integer']
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