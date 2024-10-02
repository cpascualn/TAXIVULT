<?php
namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use Firebase\JWT\JWT;
use App\Models\DaoUsuario;
use App\Entities\Usuario;
use App\Controllers\ConductorController;
use App\Controllers\PasajeroController;

class UsuarioController
{
    private DaoUsuario $daoUsu;
    // private ConductorController $controladorCon;
    // private PasajeroController $controladorPas;

    public function __construct(
        DaoUsuario $daoUsu,
        //  ConductorController $controladorCon, PasajeroController $controladorPas
    ) {
        $this->daoUsu = $daoUsu;
        // $this->controladorCon = $controladorCon;
        // $this->controladorPas = $controladorPas;
    }

    public function HandleLogin(Request $request, Response $response)
    {
        $input = $request->getParsedBody();
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';


        $usu = $this->daoUsu->obtenerPorEmail($email);

        if ($usu == null || !password_verify($password, $usu->getContrasena)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid credentials']));
            return $response->withStatus(401);
        }

        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token válido por 1 hora
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'email' => $email,
        ];

        $token = JWT::encode($payload, 'your_secret_key', 'HS256');

        $response->getBody()->write(json_encode(['access_token' => $token]));
        return $response->withStatus(200);

    }

    public function HandleListar(Request $request, Response $response)
    {

        $usuarios = $this->daoUsu->listar();

        $body = json_encode( $usuarios);
        $response->getBody()->write($body);
        return $response;
    }

    public function HandleBuscar(Request $request, Response $response)
    {
        $body = $request->getParsedBody();


        $encontrados = $this->daoUsu->buscar($body);
        if ($encontrados != null && count($encontrados) > 0) {
            $body = json_encode(['encontrados' => $encontrados]);
        } else {
            $response->getBody()->write(json_encode([
                'messages' => 'no se encontraron usuarios'
            ]));
            return $response->withStatus(404);
        }
        $response->getBody()->write($body);
        return $response;
    }

    public function HandleObtener(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        $usu = $this->daoUsu->obtener($id);

        if ($usu === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = json_encode($usu);
        $response->getBody()->write($body);
        return $response;
    }


    public function HandleInsertar(Request $request, Response $response)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        $validacion = $this->validarDatos($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Vaalidation failed',
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario e insertarlo

        $usu = $this->crearUsuario($body);
        $this->daoUsu->insertar($usu);
        $usu = $this->daoUsu->obtenerPorEmail($usu->__get('email'));
        // $response = $this->insertarUsuarioEnSuRol($request, $response, $usu, $body);
        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {

            $this->daoUsu->eliminar($usu->__get('id'));
            return $response;
        }
        $body = json_encode([
            'message' => 'Usuario creado',
            'usuario' => $usu,
        ]);

        $response->getBody()->write($body);

        return $response;
    }

    public function HandleActualizar(Request $request, Response $response, array $args)
    {

        $id = $args['id'];

        //comprobar que existe
        $usu = $this->daoUsu->obtener($id);
        if ($usu === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $body = $request->getParsedBody();
        $validacion = $this->validarDatosActualizacion($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'Validation failedd',
                'messages' => $validacion['messages']
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario y actualizarlo
        $nuevo = $this->crearUsuario($body);
        $this->daoUsu->actualizar($id, $usu, $nuevo);
        $nuevo = $this->daoUsu->obtener($id);
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


        $usu = $this->daoUsu->obtener($id);

        if ($usu === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
        }

        $this->daoUsu->eliminar($id);
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
    private function validarDatosActualizacion($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'email' => ['email', ['lengthMax', 30]],
            'telefono' => [['lengthMax', 15]],
            'nombre' => [['lengthMax', 30]],
            'apellidos' => [['lengthMax', 30]],
            'contrasena' => [['lengthMax', 30]],
            'ciudad' => ['integer'],
            'fecha_creacion' => ['date'],
            'rol' => ['integer']
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
        $usu->__set('email', $body['email'] ?? null);
        $usu->__set('telefono', $body['telefono'] ?? null);
        $usu->__set('nombre', $body['nombre'] ?? null);
        $usu->__set('apellidos', $body['apellidos'] ?? null);
        $usu->__set('contrasena', isset($body['contrasena']) ? password_hash($body['contrasena'], PASSWORD_DEFAULT) : null);
        $usu->__set('ciudad', $body['ciudad'] ?? null);
        $usu->__set('fecha_creacion', $body['fecha_creacion'] ?? null);
        $usu->__set('rol', $body['rol'] ?? null);

        return $usu;
    }

    // private function insertarUsuarioEnSuRol($request, $response, $usu, $body)
    // {

    //     $controlador = null;
    //     switch ($usu->__get('rol')) {
    //         case '1': //admin
    //             break;
    //         case '2': //conductor

    //             $response = $this->controladorCon->HandleInsertar($request, $response, $usu->__get('id'));
    //             //si no se ha podido insertar en su rol se borra el usuario
    //             if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {

    //                 $this->daoUsu->eliminar($usu->__get('id'));
    //             }

    //             break;
    //         case '3': //pasajero
    //             $response = $this->controladorPas->HandleInsertar($request, $response, $usu->__get('id'));
    //             //si no se ha podido insertar en su rol se borra el usuario
    //             if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {

    //                 $this->daoUsu->eliminar($usu->__get('id'));
    //             }

    //             break;
    //         default:
    //             break;
    //     }

    //     return $response;

    // }

}