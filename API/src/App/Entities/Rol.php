<?php
namespace App\Entities;
use JsonSerializable;
class Rol implements JsonSerializable{
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
    public function getId(){
        return $this->id;
    }
    public function setId($id){
       $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
       $this->nombre = $nombre;
    }


    public function jsonSerialize(): array {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
        ];
    }
}
