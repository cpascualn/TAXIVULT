<?php
class Rol {
    private $id;
    private $nombre;

    public function __construct($nombre, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
