<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
require_once APP_ROOT . '/models/DaoConductor.php';
require_once APP_ROOT . '/entities/Conductor.php';

class ConductorController
{

    public function listar(Request $request, Response $response)
    {
        $daoCon = new DaoConductor("taxivult");
        $daoCon->listar();

        $body = json_encode($daoCon->conductores);
        $response->getBody()->write($body);
        return $response;
    }

    public function obtener(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $daoCon = new DaoConductor("taxivult");
        $conductor = $daoCon->obtener($id);

        if ($conductor === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = json_encode($conductor);
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
                'error' => 'Validation failed',
                'messages' => $validacion['messages'],
                'id' => $validacion['id'],
            ]));
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        //si son validos, crear usuario e insertarlo
        $daoCon = new DaoConductor("taxivult");
        $conductor = $this->crearConductor($id, $body);
        try {
            $daoCon->insertar($conductor);
        } catch (\Throwable $th) {
            $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
            $body = json_encode([
                'message' => 'error',
                'en' => $th->getMessage(),
            ]);
            $response->getBody()->write($body);

            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }



        $body = json_encode([
            'message' => 'Usuario creado',
            'usuario' => $conductor,
        ]);

        $response->getBody()->write($body);

        return $response;
    }

    public function actualizar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];
        $daoCon = new DaoConductor("taxivult");
        //comprobar que existe
        $conductor = $daoCon->obtener($id);
        if ($conductor === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = $request->getParsedBody();
        $validacion = $this->validarDatosActualizacion($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Validation failed',
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        //si son validos, crear usuario y actualizarlo
        $nuevo = $this->crearConductor($id, $body);
        $daoCon->actualizar($id, $conductor, $nuevo);
        $nuevo = $daoCon->obtener($id);
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

        $daoCon = new DaoConductor("taxivult");
        $conductor = $daoCon->obtener($id);

        if ($conductor === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $daoCon->eliminar($id);
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
            'dni' => ['required', ['lengthMax', 15]],  // Campo obligatorio, longitud máxima de 15
            'licencia_taxista' => [['lengthMax', 15]],  // Opcional, longitud máxima de 15
            'titular_tarjeta' => [['lengthMax', 30]],   // Opcional, longitud máxima de 30
            'iban_tarjeta' => [['lengthMax', 30]],      // Opcional, longitud máxima de 30
            'long_espera' => ['required', 'numeric', ['regex', '/^-?\d{1,2}\.\d{1,4}$/']],  // Decimal con 1 o 2 dígitos enteros (positivo o negativo), y hasta 4 decimales
            'lati_espera' => ['required', 'numeric', ['regex', '/^-?\d{1,3}\.\d{1,6}$/']],  // Decimal con 1 a 3 dígitos enteros (positivo o negativo), y hasta 6 decimales
            'estado' => ['required', ['in', ['libre', 'ocupado', 'fuera de servicio']]],  // Campo obligatorio, con 3 posibles valores
            'coche' => [['lengthMax', 12]],  // Opcional, longitud máxima de 12
            'horario' => ['required', 'integer']
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
            'dni' => ['required', ['lengthMax', 15]],  // Campo obligatorio, longitud máxima de 15
            'licencia_taxista' => [['lengthMax', 15]],  // Opcional, longitud máxima de 15
            'titular_tarjeta' => [['lengthMax', 30]],   // Opcional, longitud máxima de 30
            'iban_tarjeta' => [['lengthMax', 30]],      // Opcional, longitud máxima de 30
            'long_espera' => ['required', 'numeric', ['regex', '/^-?\d{1,2}\.\d{1,4}$/']],  // Decimal con 1 o 2 dígitos enteros (positivo o negativo), y hasta 4 decimales
            'lati_espera' => ['required', 'numeric', ['regex', '/^-?\d{1,3}\.\d{1,6}$/']],  // Decimal con 1 a 3 dígitos enteros (positivo o negativo), y hasta 6 decimales
            'estado' => ['required', ['in', ['libre', 'ocupado', 'fuera de servicio']]],  // Campo obligatorio, con 3 posibles valores
            'coche' => [['lengthMax', 12]],  // Opcional, longitud máxima de 12
            'horario' => ['required', 'integer']
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

    public function crearConductor($id, $body)
    {
        $conductor = new Conductor();
        $conductor->__set('id', $id);
        $conductor->__set('dni', $body['dni'] ?? null);
        $conductor->__set('licencia_taxista', $body['licencia_taxista'] ?? null);
        $conductor->__set('titular_tarjeta', $body['titular_tarjeta'] ?? null);
        $conductor->__set('iban_tarjeta', $body['iban_tarjeta'] ?? null);
        $conductor->__set('long_espera', $body['long_espera'] ?? null);
        $conductor->__set('lati_espera', $body['lati_espera'] ?? null);
        $conductor->__set('estado', $body['estado'] ?? null);
        $conductor->__set('coche', $body['coche'] ?? null);
        $conductor->__set('horario', $body['horario'] ?? null);


        return $conductor;
    }

}