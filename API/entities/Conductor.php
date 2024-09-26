<?php
class Conductor {
    private $id;
    private $dni;
    private $licencia_taxista;
    private $titular_tarjeta;
    private $iban_tarjeta;
    private $long_espera;
    private $lati_espera;
    private $estado;
    private $coche;
    private $horario;


    public function __get($propiedad) {
        return $this->$propiedad;
    }

    public function __set($propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}
