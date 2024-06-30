<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;

class UsuarioController
{

    public function listar(Request $request, Response $response)
    {
        $daoUsu = new DaoUsuario("taxivult");
        $daoUsu->listar();

        $body = json_encode($daoUsu->usuarios);
        $response->getBody()->write($body);
        return $response;
    }

    public function obtener(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $daoUsu = new DaoUsuario("taxivult");
        $usu = $daoUsu->obtener($id);

        if ($usu === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = json_encode($usu);
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
        $daoUsu = new DaoUsuario("taxivult");
        $usu = $this->crearUsuario($body);
        $daoUsu->insertar($usu);


        $body = json_encode([
            'message' => 'Usuario creado',
            'usuario' => $usu,
        ]);

        $response->getBody()->write($body);

        return $response;
    }


    private function validarDatos($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'email' => ['required', 'email', ['lengthMax', 30]],
            'telefono' => ['required', ['lengthMax', 15]],
            'nombre' => ['required', ['lengthMax', 30]],
            'apellidos' => ['required', ['lengthMax', 30]],
            'contrasena' => ['required', ['lengthMax', 30]],
            'ciudad' => ['required', 'integer'],
            'fecha_creacion' => ['required', 'date'],
            'rol' => ['required', 'integer']
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

    private function crearUsuario($body)
    {
        $usu = new Usuario();
        $usu->__set('id', null);
        $usu->__set('email', $body['email']);
        $usu->__set('telefono', $body['telefono']);
        $usu->__set('nombre', $body['nombre']);
        $usu->__set('apellidos', $body['apellidos']);
        $usu->__set('contrasena', password_hash($body['contrasena'], PASSWORD_DEFAULT));
        $usu->__set('ciudad', $body['ciudad']);
        $usu->__set('fecha_creacion', $body['fecha_creacion']);
        $usu->__set('rol', $body['rol']);

        return $usu;
    }

}