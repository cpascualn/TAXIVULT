<?php
class BloqueadoConductor {
    private $id_conductor;
    private $id_pasajero;

    public function __construct($id_conductor, $id_pasajero) {
        $this->id_conductor = $id_conductor;
        $this->id_pasajero = $id_pasajero;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
