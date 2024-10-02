<?php
namespace App\Entities;
use JsonSerializable;
class PasajeroUbicacion implements JsonSerializable{
    private $id_ubicacion;
    private $id_pasajero;

    public function __construct($id_ubicacion, $id_pasajero) {
        $this->id_ubicacion = $id_ubicacion;
        $this->id_pasajero = $id_pasajero;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    public function getIdUbicacion() {
        return $this->id_ubicacion;
    }
    
    public function setIdUbicacion($id_ubicacion) {
        $this->id_ubicacion = $id_ubicacion;
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
            'id_ubicacion' => $this->getIdUbicacion(),
            'id_pasajero' => $this->getIdPasajero(),
        ];
    }
}
