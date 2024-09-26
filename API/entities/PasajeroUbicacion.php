<?php
class PasajeroUbicacion {
    private $id_ubicacion;
    private $id_pasajero;

    public function __construct($id_ubicacion, $id_pasajero) {
        $this->id_ubicacion = $id_ubicacion;
        $this->id_pasajero = $id_pasajero;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
