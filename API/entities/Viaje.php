<?php
class Viaje {
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

    public function __construct($id_conductor, $id_pasajero, $lati_ini, $longi_ini, $lati_fin, $longi_fin, $fecha_ini, $fecha_fin, $metodo_pago, $cancelado, $fecha_cancelacion = null, $distancia = null, $duracion_min = null, $precio_total = null, $id = null) {
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

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
