<?php
namespace App\Entities;
use JsonSerializable;
class UbicacionFav implements JsonSerializable{
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


    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function getLongitud() {
        return $this->longitud;
    }
    
    public function setLongitud($longitud) {
        $this->longitud = $longitud;
    }
    
    public function getLatitud() {
        return $this->latitud;
    }
    
    public function setLatitud($latitud) {
        $this->latitud = $latitud;
    }
    
    // Implementación de JsonSerializable
    
    public function jsonSerialize(): array {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'longitud' => $this->getLongitud(),
            'latitud' => $this->getLatitud(),
        ];
    }
}
