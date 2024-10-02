<?php
namespace App\Entities;
use JsonSerializable;
class Horario implements JsonSerializable
{
    private $id;
    private $nombre;
    private $hora_ini1;
    private $hora_fin1;
    private $hora_ini2;
    private $hora_fin2;
    private $tarifa_dia;
    private $tarifa_minuto;

    public function __construct($nombre, $hora_ini1, $hora_fin1, $tarifa_dia, $tarifa_minuto, $hora_ini2 = null, $hora_fin2 = null, $id = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->hora_ini1 = $hora_ini1;
        $this->hora_fin1 = $hora_fin1;
        $this->hora_ini2 = $hora_ini2;
        $this->hora_fin2 = $hora_fin2;
        $this->tarifa_dia = $tarifa_dia;
        $this->tarifa_minuto = $tarifa_minuto;
    }

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

    public function getHoraIni1()
    {
        return $this->hora_ini1;
    }

    public function setHoraIni1($hora_ini1)
    {
        $this->hora_ini1 = $hora_ini1;
    }

    public function getHoraFin1()
    {
        return $this->hora_fin1;
    }

    public function setHoraFin1($hora_fin1)
    {
        $this->hora_fin1 = $hora_fin1;
    }

    public function getHoraIni2()
    {
        return $this->hora_ini2;
    }

    public function setHoraIni2($hora_ini2)
    {
        $this->hora_ini2 = $hora_ini2;
    }

    public function getHoraFin2()
    {
        return $this->hora_fin2;
    }

    public function setHoraFin2($hora_fin2)
    {
        $this->hora_fin2 = $hora_fin2;
    }

    public function getTarifaDia()
    {
        return $this->tarifa_dia;
    }

    public function setTarifaDia($tarifa_dia)
    {
        $this->tarifa_dia = $tarifa_dia;
    }

    public function getTarifaMinuto()
    {
        return $this->tarifa_minuto;
    }

    public function setTarifaMinuto($tarifa_minuto)
    {
        $this->tarifa_minuto = $tarifa_minuto;
    }

    // Implementación de JsonSerializable

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'hora_ini1' => $this->getHoraIni1(),
            'hora_fin1' => $this->getHoraFin1(),
            'hora_ini2' => $this->getHoraIni2(),
            'hora_fin2' => $this->getHoraFin2(),
            'tarifa_dia' => $this->getTarifaDia(),
            'tarifa_minuto' => $this->getTarifaMinuto(),
        ];
    }


}
