<?php
namespace App\Controllers;


use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Models\DaoViaje;
use App\Entities\Viaje;

class ViajeController
{
    public function __construct(
        private DaoViaje $daoViaje
    ) {
    }


    public function Handlelistar(Request $request, Response $response)
    {

        $this->daoViaje->listar();

        $body = json_encode(['viajes' => $this->daoViaje->viajes, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandleObtenerViajesActivosUsuario(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $cantidad = $this->daoViaje->obtenerViajesActivosUsuario($body['id']);

        $body = json_encode(['activos' => $cantidad, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }

    public function HandleObtenerViajesUsuario(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $this->daoViaje->obtenerViajesUsuario($body['id']);

        $body = json_encode(['viajes' => $this->daoViaje->viajes, 'success' => true]);
        $response->getBody()->write($body);
        return $response->withStatus(200);
    }


    public function HandleInsertar(Request $request, Response $response)
    {
        //recibir datos del body y validarlos
        try {
            $body = $request->getParsedBody();
            $validacion = $this->validarDatos($body);
            if (!$validacion['success']) {
                $response->getBody()->write(json_encode([
                    'message' => $validacion['message'],
                    'success' => false
                ]));
                return $response->withStatus(400);
            }

            //si son validos, crear usuario e insertarlo

            $viaje = $this->crearViaje($body);
            $this->daoViaje->insertar($viaje);
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode([
                'message' => $th->getMessage(),
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $body = json_encode([
            'message' => 'Viaje creado',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }



    private function crearViaje($body)
    {

        $viaje = new Viaje();
        $distancia = floor($body['distancia'] * 100) / 100; // Truncar a 2 decimales
        $fecha_ini = $body['fecha_ini'] / 1000;
        $fecha_fin = $body['fecha_fin'] / 1000;
        $viaje->setIdConductor($body['id_conductor']);
        $viaje->setIdPasajero($body['id_pasajero']);
        $viaje->setLatiIni($body['lati_ini']);
        $viaje->setLongiIni($body['longi_ini']);
        $viaje->setLatiFin($body['lati_fin']);
        $viaje->setLongiFin($body['longi_fin']);
        $viaje->setFechaIni($fecha_ini);
        $viaje->setFechaFin($fecha_fin);
        $viaje->setMetodoPago($body['metodo_pago']);
        $viaje->setDistancia($distancia);
        $viaje->setDuracionMin($body['duracion_min']);
        $viaje->setPrecioTotal($body['precio_total']);
        $viaje->setCiudad($body['ciudad']);
        $viaje->setLugarSalida($body['lugar_salida']);
        $viaje->setLugarLlegada($body['lugar_llegada']);
        return $viaje;
    }

    private function validarDatos($body)
    {
        $v = new Validator($body);
        $v->mapFieldsRules([
            'id_conductor' => ['integer'],
            'id_pasajero' => ['integer'],
            'lati_ini' => ['numeric', ['regex', '/^-?\d{1,15}\.\d{1,12}$/']],
            'longi_ini' => ['numeric', ['regex', '/^-?\d{1,15}\.\d{1,12}$/']],
            'lati_fin' => ['numeric', ['regex', '/^-?\d{1,15}\.\d{1,12}$/']],
            'longi_fin' => ['numeric', ['regex', '/^-?\d{1,15}\.\d{1,12}$/']],
            'fecha_ini' => ['integer'],
            'fecha_fin' => ['integer'],
            'metodo_pago' => [['in', ['efectivo', 'tarjeta']]],
            'distancia' => ['numeric'],
            'duracion_min' => ['integer'],
            'precio_total' => ['numeric', ['regex', '/^-?\d{1,15}\.\d{1,12}$/']],
            'lugar_salida' => [['lengthMax', 1000]],
            'lugar_llegada' => [['lengthMax', 1000]],
            'ciudad' => ['integer']
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