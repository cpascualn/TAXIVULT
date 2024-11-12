<?php
namespace App\Entities;
use JsonSerializable;
class Conductor implements JsonSerializable
{
    private $id;
    private $dni;
    private $licencia_taxista;
    private $titular_tarjeta;
    private $iban_tarjeta;
    private $ubi_espera;
    private $long_espera;
    private $lati_espera;
    private $estado;
    private $coche;
    private $horario;


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

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getLicenciaTaxista()
    {
        return $this->licencia_taxista;
    }

    public function setLicenciaTaxista($licencia_taxista)
    {
        $this->licencia_taxista = $licencia_taxista;
    }

    public function getTitularTarjeta()
    {
        return $this->titular_tarjeta;
    }

    public function setTitularTarjeta($titular_tarjeta)
    {
        $this->titular_tarjeta = $titular_tarjeta;
    }

    public function getIbanTarjeta()
    {
        return $this->iban_tarjeta;
    }

    public function setIbanTarjeta($iban_tarjeta)
    {
        $this->iban_tarjeta = $iban_tarjeta;
    }

    public function getUbiEspera()
    {
        return $this->ubi_espera;
    }

    public function setUbiEspera($ubi_espera)
    {
        $this->ubi_espera = $ubi_espera;
    }

    public function getLongEspera()
    {
        return $this->long_espera;
    }

    public function setLongEspera($long_espera)
    {
        $this->long_espera = $long_espera;
    }

    public function getLatiEspera()
    {
        return $this->lati_espera;
    }

    public function setLatiEspera($lati_espera)
    {
        $this->lati_espera = $lati_espera;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getCoche()
    {
        return $this->coche;
    }

    public function setCoche($coche)
    {
        $this->coche = $coche;
    }

    public function getHorario()
    {
        return $this->horario;
    }

    public function setHorario($horario)
    {
        $this->horario = $horario;
    }

    // Implementación de JsonSerializable

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'dni' => $this->getDni(),
            'licencia_taxista' => $this->getLicenciaTaxista(),
            'titular_tarjeta' => $this->getTitularTarjeta(),
            'iban_tarjeta' => $this->getIbanTarjeta(),
            'ubi_espera' => $this->getUbiEspera(),
            'long_espera' => $this->getLongEspera(),
            'lati_espera' => $this->getLatiEspera(),
            'estado' => $this->getEstado(),
            'coche' => $this->getCoche(),
            'horario' => $this->getHorario(),
        ];
    }
}
