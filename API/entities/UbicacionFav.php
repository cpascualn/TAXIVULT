<?php
class UbicacionFav {
    private $id;
    private $nombre;
    private $longitud;
    private $latitud;

    public function __construct($nombre, $longitud, $latitud, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->longitud = $longitud;
        $this->latitud = $latitud;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
