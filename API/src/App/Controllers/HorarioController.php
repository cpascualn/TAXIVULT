<?php
namespace App\Controllers;

use App\Entities\Horario;
use App\Models\DaoHorario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;


class HorarioController
{
    private DaoHorario $daoHorario;

    public function __construct(
        DaoHorario $daoHorario,

    ) {
        $this->daoHorario = $daoHorario;
    }


    public function HandleListar(Request $request, Response $response)
    {
        $horarios = $this->daoHorario->listar();


        $response->getBody()->write(json_encode(['horarios' => $horarios, 'success' => true]));
        return $response->withStatus(200);
    }

    public function handleBuscarHorario(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $horario = $this->daoHorario->buscarHorario($body['horario']);
        if ($horario === null) {
            $response->getBody()->write(json_encode([
                'message' => 'El horario no existe',
                'success' => false
            ]));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode(['horario' => $horario, 'success' => true]));
        return $response->withStatus(200);
    }


    public function handleActualizar(Request $request, Response $response, $id)
    {
        //comprobar que existe
        $horario = $this->daoHorario->obtener($id);
        if ($horario === null) {
            throw new \Slim\Exception\HttpNotFoundException($request, message: 'El horario no existe');
        }

        $body = $request->getParsedBody();

        //si son validos, crear horario y actualizarlo
        $nuevo = $this->crearHorario($body);
        $this->daoHorario->actualizar($id, $horario, $nuevo);
        $nuevo = $this->daoHorario->obtener($id);

        $body = json_encode([
            'message' => 'horario actualizado ',
            'success' => true
        ]);

        $response->getBody()->write($body);

        return $response->withStatus(200);
    }

    private function crearHorario($datos)
    {
        $horario = new Horario();
        $horario->setId(null);
        $horario->setNombre($datos['nombre'] ?? null);
        $horario->setHoraIni1($datos['hora_ini1'] ?? null);
        $horario->setHoraFin1($datos['hora_fin1'] ?? null);
        $horario->setHoraIni2($datos['hora_ini2'] ?? null);
        $horario->setHoraFin2($datos['hora_fin2'] ?? null);
        $horario->setTarifaDia($datos['tarifa_dia'] ?? null);
        $horario->setTarifaMinuto($datos['tarifa_minuto'] ?? null);

        return $horario;
    }

}