<?php
namespace App\Entities;
use JsonSerializable;
class Ciudad implements JsonSerializable
{
    private $id;
    private $nombre;
    private $comunidad;
    private $pais;
    private $lat;
    private $long;
    private $long_min;
    private $long_max;
    private $lat_min;
    private $lat_max;
    private $usuarios;
    private $viajes;


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

    public function getComunidad()
    {
        return $this->comunidad;
    }

    public function setComunidad($comunidad)
    {
        $this->comunidad = $comunidad;
    }

    public function getPais()
    {
        return $this->pais;
    }

    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    public function getLat()
    {
        return $this->lat;
    }
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLong()
    {
        return $this->long;
    }
    public function setLong($long)
    {
        $this->long = $long;
    }
    public function getLong_min()
    {
        return $this->long_min;
    }
    public function setLong_min($long_min)
    {
        $this->long_min = $long_min;
    }
    public function getLong_max()
    {
        return $this->long_max;
    }
    public function setLong_max($long_max)
    {
        $this->long_max = $long_max;
    }
    public function getLat_min()
    {
        return $this->lat_min;
    }
    public function setLat_min($lat_min)
    {
        $this->lat_min = $lat_min;
    }
    public function getLat_max()
    {
        return $this->lat_max;
    }
    public function setLat_max($lat_max)
    {
        $this->lat_max = $lat_max;
    }
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    public function setUsuarios($usuarios)
    {
        $this->usuarios = $usuarios;
    }
    public function getViajes()
    {
        return $this->viajes;
    }
    public function setViajes($viajes)
    {
        $this->viajes = $viajes;
    }

    // Implementación de JsonSerializable

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'comunidad' => $this->getComunidad(),
            'pais' => $this->getPais(),
            'lat' => $this->getLat(),
            'long' => $this->getLong(),
            'long_min' => $this->getLong_min(),
            'long_max' => $this->getLong_max(),
            'lat_min' => $this->getLat_min(),
            'lat_max' => $this->getLat_max(),
            'usuarios' => $this->getUsuarios(),
            'viajes' => $this->getViajes(),
        ];
    }
}
