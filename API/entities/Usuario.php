<?php

class Usuario
{
    private $ID;
    private $EMAIL;
    private $TELEFONO;
    private $NOMBRE;
    private $APELLIDOS;
    private $CONTRASENA;
    private $CIUDAD;
    private $FECHA_CREACION;
    private $ROL;



    public function __get($nombre)
    {
        return $this->$nombre;
    }
    public function __set($nombre, $valor)
    {
        $this->$nombre = $valor;
    }



}
