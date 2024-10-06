<?php
namespace App\Entities;
use JsonSerializable;
class Ciudad implements JsonSerializable{
    private $id;
    private $nombre;
    private $comunidad;
    private $pais;


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
    
    public function getComunidad() {
        return $this->comunidad;
    }
    
    public function setComunidad($comunidad) {
        $this->comunidad = $comunidad;
    }
    
    public function getPais() {
        return $this->pais;
    }
    
    public function setPais($pais) {
        $this->pais = $pais;
    }
    
    // Implementación de JsonSerializable
    
    public function jsonSerialize(): array {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'comunidad' => $this->getComunidad(),
            'pais' => $this->getPais(),
        ];
    }
}
