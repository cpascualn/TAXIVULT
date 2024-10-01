<?php

require_once APP_ROOT . '/entities/Pasajero.php';
require_once APP_ROOT . '/database/LibreriaPDO.php';


class DaoPasajero extends DB
{
    public $pasajeros = array();
 // Listar todos los pasajeros
 public function listar() {
    $consulta = "SELECT * FROM Pasajero";
    $this->ConsultaDatos($consulta);
    $this->pasajeros = [];
    foreach ($this->filas as $fila) {
    $pasajero = new Pasajero();
    $pasajero->__set("id", $fila['id']);
    $pasajero->__set("n_tarjeta", $fila['n_tarjeta']);
    $pasajero->__set("titular_tarjeta", $fila['titular_tarjeta']);
    $pasajero->__set("caducidad_tarjeta", $fila['caducidad_tarjeta']);
    $pasajero->__set("cvv_tarjeta", $fila['cvv_tarjeta']);
    $this->pasajeros[] = $pasajero;
    }
    return $this->pasajeros;
}

// Obtener un pasajero por su ID
public function obtener($id) {
    $consulta = "SELECT * FROM Pasajero WHERE id = :ID";
    $param = array(":ID" => $id);
    $this->ConsultaDatos($consulta, $param);

    $pasajero = null;
    if (count($this->filas) == 1) {
        
        $pasajero = new Pasajero();
        $fila = $this->filas[0];  //Recuperamos la fila devuelta
        $pasajero = new Pasajero();
        $pasajero->__set("id", $fila['id']);
        $pasajero->__set("n_tarjeta", $fila['n_tarjeta']);
        $pasajero->__set("titular_tarjeta", $fila['titular_tarjeta']);
        $pasajero->__set("caducidad_tarjeta", $fila['caducidad_tarjeta']);
        $pasajero->__set("cvv_tarjeta", $fila['cvv_tarjeta']);

    }
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
public function actualizar($id,  $pasajero, $nuevo) {
    $consulta = "UPDATE Pasajero SET n_tarjeta = :N_TARJETA, titular_tarjeta = :TITULAR_TARJETA, 
                 caducidad_tarjeta = :CADUCIDAD_TARJETA, cvv_tarjeta = :CVV_TARJETA 
                 WHERE id = :ID";
    $param = array(
        ":ID" => $id,
        ":N_TARJETA" => $nuevo->__get("n_tarjeta") ?? $pasajero->__get("n_tarjeta"),
        ":TITULAR_TARJETA" => $nuevo->__get("titular_tarjeta") ?? $pasajero->__get("n_tarjeta"),
        ":CADUCIDAD_TARJETA" => $nuevo->__get("caducidad_tarjeta") ?? $pasajero->__get("n_tarjeta"),
        ":CVV_TARJETA" => $nuevo->__get("cvv_tarjeta") ?? $pasajero->__get("n_tarjeta")
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
