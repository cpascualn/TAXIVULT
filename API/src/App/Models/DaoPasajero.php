<?php
namespace App\Models;
use App\Database\Database;

use App\Entities\Pasajero;


class DaoPasajero extends Database
{
    public $pasajeros = array();


    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    // Listar todos los pasajeros
    public function listar()
    {
        $consulta = "SELECT * FROM Pasajero";
        $this->db->ConsultaDatos($consulta);
        $this->pasajeros = [];
        foreach ($this->db->filas as $fila) {
            $pasajero = new Pasajero();
            $pasajero->setId($fila['id']);
            $pasajero->setNTarjeta($fila['n_tarjeta']);
            $pasajero->setTitularTarjeta($fila['titular_tarjeta']);
            $pasajero->setCaducidadTarjeta($fila['caducidad_tarjeta']);
            $pasajero->setCvvTarjeta($fila['cvv_tarjeta']);
            $this->pasajeros[] = $pasajero;
        }
        return $this->pasajeros;
    }

    // Obtener un pasajero por su ID
    public function obtener($id)
    {
        $consulta = "SELECT * FROM Pasajero WHERE id = :ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaDatos($consulta, $param);

        $pasajero = null;
        if (count($this->db->filas) == 1) {

            $pasajero = new Pasajero();
            $fila = $this->db->filas[0];  //Recuperamos la fila devuelta
            $pasajero = new Pasajero();
            $pasajero->setId($fila['id']);
            $pasajero->setNTarjeta($fila['n_tarjeta']);
            $pasajero->setTitularTarjeta($fila['titular_tarjeta']);
            $pasajero->setCaducidadTarjeta($fila['caducidad_tarjeta']);
            $pasajero->setCvvTarjeta($fila['cvv_tarjeta']);

        }
        return $pasajero;
    }

    // Insertar un nuevo pasajero
    public function insertar(Pasajero $pasajero)
    {
        $consulta = "INSERT INTO Pasajero (id, n_tarjeta, titular_tarjeta, caducidad_tarjeta, cvv_tarjeta) 
                 VALUES (:ID, :N_TARJETA, :TITULAR_TARJETA, :CADUCIDAD_TARJETA, :CVV_TARJETA)";
        $param = array(
            ":ID" => $pasajero->getId(),
            ":N_TARJETA" => $pasajero->getNTarjeta(),
            ":TITULAR_TARJETA" => $pasajero->getTitularTarjeta(),
            ":CADUCIDAD_TARJETA" => $pasajero->getCaducidadTarjeta(),
            ":CVV_TARJETA" => $pasajero->getCvvTarjeta()
        );
        $this->db->ConsultaSimple($consulta, $param);
    }

    // Actualizar un pasajero
    public function actualizar($id, $pasajero, $nuevo)
    {
        $consulta = "UPDATE Pasajero SET n_tarjeta = :N_TARJETA, titular_tarjeta = :TITULAR_TARJETA, 
                 caducidad_tarjeta = :CADUCIDAD_TARJETA, cvv_tarjeta = :CVV_TARJETA 
                 WHERE id = :ID";
        $param = array(
            ":ID" => $id,
            ":N_TARJETA" => $nuevo->getNTarjeta() ?? $pasajero->getNTarjeta(),
            ":TITULAR_TARJETA" => $nuevo->getTitularTarjeta() ?? $pasajero->getTitularTarjeta(),
            ":CADUCIDAD_TARJETA" => $nuevo->getCaducidadTarjeta() ?? $pasajero->getCaducidadTarjeta(),
            ":CVV_TARJETA" => $nuevo->getCvvTarjeta() ?? $pasajero->getCvvTarjeta()
        );
        $this->db->ConsultaSimple($consulta, $param);
    }

    // Eliminar un pasajero
    public function eliminar($id)
    {
        $consulta = "DELETE FROM Pasajero WHERE id = :ID";
        $param = array(":ID" => $id);
        $this->db->ConsultaSimple($consulta, $param);
    }
}
