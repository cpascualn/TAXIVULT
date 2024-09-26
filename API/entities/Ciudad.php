<?php
class Ciudad {
    private $id;
    private $nombre;
    private $comunidad;
    private $pais;

    public function __construct($nombre, $comunidad, $pais, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->comunidad = $comunidad;
        $this->pais = $pais;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
