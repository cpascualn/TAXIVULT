<?php
namespace App\Models;
use App\Database\Database;
use App\Entities\Horario;



class DaoHorario
{

    public $horarios = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function listar()
    {
        $consulta = 'SELECT * FROM Horario';

        $this->horarios = array();  //Vaciamos el array de las situaciones entre consulta y consulta

        $this->db->ConsultaDatos($consulta);

        foreach ($this->db->filas as $fila) {
            $horario = new Horario();
            $horario->setId($fila['id']);
            $horario->setNombre($fila['nombre']);
            $horario->setHoraIni1($fila['hora_ini1']);
            $horario->setHoraFin1($fila['hora_fin1']);
            $horario->setHoraIni2($fila['hora_ini2']);
            $horario->setHoraFin2($fila['hora_fin2']);
            $horario->setTarifaDia($fila['tarifa_dia']);
            $horario->setTarifaMinuto($fila['tarifa_minuto']);

            $this->horarios[] = $horario;   //Insertamos el objeto con los valores de esa fila en el array de objetos
        }

        return $this->horarios;
    }
    public function obtener($id)
    {
        $consulta = 'SELECT * FROM Horario WHERE id = :ID';
        $param[':ID'] = $id;
        $this->db->ConsultaDatos($consulta, $param);
        $horario = null;
        if (count($this->db->filas) > 0) {
            $horario = new Horario();
            $horario->setId($this->db->filas[0]['id']);
            $horario->setNombre($this->db->filas[0]['nombre']);
            $horario->setHoraIni1($this->db->filas[0]['hora_ini1']);
            $horario->setHoraFin1($this->db->filas[0]['hora_fin1']);
            $horario->setHoraIni2($this->db->filas[0]['hora_ini2']);
            $horario->setHoraFin2($this->db->filas[0]['hora_fin2']);
            $horario->setTarifaDia($this->db->filas[0]['tarifa_dia']);
            $horario->setTarifaMinuto($this->db->filas[0]['tarifa_minuto']);
        }
        return $horario;
    }


    public function buscarHorario($hora)
    {
        $consulta = 'SELECT * FROM Horario
                    WHERE ( 
                        (:HORA BETWEEN hora_ini1 AND hora_fin1) 
                        OR (hora_ini1 > hora_fin1 AND (:HORA >= hora_ini1 OR :HORA <= hora_fin1))
                        )
                    OR ( 
                        (:HORA BETWEEN hora_ini2 AND hora_fin2) 
                        OR (hora_ini2 > hora_fin2 AND (:HORA >= hora_ini2 OR :HORA <= hora_fin2))
                        )
                    LIMIT 1';

        $param[':HORA'] = $hora;
        $this->db->ConsultaDatos($consulta, $param);

        $horario = null;
        //Si la consulta devuelve un resultado, creamos un objeto Ciudad con los valores de esa fila y lo añadimos al array de objetos
        if (count($this->db->filas) == 1) {
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta
            $horario = new Horario();
            $horario->setId($fila['id']);
            $horario->setNombre($fila['nombre']);
            $horario->setHoraIni1($fila['hora_ini1']);
            $horario->setHoraFin1($fila['hora_fin1']);
            $horario->setHoraIni2($fila['hora_ini2']);
            $horario->setHoraFin2($fila['hora_fin2']);
            $horario->setTarifaDia($fila['tarifa_dia']);
            $horario->setTarifaMinuto($fila['tarifa_minuto']);

        }

        return $horario;
    }

    public function actualizar($id, $horario, $nuevo)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `Horario` SET tarifa_dia=:TARIFA_DIA, tarifa_minuto=:TARIFA_MINU WHERE id=:ID ";

        $param = array();
        $param[":ID"] = $id;
        $param[":TARIFA_DIA"] = $nuevo->getTarifaDia() ?? $horario->getTarifaDia();
        $param[":TARIFA_MINU"] = $nuevo->getTarifaMinuto() ?? $horario->getTarifaMinuto();
        $this->db->ConsultaSimple($consulta, $param);

    }

}