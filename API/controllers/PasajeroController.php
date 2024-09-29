<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
require_once APP_ROOT . '/models/DaoPasajero.php';
require_once APP_ROOT . '/entities/Pasajero.php';
class PasajeroController
{


    public function listar(Request $request, Response $response)
    {
        $daoPas = new DaoPasajero("taxivult");
        $daoPas->listar();

        $body = json_encode($daoPas->pasajeros);
        $response->getBody()->write($body);
        return $response;
    }

    public function obtener(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $daoPas = new DaoPasajero("taxivult");
        $pasajero = $daoPas->obtener($id);

        if ($pasajero === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = json_encode($pasajero);
        $response->getBody()->write($body);
        return $response;
    }


    public function insertar(Request $request, Response $response, $id)
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
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        //si son validos, crear usuario e insertarlo
        $daoPas = new DaoPasajero("taxivult");
        $pasajero = $this->crearPasajero($id, $body);
        $daoPas->insertar($pasajero);
        $pasajero = $daoPas->obtener($id);
        $body = json_encode([
            'message' => 'Pasajero creado',
            'pasajero' => $pasajero,
        ]);

        $response->getBody()->write($body);

        return $response;
    }

    public function actualizar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];
        $daoPas = new DaoPasajero("taxivult");
        //comprobar que existe
        $pasajero = $daoPas->obtener($id);
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
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        //si son validos, crear usuario y actualizarlo
        $nuevo = $this->crearPasajero($id,$body);
        $daoPas->actualizar($id, $pasajero, $nuevo);
        $nuevo = $daoPas->obtener($id);
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

    public function eliminar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $daoPas = new DaoPasajero("taxivult");
        $pasajero = $daoPas->obtener($id);

        if ($pasajero === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $daoPas->eliminar($id);
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
        $pasajero->__set("id", $id);
        $pasajero->__set("n_tarjeta", $body['n_tarjeta'] ?? null);
        $pasajero->__set("titular_tarjeta", $body['titular_tarjeta'] ?? null);
        $pasajero->__set("caducidad_tarjeta", $body['caducidad_tarjeta'] ?? null);
        $pasajero->__set("cvv_tarjeta", $body['cvv_tarjeta'] ?? null);
        return $pasajero;
    }

}