<?php
namespace App\Entities;
use JsonSerializable;
class Vehiculo implements JsonSerializable{
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


    public function getId() {
        return $this->id;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getFabricante() {
        return $this->fabricante;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getConductor() {
        return $this->conductor;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }

    public function setFabricante($fabricante) {
        $this->fabricante = $fabricante;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function setConductor($conductor) {
        $this->conductor = $conductor;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'matricula' => $this->matricula,
            'capacidad' => $this->capacidad,
            'fabricante' => $this->fabricante,
            'modelo' => $this->modelo,
            'tipo' => $this->tipo,
            'imagen' => $this->imagen,
            'conductor' => $this->conductor,
        ];
    }
}
