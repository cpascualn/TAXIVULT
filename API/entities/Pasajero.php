<?php
class Pasajero {
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
}
