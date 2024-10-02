<?php
namespace App\Entities;
use JsonSerializable;
class Pasajero implements JsonSerializable{
    private $id;
    private $n_tarjeta;
    private $titular_tarjeta;
    private $caducidad_tarjeta;
    private $cvv_tarjeta;


    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }


public function getId() {
    return $this->id;
}

public function setId($id) {
    $this->id = $id;
}

public function getNTarjeta() {
    return $this->n_tarjeta;
}

public function setNTarjeta($n_tarjeta) {
    $this->n_tarjeta = $n_tarjeta;
}

public function getTitularTarjeta() {
    return $this->titular_tarjeta;
}

public function setTitularTarjeta($titular_tarjeta) {
    $this->titular_tarjeta = $titular_tarjeta;
}

public function getCaducidadTarjeta() {
    return $this->caducidad_tarjeta;
}

public function setCaducidadTarjeta($caducidad_tarjeta) {
    $this->caducidad_tarjeta = $caducidad_tarjeta;
}

public function getCvvTarjeta() {
    return $this->cvv_tarjeta;
}

public function setCvvTarjeta($cvv_tarjeta) {
    $this->cvv_tarjeta = $cvv_tarjeta;
}

// Implementación de JsonSerializable

public function jsonSerialize(): array {
    return [
        'id' => $this->getId(),
        'n_tarjeta' => $this->getNTarjeta(),
        'titular_tarjeta' => $this->getTitularTarjeta(),
        'caducidad_tarjeta' => $this->getCaducidadTarjeta(),
        'cvv_tarjeta' => $this->getCvvTarjeta(),
    ];
}
}
