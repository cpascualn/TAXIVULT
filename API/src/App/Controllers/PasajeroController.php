<?php
namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;

use App\Models\DaoPasajero;
use App\Entities\Pasajero;


class PasajeroController
{

    public function __construct(private DaoPasajero $daoPas)
    {
    }


    public function Handlelistar(Request $request, Response $response)
    {

        $this->daoPas->listar();

        $body = json_encode($this->daoPas->pasajeros);
        $response->getBody()->write($body);
        return $response;
    }

    public function HandleObtener(Request $request, Response $response, array $args)
    {

        $id = $args['id'];


        $pasajero = $this->daoPas->obtener($id);

        if ($pasajero === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = json_encode($pasajero);
        $response->getBody()->write($body);
        return $response;
    }


    public function HandleInsertar(Request $request, Response $response, $id)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        $validacion = $this->validarDatos($id, $body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Validation faileed',
                'id' => $validacion['id'],
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario e insertarlo

        $pasajero = $this->crearPasajero($id, $body);
        $this->daoPas->insertar($pasajero);
        $pasajero = $this->daoPas->obtener($id);
        $body = json_encode([
            'message' => 'Pasajero creado',
            'pasajero' => $pasajero,
        ]);

        $response->getBody()->write($body);

        return $response;
    }

    public function HandleActualizar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        //comprobar que existe
        $pasajero = $this->daoPas->obtener($id);
        if ($pasajero === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = $request->getParsedBody();
        $validacion = $this->validarDatosActualizacion($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Validatioon failed',
                'el id es: ' => $id,
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario y actualizarlo
        $nuevo = $this->crearPasajero($id, $body);
        $this->daoPas->actualizar($id, $pasajero, $nuevo);
        $nuevo = $this->daoPas->obtener($id);
        $valores = ': ';
        foreach ($body as $key => $value) {
            $valores .= $key . ', ';
        }
        $body = json_encode([
            'message' => 'valores' . $valores . 'actualizados en el usuario ' . $id,
            'usuario' => $nuevo,
        ]);

        $response->getBody()->write($body);

        return $response;
    }

    public function HandleEliminar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];


        $pasajero = $this->daoPas->obtener($id);

        if ($pasajero === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $this->daoPas->eliminar($id);
        $body = json_encode([
            'message' => 'Usuario ' . $id . ' Borrado'
        ]);
        $response->getBody()->write($body);
        return $response;
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
                'id' => $id,
                'messages' => $v_id->errors()
            ];
        }

        $v = new Validator($body);
        $v->mapFieldsRules([
            'n_tarjeta' => ['required', ['lengthMax', 30]],
            'titular_tarjeta' => ['required', ['lengthMax', 15]],
            'caducidad_tarjeta' => ['required', ['lengthMax', 30]],
            'cvv_tarjeta' => ['required', ['lengthMax', 5]],
        ]);

        if (!$v->validate()) {
            return [
                'success' => false,
                'messages' => $v->errors()
            ];
        }

        return [
            'success' => true,
            'messages' => []
        ];
    }
    private function validarDatosActualizacion($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'n_tarjeta' => ['required', ['lengthMax', 30]],
            'titular_tarjeta' => ['required', ['lengthMax', 15]],
            'caducidad_tarjeta' => ['required', ['lengthMax', 30]],
            'cvv_tarjeta' => ['required', ['lengthMax', 5]],
        ]);

        if (!$v->validate()) {
            return [
                'success' => false,
                'messages' => $v->errors()
            ];
        }

        return [
            'success' => true,
            'messages' => []
        ];
    }

    public function crearPasajero($id, $body)
    {
        $pasajero = new Pasajero();
        $pasajero->setId($id);
        $pasajero->setNTarjeta($body['n_tarjeta'] ?? null);
        $pasajero->setTitularTarjeta($body['titular_tarjeta'] ?? null);
        $pasajero->setCaducidadTarjeta($body['caducidad_tarjeta'] ?? null);
        $pasajero->setCvvTarjeta($body['cvv_tarjeta'] ?? null);
        return $pasajero;
    }

}