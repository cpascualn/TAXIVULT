<?php
namespace App\Entities;
use JsonSerializable;
class Viaje implements JsonSerializable
{
    private $id;
    private $id_conductor;
    private $id_pasajero;
    private $lati_ini;
    private $longi_ini;
    private $lati_fin;
    private $longi_fin;
    private $fecha_ini;
    private $fecha_fin;
    private $metodo_pago;
    private $cancelado;
    private $fecha_cancelacion;
    private $distancia;
    private $duracion_min;
    private $precio_total;
    private $ciudad;
    private $lugar_salida;
    private $lugar_llegada;

    public function __construct($id_conductor, $id_pasajero, $lati_ini, $longi_ini, $lati_fin, $longi_fin, $fecha_ini, $fecha_fin, $metodo_pago, $cancelado, $fecha_cancelacion = null, $distancia = null, $duracion_min = null, $precio_total = null, $id = null)
    {
        $this->id = $id;
        $this->id_conductor = $id_conductor;
        $this->id_pasajero = $id_pasajero;
        $this->lati_ini = $lati_ini;
        $this->longi_ini = $longi_ini;
        $this->lati_fin = $lati_fin;
        $this->longi_fin = $longi_fin;
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
        $this->metodo_pago = $metodo_pago;
        $this->cancelado = $cancelado;
        $this->fecha_cancelacion = $fecha_cancelacion;
        $this->distancia = $distancia;
        $this->duracion_min = $duracion_min;
        $this->precio_total = $precio_total;
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

    public function getIdConductor()
    {
        return $this->id_conductor;
    }

    public function setIdConductor($id_conductor)
    {
        $this->id_conductor = $id_conductor;
    }

    public function getIdPasajero()
    {
        return $this->id_pasajero;
    }

    public function setIdPasajero($id_pasajero)
    {
        $this->id_pasajero = $id_pasajero;
    }

    public function getLatiIni()
    {
        return $this->lati_ini;
    }

    public function setLatiIni($lati_ini)
    {
        $this->lati_ini = $lati_ini;
    }

    public function getLongiIni()
    {
        return $this->longi_ini;
    }

    public function setLongiIni($longi_ini)
    {
        $this->longi_ini = $longi_ini;
    }

    public function getLatiFin()
    {
        return $this->lati_fin;
    }

    public function setLatiFin($lati_fin)
    {
        $this->lati_fin = $lati_fin;
    }

    public function getLongiFin()
    {
        return $this->longi_fin;
    }

    public function setLongiFin($longi_fin)
    {
        $this->longi_fin = $longi_fin;
    }

    public function getFechaIni()
    {
        return $this->fecha_ini;
    }

    public function setFechaIni($fecha_ini)
    {
        $this->fecha_ini = $fecha_ini;
    }

    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    public function getMetodoPago()
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago($metodo_pago)
    {
        $this->metodo_pago = $metodo_pago;
    }

    public function getCancelado()
    {
        return $this->cancelado;
    }

    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;
    }

    public function getFechaCancelacion()
    {
        return $this->fecha_cancelacion;
    }

    public function setFechaCancelacion($fecha_cancelacion)
    {
        $this->fecha_cancelacion = $fecha_cancelacion;
    }

    public function getDistancia()
    {
        return $this->distancia;
    }

    public function setDistancia($distancia)
    {
        $this->distancia = $distancia;
    }

    public function getDuracionMin()
    {
        return $this->duracion_min;
    }

    public function setDuracionMin($duracion_min)
    {
        $this->duracion_min = $duracion_min;
    }

    public function getPrecioTotal()
    {
        return $this->precio_total;
    }

    public function setPrecioTotal($precio_total)
    {
        $this->precio_total = $precio_total;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }
    public function getLugarSalida()
    {
        return $this->lugar_salida;
    }
    public function setLugarSalida($lugar_salida)
    {
        $this->lugar_salida = $lugar_salida;
    }
    public function getLugarLlegada()
    {
        return $this->lugar_llegada;
    }
    public function setLugarLlegada($lugar_llegada)
    {
        $this->lugar_llegada = $lugar_llegada;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'id_conductor' => $this->getIdConductor(),
            'id_pasajero' => $this->getIdPasajero(),
            'lati_ini' => $this->getLatiIni(),
            'longi_ini' => $this->getLongiIni(),
            'lati_fin' => $this->getLatiFin(),
            'longi_fin' => $this->getLongiFin(),
            'fecha_ini' => $this->getFechaIni(),
            'fecha_fin' => $this->getFechaFin(),
            'metodo_pago' => $this->getMetodoPago(),
            'cancelado' => $this->getCancelado(),
            'fecha_cancelacion' => $this->getFechaCancelacion(),
            'distancia' => $this->getDistancia(),
            'duracion_min' => $this->getDuracionMin(),
            'precio_total' => $this->getPrecioTotal(),
            'ciudad' => $this->getCiudad(),
            'lugar_salida' => $this->getLugarSalida(),
            'lugar_llegada' => $this->getLugarLlegada(),
        ];
    }
}
