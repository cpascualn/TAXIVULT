<?php
namespace App\Models;
use App\Database\Database;

use App\Entities\Conductor;

class DaoConductor extends Database
{
    public $conductores = array();

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    //lista de conductores
    public function listar()
    {
        $consulta = "SELECT * FROM Conductor";
        $this->db->ConsultaDatos($consulta);

        $this->conductores = [];
        foreach ($this->filas as $fila) {
            $con = new Conductor();
            $con->setId($fila['id']);
            $con->setDni($fila['dni']);
            $con->setLicenciaTaxista($fila['licencia_taxista']);
            $con->setTitularTarjeta($fila['titular_tarjeta']);
            $con->setIbanTarjeta($fila['iban_tarjeta']);
            $con->setLongEspera($fila['long_espera']);
            $con->setLatiEspera($fila['lati_espera']);
            $con->setEstado($fila['estado']);
            $con->setCoche($fila['coche']);
            $con->setHorario($fila['horario']);

            $this->conductores[] = $con;   //Insertamos el objeto con los valores de esa fila en el array de objetos

        }

        return $this->conductores;
    }

    // Obtener un conductor por su ID
    public function obtener($id)
    {
        $consulta = "SELECT * FROM Conductor WHERE id = :ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaDatos($consulta, $param);

        $conductor = null;

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta
            $conductor = new Conductor();
            $conductor->setId($fila['id']);
            $conductor->setDni($fila['dni']);
            $conductor->setLicenciaTaxista($fila['licencia_taxista']);
            $conductor->setTitularTarjeta($fila['titular_tarjeta']);
            $conductor->setIbanTarjeta($fila['iban_tarjeta']);
            $conductor->setLongEspera($fila['long_espera']);
            $conductor->setLatiEspera($fila['lati_espera']);
            $conductor->setEstado($fila['estado']);
            $conductor->setCoche($fila['coche']);
            $conductor->setHorario($fila['horario']);
        }

