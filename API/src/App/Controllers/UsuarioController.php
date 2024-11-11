<?php
namespace App\Controllers;

use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use Firebase\JWT\JWT;
use App\Models\DaoUsuario;
use App\Entities\Usuario;
use App\Controllers\ConductorController;
use App\Controllers\PasajeroController;
use Slim\App;
use Slim\Factory\AppFactory;

class UsuarioController
{
    private DaoUsuario $daoUsu;
    private ConductorController $controladorCon;
    private PasajeroController $controladorPas;

    public function __construct(
        DaoUsuario $daoUsu,
        ConductorController $controladorCon,
        PasajeroController $controladorPas
    ) {
        $this->daoUsu = $daoUsu;
        $this->controladorCon = $controladorCon;
        $this->controladorPas = $controladorPas;
    }

    public function HandleLogin(Request $request, Response $response)
    {
        $input = $request->getParsedBody();
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        $usu = $this->daoUsu->obtenerPorEmail($email);

        // si encuentra usuario y la contrasena coincide devolver token
        if ($usu == null || !password_verify(trim($password), trim($usu->getContrasena()))) {
            $response->getBody()->write(json_encode(['error' => 'Credenciales no validas', 'success' => false]));
            return $response->withStatus(401);
        }

        $token = $this->generarJwtToken($usu);

        $response->getBody()->write(json_encode(['access_token' => $token, 'success' => true]));
        return $response->withStatus(200);

    }

    public function HandleRegister(Request $request, Response $response)
    {
        $usuario = null;
        //crear una response para almacenar el mensaje de la insercion y tener la otra para devolver a cliente
        $app = AppFactory::create();
        $auxResponse = $app->getResponseFactory()->createResponse();
        try {
            $InsertResponse = $this->HandleInsertar($request, $auxResponse);

            if ($InsertResponse->getStatusCode() == 400 || $InsertResponse->getStatusCode() == 500)
                throw new Exception("Error en el registro");

            $body = $request->getParsedBody();
            $usuario = $this->daoUsu->obtenerPorEmail($body['email']);
            if ($usuario == null)
                throw new Exception("Error en el registro");

        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode(value: ['error' => $th->getMessage(), 'success' => false]));
            return $response->withStatus(400);
        }

        if ($usuario != null) {
            $response->getBody()->write(json_encode(value: ['message' => 'usuario registrado', 'success' => true]));
            return $response->withStatus(200);
        }

        return $response->withStatus(400);
    }

    public function HandleListar(Request $request, Response $response)
    {
        $usuarios = $this->daoUsu->listar();


        $response->getBody()->write(json_encode(['usuarios' => $usuarios, 'success' => true]));
        return $response->withStatus(200);
    }

    public function HandleBuscar(Request $request, Response $response)
    {
        $body = $request->getParsedBody();


        $encontrados = $this->daoUsu->buscar($body);
        if ($encontrados != null && count($encontrados) > 0) {
            $body = json_encode(['usuarios' => $encontrados, 'success' => true]);
        } else {
            $response->getBody()->write(json_encode([
                'message' => 'no se encontraron usuarios',
                'success' => false
            ]));
            return $response->withStatus(404);
        }
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandleObtener(Request $request, Response $response, string $id)
    {

        $usu = $this->daoUsu->obtener($id);

        if ($usu === null) {
            $response->getBody()->write(json_encode([
                'message' => 'El usuario no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }


        $response->getBody()->write(json_encode(['usuario' => $usu, 'success' => true]));
        return $response->withStatus(200);
    }


    public function HandleInsertar(Request $request, Response $response)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        $validacion = $this->validarDatos($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'message' => 'error validacion',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear usuario e insertarlo
        $usu = $this->crearUsuario($body);
        if ($this->daoUsu->obtenerPorEmail($usu->getEmail()) != null) {
            $response->getBody()->write(json_encode([
                'error' => 'El usuario ya existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }


        try {
            $this->daoUsu->insertar($usu);
            $usu = $this->daoUsu->obtenerPorEmail($usu->getEmail());

            $response = $this->insertarUsuarioEnSuRol($request, $response, $usu);

            if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {
                $this->daoUsu->eliminar($usu->getId());
                return $response;
            }
        } catch (\Throwable $th) {
            $this->daoUsu->eliminar($usu->getId());
            $response->getBody()->write(json_encode([
                'error' => $th->getMessage(),
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'Usuario creado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function HandleActualizar(Request $request, Response $response, string $id)
    {
        //comprobar que existe
        $usu = $this->daoUsu->obtener($id);
        if ($usu === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
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
        $nuevo = $this->crearUsuario($body);
        $this->daoUsu->actualizar($id, $usu, $nuevo);
        $nuevo = $this->daoUsu->obtener($id);
        $valores = ': ';
        foreach ($body as $key => $value) {
            $valores .= $key . ', ';
        }
        $body = json_encode([
            'message' => 'valores' . $valores . 'actualizados en el usuario ' . $id,
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function HandleEliminar(Request $request, Response $response, string $id)
    {

        try {
            $usu = $this->daoUsu->obtener($id);

            if ($usu === null) {
                throw new \Slim\Exception\HttpNotFoundException($request, message: 'El usuario no existe');
            }

            $this->daoUsu->eliminar($id);

            $body = json_encode([
                'message' => 'Usuario ' . $id . ' Borrado',
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
            'fecha_creacion' => ['date'],
            'rol' => ['required', 'integer']
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
                'message' => $v->errors()
            ];
        }

        return [
            'success' => true,
            'message' => []
        ];
    }

    private function crearUsuario($body)
    {
        $usu = new Usuario();
        $usu->setId(null);
        $usu->setEmail($body['email'] ?? null);
        $usu->setTelefono($body['telefono'] ?? null);
        $usu->setNombre($body['nombre'] ?? null);
        $usu->setApellidos($body['apellidos'] ?? null);
        $usu->setContrasena(isset($body['contrasena']) ? password_hash($body['contrasena'], PASSWORD_DEFAULT) : null);
        $usu->setCiudad($body['ciudad'] ?? null);
        $usu->setFechaCreacion(date("Y-m-d"));
        $usu->setRol($body['rol'] ?? null);

        return $usu;
    }

    private function insertarUsuarioEnSuRol($request, $response, $usu)
    {
        switch ($usu->getRol()) {
            case '1': //admin
                break;
            case '2': //conductor
                $response = $this->controladorCon->HandleInsertar($request, $response, $usu->getId());

                break;
            case '3': //pasajero
                $response = $this->controladorPas->HandleInsertar($request, $response, $usu->getId());

                break;
            default:
                break;
        }
        //si no se ha podido insertar en su rol se borra el usuario

        if ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) {
            $this->daoUsu->eliminar($usu->getId());
            return $response->withStatus(400);
        }

        return $response->withStatus(200);

    }

    private function generarJwtToken($usu)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 86400; // Token válido por 1 dia
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => array(
                'userId' => $usu->getId(),
                'email' => $usu->getEmail(),
                'rol' => $usu->getRol()
            )
        ];
        $jwtKey = $_ENV['JWT_SECRET_KEY'];

        $token = JWT::encode($payload, $jwtKey, 'HS256');
        return $token;
    }

}