<?php

require_once '../entities/Pasajero.php';
require_once '../database/libreriaPDO.php';


class DaoPasajero extends DB
{
    public $pasajeros = array();
 // Listar todos los pasajeros
 public function listar() {
    $consulta = "SELECT * FROM Pasajero";
    $pasajeros = $this->ConsultaDatos($consulta);
    return $pasajeros;
}

// Obtener un pasajero por su ID
public function obtener($id) {
    $consulta = "SELECT * FROM Pasajero WHERE id = :ID";
    $param = array(":ID" => $id);
    $pasajero = $this->ConsultaDatos($consulta, $param);
    return $pasajero;
}

// Insertar un nuevo pasajero
public function insertar(Pasajero $pasajero) {
    $consulta = "INSERT INTO Pasajero (id, n_tarjeta, titular_tarjeta, caducidad_tarjeta, cvv_tarjeta) 
                 VALUES (:ID, :N_TARJETA, :TITULAR_TARJETA, :CADUCIDAD_TARJETA, :CVV_TARJETA)";
    $param = array(
        ":ID" => $pasajero->__get("id"),
        ":N_TARJETA" => $pasajero->__get("n_tarjeta"),
        ":TITULAR_TARJETA" => $pasajero->__get("titular_tarjeta"),
        ":CADUCIDAD_TARJETA" => $pasajero->__get("caducidad_tarjeta"),
        ":CVV_TARJETA" => $pasajero->__get("cvv_tarjeta")
    );
    $this->ConsultaSimple($consulta, $param);
}

// Actualizar un pasajero
public function actualizar($id, Pasajero $pasajero) {
    $consulta = "UPDATE Pasajero SET n_tarjeta = :N_TARJETA, titular_tarjeta = :TITULAR_TARJETA, 
                 caducidad_tarjeta = :CADUCIDAD_TARJETA, cvv_tarjeta = :CVV_TARJETA 
                 WHERE id = :ID";
    $param = array(
        ":ID" => $id,
        ":N_TARJETA" => $pasajero->__get("n_tarjeta"),
        ":TITULAR_TARJETA" => $pasajero->__get("titular_tarjeta"),
        ":CADUCIDAD_TARJETA" => $pasajero->__get("caducidad_tarjeta"),
        ":CVV_TARJETA" => $pasajero->__get("cvv_tarjeta")
    );
    $this->ConsultaSimple($consulta, $param);
}

// Eliminar un pasajero
public function eliminar($id) {
    $consulta = "DELETE FROM Pasajero WHERE id = :ID";
    $param = array(":ID" => $id);
    $this->ConsultaSimple($consulta, $param);
}
}
