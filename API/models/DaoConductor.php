<?php

require_once '../entities/Conductor.php';
require_once '../database/libreriaPDO.php';

class DaoConductor extends DB
{
    public $conductores = array();

    public function listar() {
        $consulta = "SELECT * FROM Conductor";
        $this->ConsultaDatos($consulta);

        foreach ($this->filas as $fila) {
            $con = new Conductor();
            $con->__set("id", $fila['id']);
            $con->__set("dni", $fila['dni']);
            $con->__set("licencia_taxista", $fila['licencia_taxista']);
            $con->__set("titular_tarjeta", $fila['titular_tarjeta']);
            $con->__set("iban_tarjeta", $fila['iban_tarjeta']);
            $con->__set("long_espera", $fila['long_espera']);
            $con->__set("lati_espera", $fila['lati_espera']);
            $con->__set("estado", $fila['estado']);
            $con->__set("coche", $fila['coche']);
            $con->__set("horario", $fila['horario']);

            $this->conductores[] = $con;   //Insertamos el objeto con los valores de esa fila en el array de objetos

        }

        return $this->conductores;
    }

    // Obtener un conductor por su ID
    public function obtener($id) {
        $consulta = "SELECT * FROM Conductor WHERE id = :ID";
        $param = array(":ID" => $id);
         $this->ConsultaDatos($consulta, $param);

        $conductor = null; 

        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  //Recuperamos la fila devuelta
            $conductor = new Usuario();
            $conductor->__set("id", $fila['id']);
            $conductor->__set("dni", $fila['dni']);
            $conductor->__set("licencia_taxista", $fila['licencia_taxista']);
            $conductor->__set("titular_tarjeta", $fila['titular_tarjeta']);
            $conductor->__set("iban_tarjeta", $fila['iban_tarjeta']);
            $conductor->__set("long_espera", $fila['long_espera']);
            $conductor->__set("lati_espera", $fila['lati_espera']);
            $conductor->__set("estado", $fila['estado']);
            $conductor->__set("coche", $fila['coche']);
            $conductor->__set("horario", $fila['horario']);
        }

        return $conductor;
    }

    // Insertar un nuevo conductor
    public function insertar($conductor) {
        $consulta = "INSERT INTO Conductor (id, dni, licencia_taxista, titular_tarjeta, iban_tarjeta, long_espera, lati_espera, estado, coche, horario) 
                     VALUES (:ID, :DNI, :LICENCIA_TAXISTA, :TITULAR_TARJETA, :IBAN_TARJETA, :long_espera, :LATI_ESPERA, :ESTADO, :COCHE, :HORARIO)";
        $param = array(
            ":ID" => $conductor->__get("id"),
            ":DNI" => $conductor->__get("dni"),
            ":LICENCIA_TAXISTA" => $conductor->__get("licencia_taxista"),
            ":TITULAR_TARJETA" => $conductor->__get("titular_tarjeta"),
            ":IBAN_TARJETA" => $conductor->__get("iban_tarjeta"),
            ":long_espera" => $conductor->__get("long_espera"),
            ":LATI_ESPERA" => $conductor->__get("lati_espera"),
            ":ESTADO" => $conductor->__get("estado"),
            ":COCHE" => $conductor->__get("coche"),
            ":HORARIO" => $conductor->__get("horario")
        );
        $this->ConsultaSimple($consulta, $param);
    }

    // Actualizar un conductor
    public function actualizar($id, $conductor,$nuevo) {
        $consulta = "UPDATE Conductor SET dni = :DNI, licencia_taxista = :LICENCIA_TAXISTA, titular_tarjeta = :TITULAR_TARJETA, 
                     iban_tarjeta = :IBAN_TARJETA, long_espera = :long_espera, lati_espera = :LATI_ESPERA, estado = :ESTADO, 
                     coche = :COCHE, horario = :HORARIO 
                     WHERE id = :ID";


        $param = array(
            ":ID" => $id,
            ":DNI" => $nuevo->__get("dni") ?? $conductor->__get("dni"),
            ":LICENCIA_TAXISTA" => $nuevo->__get("licencia_taxista") ?? $conductor->__get("licencia_taxista"),
            ":TITULAR_TARJETA" => $nuevo->__get("titular_tarjeta") ?? $conductor->__get("titular_tarjeta"),
            ":IBAN_TARJETA" => $nuevo->__get("iban_tarjeta") ?? $conductor->__get("iban_tarjeta"),
            ":long_espera" => $nuevo->__get("long_espera") ?? $conductor->__get("long_espera"),
            ":LATI_ESPERA" => $nuevo->__get("lati_espera") ?? $conductor->__get("lati_espera"),
            ":ESTADO" => $nuevo->__get("estado") ?? $conductor->__get("estado"),
            ":COCHE" => $nuevo->__get("coche") ?? $conductor->__get("coche"),
            ":HORARIO" => $nuevo->__get("horario") ?? $conductor->__get("horario")
        );
        $this->ConsultaSimple($consulta, $param);
    }

    // Eliminar un conductor
    public function eliminar($id) {
        $consulta = "DELETE FROM Conductor WHERE id = :ID";
        $param = array(":ID" => $id);
        $this->ConsultaSimple($consulta, $param);
    }

}
