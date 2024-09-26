<?php
class Vehiculo {
    private $id;
    private $matricula;
    private $capacidad;
    private $fabricante;
    private $modelo;
    private $tipo;
    private $imagen;
    private $conductor;

    public function __construct($matricula, $capacidad, $fabricante, $modelo, $tipo, $imagen = null, $conductor = null, $id = null) {
        $this->id = $id;
        $this->matricula = $matricula;
        $this->capacidad = $capacidad;
        $this->fabricante = $fabricante;
        $this->modelo = $modelo;
        $this->tipo = $tipo;
        $this->imagen = $imagen;
        $this->conductor = $conductor;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