        return $conductor;
    }

    // Insertar un nuevo conductor
    public function insertar(Conductor $conductor)
    {
        $consulta = "INSERT INTO Conductor (id, dni, licencia_taxista, titular_tarjeta, iban_tarjeta, long_espera, lati_espera, estado, coche, horario) 
                     VALUES (:ID, :DNI, :LICENCIA_TAXISTA, :TITULAR_TARJETA, :IBAN_TARJETA, :long_espera, :LATI_ESPERA, :ESTADO, :COCHE, :HORARIO)";
        $param = array(
            ":ID" => $conductor->getId(),
            ":DNI" => $conductor->getDni(),
            ":LICENCIA_TAXISTA" => $conductor->getLicenciaTaxista(),
            ":TITULAR_TARJETA" => $conductor->getTitularTarjeta(),
            ":IBAN_TARJETA" => $conductor->getIbanTarjeta(),
            ":long_espera" => $conductor->getLongEspera(),
            ":LATI_ESPERA" => $conductor->getLatiEspera(),
            ":ESTADO" => $conductor->getEstado(),
            ":COCHE" => $conductor->getCoche(),
            ":HORARIO" => $conductor->getHorario()
        );
        $this->db->ConsultaSimple($consulta, $param);
    }

    // Actualizar un conductor
    public function actualizar($id, $conductor, $nuevo)
    {
        $consulta = "UPDATE Conductor SET dni = :DNI, licencia_taxista = :LICENCIA_TAXISTA, titular_tarjeta = :TITULAR_TARJETA, 
                     iban_tarjeta = :IBAN_TARJETA, long_espera = :long_espera, lati_espera = :LATI_ESPERA, estado = :ESTADO, 
                     coche = :COCHE, horario = :HORARIO 
                     WHERE id = :ID";


        $param = array(
            ":ID" => $id,
            ":DNI" => $nuevo->getDni() ?? $conductor->getDni(),
            ":LICENCIA_TAXISTA" => $nuevo->getDni() ?? $conductor->getDni(),
            ":TITULAR_TARJETA" => $nuevo->getTitularTarjeta() ?? $conductor->getTitularTarjeta(),
            ":IBAN_TARJETA" => $nuevo->getIbanTarjeta() ?? $conductor->getIbanTarjeta(),
            ":long_espera" => $nuevo->getLongEspera() ?? $conductor->getLongEspera(),
            ":LATI_ESPERA" => $nuevo->getLatiEspera() ?? $conductor->getLatiEspera(),
            ":ESTADO" => $nuevo->getEstado() ?? $conductor->getEstado(),
            ":COCHE" => $nuevo->getCoche() ?? $conductor->getCoche(),
            ":HORARIO" => $nuevo->getHorario() ?? $conductor->getHorario()
        );
        $this->db->ConsultaSimple($consulta, $param);
    }

    // Eliminar un conductor
    public function eliminar($id)
    {
        $consulta = "DELETE FROM Conductor WHERE id = :ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaSimple($consulta, $param);
    }

    // actualiza todos los estados en la hora actual dependiendo del horario del conductor, excepto los ocupados
    public function actualizarEstados()
    {
        $hora = date('H:i:s');
        $consulta = "UPDATE Conductor c
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
         WHEN ((:HORA_ACTUAL >= TIME(h.hora_ini1) AND :HORA_ACTUAL <= TIME(h.hora_fin1)) OR
              (:HORA_ACTUAL >= TIME(h.hora_ini2) AND :HORA_ACTUAL <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (:HORA_ACTUAL >= TIME(h.hora_ini1) OR :HORA_ACTUAL <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (:HORA_ACTUAL >= TIME(h.hora_ini2) OR :HORA_ACTUAL <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE h.nombre IN ('diurno', 'nocturno') 
      AND c.estado != 'ocupado'
        ";
        $param = array(
            "HORA_ACTUAL" => $hora,
        );

        $this->db->ConsultaSimple($consulta, $param);
    }
    // actualiza los estados de conductores ocupados que ya hayan acabado el viaje (desocupar)
    public function actualizarEstadosOcupados()
    {
        $hora = date('H:i:s');
        $horaEpoch = time();
        $consulta = "UPDATE Conductor c
    JOIN Viaje v ON v.id_conductor = c.id
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
        WHEN ((:HORA_ACTUAL >= TIME(h.hora_ini1) AND :HORA_ACTUAL <= TIME(h.hora_fin1)) OR
              (:HORA_ACTUAL >= TIME(h.hora_ini2) AND :HORA_ACTUAL <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (:HORA_ACTUAL >= TIME(h.hora_ini1) OR :HORA_ACTUAL <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (:HORA_ACTUAL >= TIME(h.hora_ini2) OR :HORA_ACTUAL <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE v.fecha_fin <= :HORA_ACTUAL_EPOCH
      AND c.estado = 'ocupado'
      AND v.cancelado = 0";
        $param = array(
            "HORA_ACTUAL" => $hora,
            "HORA_ACTUAL_EPOCH" => $horaEpoch,
        );

        $this->db->ConsultaSimple($consulta, $param);
    }

    // actualiza a ocupado todos los conductores que tengan un viaje en el momento de la llamada 
    public function ocuparConductores()
    {
        $horaEpoch = time();
        $consulta = "UPDATE Conductor c
                    JOIN Viaje v ON c.id = v.id_conductor
                    SET c.estado = 'ocupado'
                    WHERE v.fecha_ini <= :HORA_ACTUAL_EPOCH 
                    AND v.fecha_fin > :HORA_ACTUAL_EPOCH
                    AND v.cancelado = 0
                    ";
        $param = array(
            ":HORA_ACTUAL_EPOCH" => $horaEpoch,
        );

        $this->db->ConsultaSimple($consulta, $param);
    }

    //buscar conductores que no tengan viajes dentro del rango horario establecido, y que tampoco tengan viajes que se puedan solapar con el buscado
    public function buscarConductoresDisponibles($hora_ini, $hora_fin, $id_ciudad)
    {
        $consulta = " SELECT c.id, u.nombre,u.apellidos,u.telefono,c.estado,ve.fabricante,ve.modelo,ve.capacidad,ve.tipo,ve.imagen
                        FROM Conductor c
                        JOIN Usuario u ON c.id = u.id JOIN Vehiculo ve on ve.matricula = c.coche
                        WHERE c.id NOT IN (
                            SELECT v.id_conductor
                            FROM Viaje v
                            WHERE 
                                -- Viajes que empiezan antes de la hora de fin buscada y terminan después de la hora de inicio buscada (solapan con el rango deseado)
                                (v.fecha_ini < :HORA_FIN AND v.fecha_fin > :HORA_INI)
                                
                                -- Y viajes que empiezan después de la hora de fin deseada pero se solapan con un viaje existente
                                AND (v.fecha_ini >= :HORA_FIN AND EXISTS (
                                    SELECT 1
                                    FROM Viaje v2
                                    WHERE v2.id_conductor = v.id_conductor
                                    AND v2.fecha_fin > v.fecha_ini
                                ))
                        ) AND u.ciudad = :CIUDAD
                    ";
        $param = array(
            ":HORA_INI" => $hora_ini,
            ":HORA_FIN" => $hora_fin,
            ":CIUDAD" => $id_ciudad,
        );

        $this->db->ConsultaSimple($consulta, $param);




    }

    // cambia el estado del conductor a ocupado 
    public function ocuparConductor($id)
    {

        $consulta = "UPDATE Conductor SET estado = :ESTADO where id = :ID";
        $param = array(
            ":ID" => $id,
            ":ESTADO" => 'ocupado',
        );

        $this->db->ConsultaSimple($consulta, $param);
    }

    // cambia el estado de ocupado a libre o fuera de servicio dependiendo de la hora
    public function liberarConductor($id)
    {
        $hora = date('H:i:s');
        $consulta = "
        UPDATE Conductor c
    JOIN Horario h ON c.horario = h.id
    SET c.estado = CASE
         WHEN ((:HORA_ACTUAL >= TIME(h.hora_ini1) AND :HORA_ACTUAL <= TIME(h.hora_fin1)) OR
              (:HORA_ACTUAL >= TIME(h.hora_ini2) AND :HORA_ACTUAL <= TIME(h.hora_fin2)) OR
              (TIME(h.hora_ini1) > TIME(h.hora_fin1) AND (:HORA_ACTUAL >= TIME(h.hora_ini1) OR :HORA_ACTUAL <= TIME(h.hora_fin1))) OR
              (TIME(h.hora_ini2) > TIME(h.hora_fin2) AND (:HORA_ACTUAL >= TIME(h.hora_ini2) OR :HORA_ACTUAL <= TIME(h.hora_fin2))))
        THEN 'libre'
        ELSE 'fuera de servicio'
    END
    WHERE c.id = :ID
        ";
        $param = array(
            "ID" => $id,
            "HORA_ACTUAL" => $hora,
        );

        $this->db->ConsultaSimple($consulta, $param);
    }
}
