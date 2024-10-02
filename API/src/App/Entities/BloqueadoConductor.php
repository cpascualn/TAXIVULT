<?php
namespace App\Entities;
use JsonSerializable;

class BloqueadoConductor implements JsonSerializable{
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

    public function getIdConductor() {
        return $this->id_conductor;
    }
    
    public function setIdConductor($id_conductor) {
        $this->id_conductor = $id_conductor;
    }
    
    public function getIdPasajero() {
        return $this->id_pasajero;
    }
    
    public function setIdPasajero($id_pasajero) {
        $this->id_pasajero = $id_pasajero;
    }
    
    // Implementación de JsonSerializable
    
    public function jsonSerialize(): array {
        return [
            'id_conductor' => $this->getIdConductor(),
            'id_pasajero' => $this->getIdPasajero(),
        ];
    }
    
}
