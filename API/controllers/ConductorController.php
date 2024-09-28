<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;

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


    public function insertar(Request $request, Response $response)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        $validacion = $this->validarDatos($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Validation failed',
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        //si son validos, crear usuario e insertarlo
        $daoCon = new DaoConductor("taxivult");
        $conductor = $this->crearConductor($body);
        $daoCon->insertar($conductor);


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
        $nuevo = $this->crearConductor($body);
        $daoCon->actualizar($id,$conductor,$nuevo);
        $nuevo = $daoCon->obtener($id);
        $valores = ': ';
        foreach ($body as $key => $value) {
            $valores.= $key . ', ' ;
        }
        $body = json_encode([
            'message' => 'valores'. $valores . 'actualizados en el usuario ' . $id,
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


    private function validarDatos($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'dni' => ['required', ['lengthMax', 15]],  
            'licencia_taxista' => [['lengthMax', 15]],  
            'titular_tarjeta' => [['lengthMax', 30]],   
            'iban_tarjeta' => [['lengthMax', 30]],      
            'long_espera' => ['decimal', ['maxDigits', 6, 4]],  
            'lati_espera' => ['decimal', ['maxDigits', 9, 6]],  
            'estado' => ['required', ['in', ['libre', 'ocupado', 'fuera de servicio']]],  
            'coche' => [['lengthMax', 12]],  
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
            'dni' => ['required', ['lengthMax', 15]],  
            'licencia_taxista' => [['lengthMax', 15]],  
            'titular_tarjeta' => [['lengthMax', 30]],   
            'iban_tarjeta' => [['lengthMax', 30]],      
            'long_espera' => ['decimal', ['maxDigits', 6, 4]],  
            'lati_espera' => ['decimal', ['maxDigits', 9, 6]],  
            'estado' => ['required', ['in', ['libre', 'ocupado', 'fuera de servicio']]],  
            'coche' => [['lengthMax', 12]],  
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

    private function crearConductor($body)
    {
        $conductor = new Usuario();
        $conductor->__set('id', null);
        $conductor->__set('email', $body['email'] ?? null);
        $conductor->__set('telefono', $body['telefono'] ?? null);
        $conductor->__set('nombre', $body['nombre'] ?? null);
        $conductor->__set('apellidos', $body['apellidos'] ?? null);
        $conductor->__set('contrasena', isset($body['contrasena']) ? password_hash($body['contrasena'], PASSWORD_DEFAULT) : null);
        $conductor->__set('ciudad', $body['ciudad'] ?? null);
        $conductor->__set('fecha_creacion', $body['fecha_creacion'] ?? null);
        $conductor->__set('rol', $body['rol'] ?? null);

        return $conductor;
    }

}