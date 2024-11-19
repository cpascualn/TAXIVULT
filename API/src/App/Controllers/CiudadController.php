<?php
namespace App\Controllers;


use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Models\DaoCiudad;
use App\Entities\Ciudad;

class CiudadController
{
    private DaoCiudad $daoCiu;

    public function __construct(
        DaoCiudad $daoCiu,

    ) {
        $this->daoCiu = $daoCiu;
    }


    public function HandleListar(Request $request, Response $response)
    {
        $ciudades = $this->daoCiu->listar();


        $response->getBody()->write(json_encode(['ciudades' => $ciudades, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleObtener(Request $request, Response $response, $id)
    {
        $ciudad = $this->daoCiu->obtener($id);
        if ($ciudad === null) {
            $response->getBody()->write(json_encode([
                'message' => 'La ciudad no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }
        $horaActual = date('H:i:s');
        $response->getBody()->write(json_encode(['ciudad' => $ciudad, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleObtenerPorNombre(Request $request, Response $response, $nombreCiudad)
    {
        $ciudad = $this->daoCiu->obtenerPorNombre($nombreCiudad);
        if ($ciudad === null) {
            $response->getBody()->write(json_encode([
                'message' => 'La ciudad no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode(['ciudad' => $ciudad, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleInsertar(Request $request, Response $response)
    {
        //recibir datos del body y validarlos
        $body = $request->getParsedBody();
        //si es el administrador, validar los datos para el administrador
        $validacion = $this->validarDatos($body);
        if (!$validacion['success']) {
            $response->getBody()->write(json_encode([
                'error' => 'error validacion',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        //si son validos, crear ciudad e insertarlo
        $ciudad = $this->crearCiudad($body);
        if ($this->daoCiu->obtenerPorNombre($ciudad->getNombre()) != null) {
            $response->getBody()->write(json_encode([
                'error' => 'La ciudad ya existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }


        try {
            $this->daoCiu->insertar($ciudad);

        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode([
                'error' => $th->getMessage(),
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'Ciudad creada',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    public function handleEliminar(Request $request, Response $response, string $id)
    {
        try {
            $ciudad = $this->daoCiu->obtener($id);

            if ($ciudad === null) {
                throw new \Slim\Exception\HttpNotFoundException($request, message: 'La ciudad no existe');
            }

            $this->daoCiu->eliminar($id);

            $body = json_encode([
                'message' => 'Ciudad ' . $id . ' Borrado',
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


    private function crearCiudad($ciudad)
    {
        $ciu = new Ciudad();
        $ciu->setId(null);
        $ciu->setNombre(nombre: $ciudad['nombre']);
        $ciu->setComunidad(comunidad: $ciudad['comunidad']);
        $ciu->setPais(pais: $ciudad['pais']);
        $ciu->setLat($ciudad['lat']);
        $ciu->setLong($ciudad['long']);
        $ciu->setLong_min($ciudad['long_min']);
        $ciu->setLong_max($ciudad['long_max']);
        $ciu->setLat_min($ciudad['lat_min']);
        $ciu->setLat_max($ciudad['lat_max']);
        return $ciu;
    }
    private function validarDatos($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'nombre' => ['required', ['lengthMax', 100]],
            'comunidad' => ['required', ['lengthMax', 150]],
            'pais' => ['required', ['lengthMax', 30]],
            'lat_min' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
            'lat_max' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
            'long_min' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
            'long_max' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
            'lat' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
            'long' => ['required', 'numeric', ['regex', '/^-?\d{1,12}\.\d{1,9}$/']],
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