<?php
namespace App\Entities;
use JsonSerializable;
class ConductorDisponible implements JsonSerializable
{
    private $id;
    private $nombre;
    private $telefono;
    private $estado;
    private $fabricante;
    private $modelo;
    private $capacidad;
    private $tipo;
    private $imagen;
    private $ubi_espera;

    public function __get($propiedad)
    {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    // Getter y Setter para telefono
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    // Getter y Setter para estado
    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    // Getter y Setter para fabricante
    public function getFabricante()
    {
        return $this->fabricante;
    }

    public function setFabricante($fabricante)
    {
        $this->fabricante = $fabricante;
    }

    // Getter y Setter para modelo
    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    // Getter y Setter para capacidad
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;
    }

    // Getter y Setter para tipo
    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    // Getter y Setter para imagen
    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function getUbiEspera()
    {
        return $this->ubi_espera;
    }

    public function setUbiEspera($ubi_espera)
    {
        $this->ubi_espera = $ubi_espera;
    }
    // Implementación de JsonSerializable

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'telefono' => $this->getTelefono(),
            'estado' => $this->getEstado(),
            'fabricante' => $this->getFabricante(),
            'modelo' => $this->getModelo(),
            'capacidad' => $this->getCapacidad(),
            'tipo' => $this->getTipo(),
            'imagen' => $this->getImagen(),
            'ubi_espera' => $this->getUbiEspera(),

        ];
    }
}
