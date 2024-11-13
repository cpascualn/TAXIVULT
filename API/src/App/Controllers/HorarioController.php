<?php
namespace App\Controllers;

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

}