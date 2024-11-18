<?php
namespace App\Entities;
use JsonSerializable;
class Usuario implements JsonSerializable
{
    private $id;
    private $email;
    private $telefono;
    private $nombre;
    private $apellidos;
    private $contrasena;
    private $ciudad;
    private $fecha_creacion;
    private $rol;



    public function __get($nombre)
    {
        return $this->$nombre;
    }
    public function __set($nombre, $valor)
    {
        $this->$nombre = $valor;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    public function getRol()
    {
        return $this->rol;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }

    public function setFechaCreacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'telefono' => $this->telefono,
            'contrasena' => $this->contrasena,
            'ciudad' => $this->ciudad,
            'fecha_creacion' => $this->fecha_creacion,
            'rol' => $this->rol,
        ];
    }


}
