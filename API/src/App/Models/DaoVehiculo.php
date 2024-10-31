<?php
namespace App\Models;
use App\Database\Database;
use App\Entities\Vehiculo;

class DaoVehiculo
{

    public $vehiculos = array();
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function listar()       //Lista el contenido de la tabla
    {

    }

    public function obtener($id)          //Obtenemos el elemento a partir de su Id
    {

    }

    public function insertar($vehiculo)
    {
        $consulta = "INSERT INTO `Vehiculo` (matricula, capacidad, fabricante, modelo, tipo, imagen, conductor) VALUES( :MATRICULA, :CAPACIDAD, :FABRICANTE, :MODELO, :TIPO, :IMAGEN, :CONDUCTOR);";
        $param = array();

        $param[":MATRICULA"] = $vehiculo->getMatricula();
        $param[":CAPACIDAD"] = $vehiculo->getCapacidad();
        $param[":FABRICANTE"] = $vehiculo->getFabricante();
        $param[":MODELO"] = $vehiculo->getModelo();
        $param[":TIPO"] = $vehiculo->getTipo();
        $param[":IMAGEN"] = $vehiculo->getImagen();
        $param[":CONDUCTOR"] = $vehiculo->getConductor();

        $this->db->ConsultaSimple($consulta, $param);
    }

    public function actualizar($id, $vehiculo, $nuevo)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `Vehiculo` SET `matricula`=:MATRICULA,`capacidad`=:CAPACIDAD,`fabricante`=:FABRICANTE,`modelo`=:MODELO,`tipo`=:TIPO,`imagen`=:IMAGEN WHERE id = :ID";

        $param = array();

        $param[":ID"] = $id;
        $param[":MATRICULA"] = $nuevo->getMatricula() ?? $vehiculo->getMatricula();
        $param[":CAPACIDAD"] = $nuevo->getCapacidad() ?? $vehiculo->getCapacidad();
        $param[":FABRICANTE"] = $nuevo->getFabricante() ?? $vehiculo->getFabricante();
        $param[":MODELO"] = $nuevo->getModelo() ?? $vehiculo->getModelo();
        $param[":TIPO"] = $nuevo->getTipo() ?? $vehiculo->getTipo();
        $param[":IMAGEN"] = $nuevo->getImagen() ?? $vehiculo->getImagen();


        $this->db->ConsultaSimple($consulta, $param);

    }

    public function actualizarConductor($id = null, $matricula = null, $conductorId = null)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "UPDATE `Vehiculo` SET `conductor`=:CONDUCTOR WHERE id = :ID or matricula =:MATRICULA";

        $param = array();

        $param[":ID"] = $id;
        $param[":CONDUCTOR"] = $conductorId;
        $param[":MATRICULA"] = $matricula;


        $this->db->ConsultaSimple($consulta, $param);
    }

    public function eliminar($id, $matricula = null)          //Obtenemos el elemento a partir de su Id
    {
        $consulta = "DELETE FROM Vehiculo WHERE id=:ID or matricula =:MATRICULA";
        $param = array();
        $param[":ID"] = $id ?? null;
        $param[":MATRICULA"] = $matricula;
        $this->db->ConsultaSimple($consulta, $param);
    }

}