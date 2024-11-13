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

}