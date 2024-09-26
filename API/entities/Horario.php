<?php
class Horario {
    private $id;
    private $nombre;
    private $hora_ini1;
    private $hora_fin1;
    private $hora_ini2;
    private $hora_fin2;
    private $tarifa_dia;
    private $tarifa_minuto;

    public function __construct($nombre, $hora_ini1, $hora_fin1, $tarifa_dia, $tarifa_minuto, $hora_ini2 = null, $hora_fin2 = null, $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->hora_ini1 = $hora_ini1;
        $this->hora_fin1 = $hora_fin1;
        $this->hora_ini2 = $hora_ini2;
        $this->hora_fin2 = $hora_fin2;
        $this->tarifa_dia = $tarifa_dia;
        $this->tarifa_minuto = $tarifa_minuto;
    }

    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
