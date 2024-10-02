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

}
